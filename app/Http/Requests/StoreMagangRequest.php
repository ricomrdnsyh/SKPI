<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMagangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'posisi' => 'required|string|max:100',
            'tempat_magang' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ];

        if ($this->isMethod('post')) {
            $rules['file_bukti'] = 'required|file|mimetypes:application/pdf,image/jpeg,image/png|max:2048';
        } else {
            $rules['file_bukti'] = 'nullable|file|mimetypes:application/pdf,image/jpeg,image/png|max:2048';
        }

        return $rules;
    }
}
