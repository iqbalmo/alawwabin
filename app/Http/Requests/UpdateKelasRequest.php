<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKelasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $kelasId = $this->kelas->id;

        return [
            'tingkat' => 'required|string|max:20',
            'nama_kelas' => [
                'required',
                'string',
                'max:255',
                // Aturan yang sama, tapi 'ignore' (abaikan) ID kelas saat ini
                Rule::unique('kelas')->where(function ($query) {
                    return $query->where('tingkat', $this->tingkat);
                })->ignore($kelasId),
            ],
            'wali_kelas_id' => 'nullable|exists:gurus,id'
        ];
    }

    public function messages(): array
    {
        return [
            'nama_kelas.unique' => 'Kombinasi Tingkat dan Nama Kelas ini sudah ada.'
        ];
    }
}
