<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class ClientSSO
{
    public function __construct(
        protected AuthSSO $auth
    ) {}

    public function getFakultasFromApi(): array
    {
        return $this->fetchData('fakultas');
    }

    public function getKurikulumFromApi(string $idSms): array
    {
        return $this->fetchData('kurikulum', ['id_sms' => $idSms]);
    }

    public function getTahunAkademikFromApi(): array
    {
        return $this->fetchData('tahun_ajaran');
    }

    public function getProdiByFakultas(string $idFakultas): array
    {
        return $this->fetchData('program_studi', ['id_fakultas' => $idFakultas]);
    }

    public function getDosenByProdi(string $idSms): array
    {
        return $this->fetchData('dosen', ['id_sms' => $idSms]);
    }

    public function getKaryawanFromApi(): array
    {
        $allKaryawans = [];
        $lembagaIds = [3, 4, 5, 6, 7, 8, 11];
        foreach ($lembagaIds as $idLembaga) {
            try {
                $data = $this->fetchData('karyawan', [
                    'id_lembaga' => $idLembaga,
                    'pagination' => 'off'
                ]);
                if (is_array($data)) {
                    $allKaryawans = array_merge($allKaryawans, $data);
                }
            } catch (\Exception $e) {
            }
        }
        return $allKaryawans;
    }

    private function fetchData(string $filter, array $additionalPayload = []): array
    {
        $auth = $this->auth->getAuth();

        $url = $auth['data_url'];
        $headers = $auth['headers'];

        $payload = array_merge([
            'filter' => $filter,
            'pagination' => 'off',
        ], $additionalPayload);

        /** @var Response $response */
        $response = Http::withHeaders($headers)
            ->withoutVerifying()
            ->timeout(60)
            ->connectTimeout(10)
            ->post($url, $payload);

        if ($response->status() === 401) {
            $auth = $this->auth->refreshAuth();
            $url = $auth['data_url'];
            $headers = $auth['headers'];

            /** @var Response $response */
            $response = Http::withHeaders($headers)
                ->withoutVerifying()
                ->connectTimeout(30)
                ->timeout(120)
                ->post($url, $payload);
        }

        $response->throw();

        return $response->json('data') ?? [];
    }
}
