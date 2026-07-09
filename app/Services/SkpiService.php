<?php

namespace App\Services;

use App\Models\Mahasiswa;
use App\Models\PengajuanSkpi;
use App\Models\Skpi;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SkpiService
{
    public function __construct(
        private PengajuanService $pengajuanService,
        private CacheService $cache
    ) {}

    public function generateNomorSkpi(string $kodeFakultas): string
    {
        $kodeFakultasAngka = match (strtoupper($kodeFakultas)) {
            'FAI' => '01',
            'FT' => '02',
            'FKES' => '03',
            'SOSHUM' => '04',
            'PASCA' => '05',
            default => '00',
        };

        $bulanTahun = date('m.Y');
        $tahun = date('Y');
        
        $prefix = "NJ-T06/{$kodeFakultasAngka}/";
        $suffixPattern = "/SKPI/%.{$tahun}";

        // Get the latest number for this faculty in the current year
        $latestSkpi = DB::table('skpi')
            ->where('nomor_skpi', 'like', $prefix . '%' . $suffixPattern)
            ->where('nomor_skpi', 'not like', '%(DRAFT)%')
            ->orderBy('id_skpi', 'desc')
            ->value('nomor_skpi');

        $nextSeq = 1;
        if ($latestSkpi) {
            $parts = explode('/', $latestSkpi);
            // Expected format: NJ-T06 / 01 / 0001 / SKPI / 07.2026
            if (isset($parts[2]) && is_numeric($parts[2])) {
                $nextSeq = intval($parts[2]) + 1;
            }
        }

        $nomorUrut = str_pad($nextSeq, 4, '0', STR_PAD_LEFT);

        return "{$prefix}{$nomorUrut}/SKPI/{$bulanTahun}";
    }

    public function checkNomorIjazahUnique(string $nimIjazah, ?int $exceptId = null): ?string
    {
        $query = DB::table('skpi')->where('nim_ijazah', $nimIjazah);
        if ($exceptId) {
            $query->where('id_skpi', '!=', $exceptId);
        }
        return $query->exists() ? 'Nomor Ijazah Nasional (NIM Ijazah) sudah digunakan oleh mahasiswa lain.' : null;
    }

    public function createSkpi(PengajuanSkpi $pengajuan, string $nimIjazah, ?string $statusProfesi, User $user): Skpi
    {
        $mahasiswa = Mahasiswa::with(['programStudi.fakultas'])->find($pengajuan->id_mahasiswa);
        $prodi = $mahasiswa->programStudi;
        $fakultas = $prodi->fakultas ?? null;
        $nidn = $fakultas->nidn_dekan ?? null;
        $namaDekan = $fakultas->dekan ?? $user->nama_lengkap;

        $kodeFakultas = $fakultas->kode_fakultas ?? 'FAKULTAS';
        $nomorSkpi = $this->generateNomorSkpi($kodeFakultas);

        return DB::transaction(function () use ($nomorSkpi, $mahasiswa, $pengajuan, $nimIjazah, $statusProfesi, $user, $nidn, $namaDekan) {
            $skpi = Skpi::create([
                'nomor_skpi' => $nomorSkpi,
                'id_mahasiswa' => $mahasiswa->id_mahasiswa,
                'id_pengajuan' => $pengajuan->id_pengajuan,
                'nim_ijazah' => $nimIjazah,
                'tanggal_terbit' => now(),
                'dicetak_oleh' => $user->id_user,
                'status_profesi' => $statusProfesi ?? 'Belum ada keanggotaan profesi',
                'tanggal_ttd_dekan' => now(),
                'ditandatangani_oleh' => $namaDekan,
                'nidn_penandatangan' => $nidn,
            ]);

            return $skpi;
        });
    }

    public function printSkpi(PengajuanSkpi $pengajuan, string $nimIjazah, ?string $statusProfesi, User $user): \Barryvdh\DomPDF\PDF
    {
        $skpiRow = DB::table('skpi')->where('id_pengajuan', $pengajuan->id_pengajuan)->first();
        $skpi = $skpiRow ? Skpi::hydrate([(array) $skpiRow])->first() : null;

        if (!$skpi) {
            $skpi = $this->createSkpi($pengajuan, $nimIjazah, $statusProfesi, $user);
            $pengajuan->update(['status' => 'dicetak']);
        }

        return $this->generatePdf($pengajuan, $skpi);
    }

    public function generatePdf(PengajuanSkpi $pengajuan, Skpi $skpi): \Barryvdh\DomPDF\PDF
    {
        $mahasiswa = Mahasiswa::with(['programStudi.fakultas'])->find($pengajuan->id_mahasiswa);
        $prodi = $mahasiswa->programStudi;
        $fakultas = $prodi->fakultas ?? null;

        $cplList = $this->getCplList($mahasiswa);
        $penilaian = $this->cache->getSistemPenilaian();

        $mhsId = $mahasiswa->id_mahasiswa;

        $data = (function () use ($mhsId) {
            $prestasi = DB::table('prestasi_mahasiswa')
                ->where('id_mahasiswa', $mhsId)
                ->where('status', 'approved')
                ->get();

            $organisasi = DB::table('organisasi_mahasiswa')
                ->where('id_mahasiswa', $mhsId)
                ->where('status', 'approved')
                ->get();

            $sertifikat = DB::table('sertifikat_mahasiswa')
                ->where('id_mahasiswa', $mhsId)
                ->where('status', 'approved')
                ->get();

            $magang = DB::table('magang_mahasiswa')
                ->where('magang_mahasiswa.id_mahasiswa', $mhsId)
                ->where('magang_mahasiswa.status', 'approved')
                ->select('magang_mahasiswa.*')
                ->get()
                ->map(function ($item) {
                    $item->tempatMagang = (object) [
                        'nama_perusahaan' => $item->tempat_magang,
                        'alamat' => '',
                    ];
                    return $item;
                });

            $tugasAkhir = DB::table('tugas_akhir')
                ->where('id_mahasiswa', $mhsId)
                ->first();

            if ($tugasAkhir) {
                $pembimbingList = DB::table('pembimbing_tugas_akhir')
                    ->where('id_tugas_akhir', $tugasAkhir->id_tugas_akhir)
                    ->orderBy('urutan_pembimbing')
                    ->get();
                $tugasAkhir->pembimbingTugasAkhir = $pembimbingList;
            }

            return compact('prestasi', 'organisasi', 'sertifikat', 'magang', 'tugasAkhir');
        })();

        $pdf = Pdf::setOption([
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true
        ])->loadView('pdf.skpi', array_merge(
            compact('pengajuan', 'skpi', 'mahasiswa', 'cplList', 'penilaian', 'fakultas'),
            $data
        ));

        return $pdf;
    }

    private function getCplList($mahasiswa): \Illuminate\Support\Collection
    {
        return $this->cache->getCplByProdiAndKurikulum($mahasiswa->id_prodi, $mahasiswa->id_kurikulum);
    }
}
