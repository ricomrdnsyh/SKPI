<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrganisasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'nama_organisasi' => 'required|string|max:255',
            'tingkat' => 'required|in:Internasional,Nasional,Universitas,Fakultas',
            'jabatan' => 'required|string|max:100',
            'tahun_mulai' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'tahun_selesai' => 'nullable|digits:4|integer|min:1900|max:' . (date('Y') + 5) . '|gte:tahun_mulai',
        ];

        if ($this->isMethod('post')) {
            $rules['file_bukti'] = 'required|file|mimetypes:application/pdf,image/jpeg,image/png|max:2048';
        } else {
            $rules['file_bukti'] = 'nullable|file|mimetypes:application/pdf,image/jpeg,image/png|max:2048';
        }

        return $rules;
    }
}
