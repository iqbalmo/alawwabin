<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGuruRequest extends FormRequest
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
        $guruId = $this->guru->id;

        return [
            'nama' => 'required|string|max:255',
            'gelar' => 'nullable|string|max:100',
            'nip' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('gurus')->ignore($guruId),
            ],
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'pend_terakhir_tahun' => 'nullable|string:4',
            'pend_terakhir_univ' => 'nullable|string|max:255',
            'pend_terakhir_jurusan' => 'nullable|string|max:255',
            'tahun_mulai_bekerja' => 'nullable|string:4',
            'jabatan' => 'nullable|string|max:100',
            'status_kepegawaian' => 'nullable|in:PNS,Swasta',
            'mapel_id' => 'nullable|exists:mapels,id',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
        ];
    }
}
