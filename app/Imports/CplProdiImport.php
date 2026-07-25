<?php

namespace App\Imports;

use App\Models\CplProdi;
use App\Models\KategoriCpl;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CplProdiImport implements ToCollection, WithHeadingRow
{
    protected $id_prodi;
    protected $id_kurikulum;
    protected $kategoriMap;

    public function __construct($id_prodi, $id_kurikulum)
    {
        $this->id_prodi = $id_prodi;
        $this->id_kurikulum = $id_kurikulum;
        // Preload categories to map kode -> id quickly
        $this->kategoriMap = KategoriCpl::all()->pluck('id_kategori', 'kode_kategori')->toArray();
    }

    public function collection(Collection $rows)
    {
        $insertData = [];
        $errors = [];

        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2; // +1 for 0-index, +1 for heading row
            
            // Expected headers in CSV/Excel after WithHeadingRow: 
            // kode_kategori, kode_cpl, deskripsi_cpl, urutan
            $kodeKategori = trim($row['kode_kategori'] ?? '');
            
            if (empty($kodeKategori) && empty($row['kode_cpl']) && empty($row['deskripsi_cpl'])) {
                continue; // Skip completely empty rows
            }
            
            // Ensure category exists
            $id_kategori = null;
            // Handle case sensitivity by converting both to uppercase for matching
            foreach ($this->kategoriMap as $k => $id) {
                if (strcasecmp($k, $kodeKategori) == 0) {
                    $id_kategori = $id;
                    break;
                }
            }

            $validator = Validator::make([
                'id_kategori' => $id_kategori,
                'kode_cpl' => $row['kode_cpl'] ?? '',
                'deskripsi_cpl' => $row['deskripsi_cpl'] ?? '',
                'urutan' => $row['urutan'] ?? null,
            ], [
                'id_kategori' => 'required',
                'kode_cpl' => 'required|string|max:20',
                'deskripsi_cpl' => 'required|string',
                'urutan' => 'nullable|integer',
            ], [
                'id_kategori.required' => "Kode Kategori '{$kodeKategori}' tidak ditemukan di database pada baris {$rowNumber}.",
                'kode_cpl.required' => "Kode CPL wajib diisi pada baris {$rowNumber}.",
                'deskripsi_cpl.required' => "Deskripsi CPL wajib diisi pada baris {$rowNumber}.",
            ]);

            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $error) {
                    $errors[] = $error;
                }
            } else {
                $insertData[] = [
                    'id_prodi' => $this->id_prodi,
                    'id_kurikulum' => $this->id_kurikulum,
                    'id_kategori' => $id_kategori,
                    'kode_cpl' => trim($row['kode_cpl']),
                    'deskripsi_cpl' => trim($row['deskripsi_cpl']),
                    'urutan' => $row['urutan'] ? (int) $row['urutan'] : null,
                ];
            }
        }

        if (!empty($errors)) {
            // throw exception with first 5 errors to not overwhelm UI
            $displayErrors = array_slice($errors, 0, 5);
            if (count($errors) > 5) {
                $displayErrors[] = '...dan ' . (count($errors) - 5) . ' error lainnya.';
            }
            throw ValidationException::withMessages(['import_error' => $displayErrors]);
        }

        // Mass insert if no errors
        if (!empty($insertData)) {
            CplProdi::insert($insertData);
        }
    }
}
