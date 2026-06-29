<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePrestasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'nama_prestasi' => 'required|string|max:255',
            'tingkat' => 'required|in:Internasional,Nasional,Provinsi,Lokal',
            'peringkat' => 'required|string|max:100',
            'penyelenggara' => 'required|string|max:255',
            'tahun' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
        ];

        if ($this->isMethod('post')) {
            $rules['file_bukti'] = 'required|file|mimetypes:application/pdf,image/jpeg,image/png|max:2048';
        } else {
            $rules['file_bukti'] = 'nullable|file|mimetypes:application/pdf,image/jpeg,image/png|max:2048';
        }

        return $rules;
    }
}
