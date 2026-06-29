<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTugasAkhirRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:1000',
            'pembimbing' => 'required|array|min:1',
            'pembimbing.*' => 'nullable|string|max:255',
        ];
    }
}
