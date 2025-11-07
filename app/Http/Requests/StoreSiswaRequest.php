<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiswaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // app/Http/Requests/StoreSiswaRequest.php
    public function authorize(): bool
    {
        return true; // Izinkan semua user yang terotentikasi
    }

    public function rules(): array
    {
        return [
            'nama' => 'required',
            'nis' => 'required|unique:siswas,nis,'.($this->siswa->id ?? ''),
            'tanggal_lahir' => 'nullable|date',
            'kelas_id' => 'required',
        ];
    }
}
