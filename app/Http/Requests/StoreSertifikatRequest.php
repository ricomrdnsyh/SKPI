<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSertifikatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'nama_sertifikat' => 'required|string|max:255',
            'jenis_sertifikat' => 'required|in:Keagamaan,Teknis,Bahasa,Profesional',
            'bidang' => 'required|string|max:100',
            'penyelenggara' => 'required|string|max:255',
            'tanggal_terbit' => 'required|date|before_or_equal:' . date('Y-m-d'),
        ];

        if ($this->isMethod('post')) {
            $rules['file_bukti'] = 'required|file|mimetypes:application/pdf,image/jpeg,image/png|max:2048';
        } else {
            $rules['file_bukti'] = 'nullable|file|mimetypes:application/pdf,image/jpeg,image/png|max:2048';
        }

        return $rules;
    }
}
