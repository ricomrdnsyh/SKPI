<?php

namespace App\Console\Commands;

use App\Models\Kurikulum;
use App\Models\ProgramStudi;
use App\Services\ClientSSO;
use Illuminate\Console\Command;

class SyncKurikulumCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:kurikulum {id_sms? : ID Semester/Prodi spesifik untuk disinkronisasi}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi data Kurikulum dari API SSO';

    /**
     * Execute the console command.
     */
    public function handle(ClientSSO $clientSSO)
    {
        $this->info('Memulai sinkronisasi data Kurikulum...');

        $idSmsParam = $this->argument('id_sms');

        if ($idSmsParam) {
            $this->syncForProdi($idSmsParam, $clientSSO);
        } else {
            $prodis = ProgramStudi::all();
            
            if ($prodis->isEmpty()) {
                $this->warn('Data Program Studi kosong. Pastikan tabel program_studi sudah terisi.');
                return;
            }

            $bar = $this->output->createProgressBar(count($prodis));
            $bar->start();

            foreach ($prodis as $prodi) {
                $this->syncForProdi($prodi->id_prodi, $clientSSO);
                $bar->advance();
            }

            $bar->finish();
            $this->newLine();
        }

        $this->info('Sinkronisasi data Kurikulum selesai!');
    }

    private function syncForProdi(string $idProdi, ClientSSO $clientSSO)
    {
        try {
            $data = $clientSSO->getKurikulumFromApi($idProdi);

            if (empty($data)) {
                return;
            }

            foreach ($data as $item) {
                $namaKurikulum = $item['nm_kurikulum'] ?? $item['nama_kurikulum'] ?? null;
                if ($namaKurikulum) {
                    Kurikulum::updateOrCreate(
                        [
                            'id_prodi' => $idProdi,
                            'nama_kurikulum' => $namaKurikulum,
                        ]
                    );
                }
            }
        } catch (\Exception $e) {
            $this->error("Gagal sinkronisasi untuk Prodi {$idProdi}: " . $e->getMessage());
        }
    }
}
