<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\KategoriCpl;
use App\Models\CplProdi;
use App\Models\ProgramStudi;
use App\Models\Kurikulum;

class CplSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Data Kategori CPL
        $kategoriData = [
            ['kode_kategori' => 'S', 'nama_kategori' => 'Sikap', 'urutan' => 1],
            ['kode_kategori' => 'P', 'nama_kategori' => 'Penguasaan Pengetahuan', 'urutan' => 2],
            ['kode_kategori' => 'KU', 'nama_kategori' => 'Keterampilan Umum', 'urutan' => 3],
            ['kode_kategori' => 'KK', 'nama_kategori' => 'Keterampilan Khusus', 'urutan' => 4],
        ];

        foreach ($kategoriData as $kategori) {
            KategoriCpl::updateOrCreate(
                ['kode_kategori' => $kategori['kode_kategori']],
                $kategori
            );
        }

        // 2. Data CPL Prodi (Sample Data)
        // Cari prodi Informatika, jika tidak ada baru ambil prodi pertama
        $prodi = ProgramStudi::where('nama_prodi', 'like', '%Informatika%')->first() ?? ProgramStudi::first();
        // Cari kurikulum IF OBE, jika tidak ada baru ambil kurikulum pertama
        $kurikulum = Kurikulum::where('nama_kurikulum', 'like', '%IF OBE%')->first() ?? Kurikulum::first();

        if ($prodi && $kurikulum) {
            $kategoriSikap = KategoriCpl::where('kode_kategori', 'S')->first();
            $kategoriPengetahuan = KategoriCpl::where('kode_kategori', 'P')->first();

            $kategoriKeterampilanUmum = KategoriCpl::where('kode_kategori', 'KU')->first();
            $kategoriKeterampilanKhusus = KategoriCpl::where('kode_kategori', 'KK')->first();

            if ($kategoriSikap && $kategoriPengetahuan && $kategoriKeterampilanUmum && $kategoriKeterampilanKhusus) {
                $cplData = [
                    // Sikap (S) - 6 items
                    [ 'id_prodi' => $prodi->id_prodi, 'id_kurikulum' => $kurikulum->id_kurikulum, 'id_kategori' => $kategoriSikap->id_kategori, 'kode_cpl' => 'S1', 'deskripsi_cpl' => 'Bertakwa kepada Tuhan Yang Maha Esa dan mampu menunjukkan sikap religius.', 'urutan' => 1 ],
                    [ 'id_prodi' => $prodi->id_prodi, 'id_kurikulum' => $kurikulum->id_kurikulum, 'id_kategori' => $kategoriSikap->id_kategori, 'kode_cpl' => 'S2', 'deskripsi_cpl' => 'Menjunjung tinggi nilai kemanusiaan dalam menjalankan tugas berdasarkan agama, moral, dan etika.', 'urutan' => 2 ],
                    [ 'id_prodi' => $prodi->id_prodi, 'id_kurikulum' => $kurikulum->id_kurikulum, 'id_kategori' => $kategoriSikap->id_kategori, 'kode_cpl' => 'S3', 'deskripsi_cpl' => 'Berkontribusi dalam peningkatan mutu kehidupan bermasyarakat, berbangsa, bernegara, dan kemajuan peradaban berdasarkan Pancasila.', 'urutan' => 3 ],
                    [ 'id_prodi' => $prodi->id_prodi, 'id_kurikulum' => $kurikulum->id_kurikulum, 'id_kategori' => $kategoriSikap->id_kategori, 'kode_cpl' => 'S4', 'deskripsi_cpl' => 'Berperan sebagai warga negara yang bangga dan cinta tanah air, memiliki nasionalisme serta rasa tanggungjawab pada negara dan bangsa.', 'urutan' => 4 ],
                    [ 'id_prodi' => $prodi->id_prodi, 'id_kurikulum' => $kurikulum->id_kurikulum, 'id_kategori' => $kategoriSikap->id_kategori, 'kode_cpl' => 'S5', 'deskripsi_cpl' => 'Menghargai keanekaragaman budaya, pandangan, agama, dan kepercayaan, serta pendapat atau temuan orisinal orang lain.', 'urutan' => 5 ],
                    [ 'id_prodi' => $prodi->id_prodi, 'id_kurikulum' => $kurikulum->id_kurikulum, 'id_kategori' => $kategoriSikap->id_kategori, 'kode_cpl' => 'S6', 'deskripsi_cpl' => 'Bekerja sama dan memiliki kepekaan sosial serta kepedulian terhadap masyarakat dan lingkungan.', 'urutan' => 6 ],
                    
                    // Penguasaan Pengetahuan (P) - 6 items
                    [ 'id_prodi' => $prodi->id_prodi, 'id_kurikulum' => $kurikulum->id_kurikulum, 'id_kategori' => $kategoriPengetahuan->id_kategori, 'kode_cpl' => 'P1', 'deskripsi_cpl' => 'Menguasai konsep teoritis bidang pengetahuan secara umum dan mendalam sesuai standar KKNI.', 'urutan' => 1 ],
                    [ 'id_prodi' => $prodi->id_prodi, 'id_kurikulum' => $kurikulum->id_kurikulum, 'id_kategori' => $kategoriPengetahuan->id_kategori, 'kode_cpl' => 'P2', 'deskripsi_cpl' => 'Menguasai prinsip dan teknik perancangan sistem dan/atau rekayasa perangkat lunak.', 'urutan' => 2 ],
                    [ 'id_prodi' => $prodi->id_prodi, 'id_kurikulum' => $kurikulum->id_kurikulum, 'id_kategori' => $kategoriPengetahuan->id_kategori, 'kode_cpl' => 'P3', 'deskripsi_cpl' => 'Menguasai pengetahuan tentang teknologi terkini yang sedang berkembang dalam bidang informatika dan ilmu komputer.', 'urutan' => 3 ],
                    [ 'id_prodi' => $prodi->id_prodi, 'id_kurikulum' => $kurikulum->id_kurikulum, 'id_kategori' => $kategoriPengetahuan->id_kategori, 'kode_cpl' => 'P4', 'deskripsi_cpl' => 'Menguasai konsep dan algoritma dasar dalam pemecahan masalah komputasi secara efektif dan efisien.', 'urutan' => 4 ],
                    [ 'id_prodi' => $prodi->id_prodi, 'id_kurikulum' => $kurikulum->id_kurikulum, 'id_kategori' => $kategoriPengetahuan->id_kategori, 'kode_cpl' => 'P5', 'deskripsi_cpl' => 'Menguasai arsitektur sistem komputer, jaringan komputer, dan keamanan sistem informasi.', 'urutan' => 5 ],
                    [ 'id_prodi' => $prodi->id_prodi, 'id_kurikulum' => $kurikulum->id_kurikulum, 'id_kategori' => $kategoriPengetahuan->id_kategori, 'kode_cpl' => 'P6', 'deskripsi_cpl' => 'Menguasai prinsip-prinsip kecerdasan buatan, sains data, dan penerapannya dalam berbagai domain.', 'urutan' => 6 ],

                    // Keterampilan Umum (KU) - 6 items
                    [ 'id_prodi' => $prodi->id_prodi, 'id_kurikulum' => $kurikulum->id_kurikulum, 'id_kategori' => $kategoriKeterampilanUmum->id_kategori, 'kode_cpl' => 'KU1', 'deskripsi_cpl' => 'Mampu menerapkan pemikiran logis, kritis, sistematis, dan inovatif dalam konteks pengembangan atau implementasi ilmu pengetahuan dan teknologi.', 'urutan' => 1 ],
                    [ 'id_prodi' => $prodi->id_prodi, 'id_kurikulum' => $kurikulum->id_kurikulum, 'id_kategori' => $kategoriKeterampilanUmum->id_kategori, 'kode_cpl' => 'KU2', 'deskripsi_cpl' => 'Mampu menunjukkan kinerja mandiri, bermutu, dan terukur.', 'urutan' => 2 ],
                    [ 'id_prodi' => $prodi->id_prodi, 'id_kurikulum' => $kurikulum->id_kurikulum, 'id_kategori' => $kategoriKeterampilanUmum->id_kategori, 'kode_cpl' => 'KU3', 'deskripsi_cpl' => 'Mampu mengambil keputusan secara tepat dalam konteks penyelesaian masalah di bidang keahliannya, berdasarkan hasil analisis informasi dan data.', 'urutan' => 3 ],
                    [ 'id_prodi' => $prodi->id_prodi, 'id_kurikulum' => $kurikulum->id_kurikulum, 'id_kategori' => $kategoriKeterampilanUmum->id_kategori, 'kode_cpl' => 'KU4', 'deskripsi_cpl' => 'Mampu menyusun deskripsi saintifik hasil kajian tersebut dalam bentuk skripsi atau laporan tugas akhir, dan mengunggahnya dalam laman perguruan tinggi.', 'urutan' => 4 ],
                    [ 'id_prodi' => $prodi->id_prodi, 'id_kurikulum' => $kurikulum->id_kurikulum, 'id_kategori' => $kategoriKeterampilanUmum->id_kategori, 'kode_cpl' => 'KU5', 'deskripsi_cpl' => 'Mampu memelihara dan mengembangkan jaringan kerja dengan pembimbing, kolega, sejawat baik di dalam maupun di luar lembaganya.', 'urutan' => 5 ],
                    [ 'id_prodi' => $prodi->id_prodi, 'id_kurikulum' => $kurikulum->id_kurikulum, 'id_kategori' => $kategoriKeterampilanUmum->id_kategori, 'kode_cpl' => 'KU6', 'deskripsi_cpl' => 'Mampu bertanggungjawab atas pencapaian hasil kerja kelompok dan melakukan supervisi dan evaluasi terhadap penyelesaian pekerjaan yang ditugaskan.', 'urutan' => 6 ],

                    // Keterampilan Khusus (KK) - 6 items
                    [ 'id_prodi' => $prodi->id_prodi, 'id_kurikulum' => $kurikulum->id_kurikulum, 'id_kategori' => $kategoriKeterampilanKhusus->id_kategori, 'kode_cpl' => 'KK1', 'deskripsi_cpl' => 'Mampu merancang dan mengembangkan algoritma untuk menyelesaikan masalah secara efektif dan efisien.', 'urutan' => 1 ],
                    [ 'id_prodi' => $prodi->id_prodi, 'id_kurikulum' => $kurikulum->id_kurikulum, 'id_kategori' => $kategoriKeterampilanKhusus->id_kategori, 'kode_cpl' => 'KK2', 'deskripsi_cpl' => 'Mampu merancang, membangun, dan memelihara perangkat lunak dengan menggunakan metode, teknik, dan alat bantu pengembangan perangkat lunak (Software Engineering).', 'urutan' => 2 ],
                    [ 'id_prodi' => $prodi->id_prodi, 'id_kurikulum' => $kurikulum->id_kurikulum, 'id_kategori' => $kategoriKeterampilanKhusus->id_kategori, 'kode_cpl' => 'KK3', 'deskripsi_cpl' => 'Mampu menerapkan konsep keamanan sistem informasi dan melindungi data dari ancaman siber.', 'urutan' => 3 ],
                    [ 'id_prodi' => $prodi->id_prodi, 'id_kurikulum' => $kurikulum->id_kurikulum, 'id_kategori' => $kategoriKeterampilanKhusus->id_kategori, 'kode_cpl' => 'KK4', 'deskripsi_cpl' => 'Mampu mengelola database relasional maupun non-relasional serta melakukan optimasi query pada sistem berskala besar.', 'urutan' => 4 ],
                    [ 'id_prodi' => $prodi->id_prodi, 'id_kurikulum' => $kurikulum->id_kurikulum, 'id_kategori' => $kategoriKeterampilanKhusus->id_kategori, 'kode_cpl' => 'KK5', 'deskripsi_cpl' => 'Mampu merancang infrastruktur jaringan komputer dan menerapkan solusi cloud computing secara aman dan terukur.', 'urutan' => 5 ],
                    [ 'id_prodi' => $prodi->id_prodi, 'id_kurikulum' => $kurikulum->id_kurikulum, 'id_kategori' => $kategoriKeterampilanKhusus->id_kategori, 'kode_cpl' => 'KK6', 'deskripsi_cpl' => 'Mampu menerapkan teknik machine learning dan data mining untuk mengekstraksi wawasan berharga dari data berskala besar.', 'urutan' => 6 ],
                ];

                foreach ($cplData as $cpl) {
                    CplProdi::updateOrCreate(
                        [
                            'id_prodi' => $cpl['id_prodi'],
                            'id_kurikulum' => $cpl['id_kurikulum'],
                            'kode_cpl' => $cpl['kode_cpl']
                        ],
                        $cpl
                    );
                }
            }
        }
    }
}
