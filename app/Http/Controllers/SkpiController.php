<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\PengajuanSkpi;
use App\Models\Skpi;
use App\Services\SkpiService;
use App\Services\SkpiProgressService;
use App\Services\PengajuanService;
use App\Services\CacheService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SkpiController extends Controller
{
    use \App\Http\Controllers\Traits\FilterByProdi;

    public function __construct(
        private SkpiService $skpiService,
        private SkpiProgressService $progressService,
        private PengajuanService $pengajuanService,
        private CacheService $cache
    ) {}

    public function print(Request $request, int $id_pengajuan)
    {
        $pengajuanRow = DB::table('pengajuan_skpi')->where('id_pengajuan', $id_pengajuan)->first();
        if (!$pengajuanRow) abort(404);
        $pengajuan = PengajuanSkpi::hydrate([(array) $pengajuanRow])->first();
        $user = Auth::user();

        $mahasiswaRow = DB::table('mahasiswa')
            ->leftJoin('program_studi', 'mahasiswa.id_prodi', '=', 'program_studi.id_prodi')
            ->leftJoin('fakultas', 'program_studi.id_fakultas', '=', 'fakultas.id_fakultas')
            ->where('mahasiswa.id_mahasiswa', $pengajuan->id_mahasiswa)
            ->select(
                'mahasiswa.*',
                'program_studi.nama_prodi',
                'program_studi.kode_prodi',
                'fakultas.nama_fakultas',
                'fakultas.dekan',
                'fakultas.nidn_dekan',
                'fakultas.kode_fakultas'
            )
            ->first();

        if (!$mahasiswaRow) {
            abort(404);
        }

        $mahasiswa = (object) [
            'id_mahasiswa' => $mahasiswaRow->id_mahasiswa,
            'nim' => $mahasiswaRow->nim,
            'nama_lengkap' => $mahasiswaRow->nama_lengkap,
            'tempat_lahir' => $mahasiswaRow->tempat_lahir,
            'tanggal_lahir' => $mahasiswaRow->tanggal_lahir,
            'tahun_masuk' => $mahasiswaRow->tahun_masuk,
            'tahun_lulus' => $mahasiswaRow->tahun_lulus,
            'tanggal_lulus' => $mahasiswaRow->tanggal_lulus,
            'ipk' => $mahasiswaRow->ipk,
            'id_prodi' => $mahasiswaRow->id_prodi,
        ];

        if ($user->role === 'mahasiswa') {
            if ($user->id_mahasiswa !== $pengajuan->id_mahasiswa) {
                abort(403, 'Anda tidak memiliki akses ke halaman ini.');
            }
        } elseif ($user->role !== 'admin') {
            $allowedProdis = $this->getAllowedProdiIds($user);
            if ($allowedProdis !== null && !in_array($mahasiswaRow->id_prodi, $allowedProdis)) {
                abort(403, 'Anda tidak memiliki akses ke halaman ini.');
            }
        }

        $skpiRow = DB::table('skpi')->where('id_pengajuan', $id_pengajuan)->first();
        $skpi = $skpiRow ? Skpi::hydrate([(array) $skpiRow])->first() : null;
        $isPublishRequest = !$skpi && $request->has('nim_ijazah');

        if ($isPublishRequest) {
            if ($pengajuan->status !== 'dicetak') {
                return back()->with('error', 'SKPI hanya bisa dicetak jika status pengajuan sudah "dicetak".');
            }

            $mahasiswaRow = DB::table('mahasiswa')->where('id_mahasiswa', $pengajuan->id_mahasiswa)->first();
            $mhs = $mahasiswaRow ? Mahasiswa::hydrate([(array) $mahasiswaRow])->first() : null;
            if (!$mhs || !$mhs->tugasAkhirApproved()) {
                return back()->with('error', 'SKPI tidak dapat dicetak karena Tugas Akhir belum disetujui.');
            }

            if (!$this->pengajuanService->hasTugasAkhir($mhs)) {
                return back()->with('error', 'SKPI tidak dapat dicetak karena data Tugas Akhir belum diisi.');
            }
        }

        if (!$skpi) {
            if (!$isPublishRequest) {
                $fakultas = (object) [
                    'dekan' => $mahasiswaRow->dekan,
                    'nidn_dekan' => $mahasiswaRow->nidn_dekan,
                ];
                $tahun = $mahasiswa->tahun_lulus ?? date('Y');
                $kodeProdi = $mahasiswaRow->kode_prodi ?? 'PRODI';
                $kodeUni = config('skpi.university_code', 'UNUJA');
                $nomorSkpi = $this->skpiService->generateNomorSkpi($kodeProdi, $tahun, $kodeUni, $mahasiswa->id_mahasiswa);

                $draftSkpi = new Skpi([
                    'nomor_skpi' => $nomorSkpi . ' (DRAFT)',
                    'id_mahasiswa' => $mahasiswa->id_mahasiswa,
                    'id_pengajuan' => $pengajuan->id_pengajuan,
                    'nim_ijazah' => 'BELUM DITERBITKAN',
                    'tanggal_terbit' => now(),
                    'status_profesi' => 'Belum ada keanggotaan profesi',
                    'tanggal_ttd_dekan' => now(),
                    'ditandatangani_oleh' => $fakultas->dekan ?? 'Dekan Fakultas',
                    'nidn_penandatangan' => $fakultas->nidn_dekan ?? '',
                ]);
                $draftSkpi->id_skpi = 0;

                $pdf = $this->skpiService->generatePdf($pengajuan, $draftSkpi);
            } else {
                if ($user->role !== 'bak_fakultas' && $user->role !== 'admin') {
                    abort(403, 'SKPI belum diterbitkan oleh BAK Fakultas.');
                }

                if (!$pengajuan->permohonan_cetak) {
                    abort(403, 'SKPI tidak dapat dibuat karena mahasiswa belum mengajukan permohonan cetak.');
                }

                $request->validate([
                    'nim_ijazah' => 'required|string|max:50',
                    'status_profesi' => 'nullable|string|max:255',
                ]);

                $error = $this->skpiService->checkNomorIjazahUnique($request->nim_ijazah);
                if ($error) {
                    return back()->with('error', $error);
                }

                $pdf = $this->skpiService->printSkpi($pengajuan, $request->nim_ijazah, $request->status_profesi, $user);
            }
        } else {
            if ($request->has('nim_ijazah') && in_array($user->role, ['bak_fakultas', 'admin'])) {
                $request->validate([
                    'nim_ijazah' => 'required|string|max:50',
                    'status_profesi' => 'nullable|string|max:255',
                ]);

                $error = $this->skpiService->checkNomorIjazahUnique($request->nim_ijazah, $skpi->id_skpi);
                if ($error) {
                    return back()->with('error', $error);
                }

                $skpi->update([
                    'nim_ijazah' => $request->nim_ijazah,
                    'status_profesi' => $request->status_profesi ?? 'Belum ada keanggotaan profesi',
                ]);
            }

            $pdf = $this->skpiService->generatePdf($pengajuan, $skpi);
        }

        return $pdf->stream("SKPI_{$mahasiswa->nim}.pdf");
    }

    public function verify(int $id_skpi)
    {
        $data = Cache::remember("skpi:verify:{$id_skpi}", 300, function () use ($id_skpi) {
            $skpi = DB::table('skpi')
                ->leftJoin('mahasiswa', 'skpi.id_mahasiswa', '=', 'mahasiswa.id_mahasiswa')
                ->leftJoin('program_studi', 'mahasiswa.id_prodi', '=', 'program_studi.id_prodi')
                ->leftJoin('fakultas', 'program_studi.id_fakultas', '=', 'fakultas.id_fakultas')
                ->where('skpi.id_skpi', $id_skpi)
                ->select(
                    'skpi.*',
                    'skpi.niy_penandatangan as nidn_penandatangan',
                    'mahasiswa.id_mahasiswa',
                    'mahasiswa.nim',
                    'mahasiswa.nama_lengkap as mahasiswa_nama',
                    'mahasiswa.tempat_lahir',
                    'mahasiswa.tanggal_lahir',
                    'mahasiswa.tahun_masuk',
                    'mahasiswa.tahun_lulus',
                    'mahasiswa.tanggal_lulus',
                    'mahasiswa.ipk',
                    'mahasiswa.id_prodi',
                    'program_studi.nama_prodi',
                    'program_studi.kode_prodi',
                    'program_studi.jenjang',
                    'program_studi.gelar',
                    'program_studi.jenjang_kkni',
                    'fakultas.nama_fakultas',
                    'fakultas.dekan',
                    'fakultas.nidn_dekan'
                )
                ->first();

            if (!$skpi) {
                return null;
            }

            $mahasiswa = (object) [
                'id_mahasiswa' => $skpi->id_mahasiswa,
                'nim' => $skpi->nim,
                'nama_lengkap' => $skpi->mahasiswa_nama,
                'tempat_lahir' => $skpi->tempat_lahir,
                'tanggal_lahir' => $skpi->tanggal_lahir,
                'tahun_masuk' => $skpi->tahun_masuk,
                'tahun_lulus' => $skpi->tahun_lulus,
                'tanggal_lulus' => $skpi->tanggal_lulus,
                'ipk' => $skpi->ipk,
                'id_prodi' => $skpi->id_prodi,
                'programStudi' => (object) [
                    'nama_prodi' => $skpi->nama_prodi,
                    'kode_prodi' => $skpi->kode_prodi,
                    'jenjang' => $skpi->jenjang,
                    'gelar' => $skpi->gelar,
                    'jenjang_kkni' => $skpi->jenjang_kkni,
                ],
            ];

            $fakultas = (object) [
                'nama_fakultas' => $skpi->nama_fakultas,
                'dekan' => $skpi->dekan,
                'nidn_dekan' => $skpi->nidn_dekan,
            ];

            $mhsId = $skpi->id_mahasiswa;

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

            $magangCollection = DB::table('magang_mahasiswa')
                ->where('magang_mahasiswa.id_mahasiswa', $mhsId)
                ->where('magang_mahasiswa.status', 'approved')
                ->select('magang_mahasiswa.*')
                ->get();

            $magang = $magangCollection->map(function ($item) {
                $item->tempatMagang = (object) [
                    'nama_perusahaan' => $item->tempat_magang ?? '',
                    'alamat' => '',
                ];
                return $item;
            });

            $taRaw = DB::table('tugas_akhir')
                ->where('id_mahasiswa', $mhsId)
                ->first();

            $tugasAkhir = null;
            if ($taRaw) {
                $pembimbingCollection = DB::table('pembimbing_tugas_akhir')
                    ->where('id_tugas_akhir', $taRaw->id_tugas_akhir)
                    ->orderBy('urutan_pembimbing')
                    ->get();

                $tugasAkhir = (object) [
                    'id_tugas_akhir' => $taRaw->id_tugas_akhir,
                    'judul' => $taRaw->judul,
                    'status' => $taRaw->status,
                    'pembimbingTugasAkhir' => $pembimbingCollection,
                ];
            }

            return compact(
                'skpi',
                'mahasiswa',
                'fakultas',
                'tugasAkhir',
                'prestasi',
                'organisasi',
                'sertifikat',
                'magang'
            );
        });

        if (!$data) {
            return view('skpi.verify_failed', ['message' => 'Dokumen SKPI dengan ID tersebut tidak ditemukan dalam sistem kami.']);
        }

        return view('skpi.verify', $data);
    }
}
