<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSiswaRequest extends FormRequest
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
        // $this->siswa is the route parameter (the Siswa model instance)
        $siswaId = $this->siswa->id;

        return [
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|max:255|unique:siswas,nis,' . $siswaId,
            'kelas_id' => 'required|exists:kelas,id',

            'no_absen' => 'nullable|integer',
            'nisn' => 'nullable|string|max:255|unique:siswas,nisn,' . $siswaId,
            'nik_siswa' => 'nullable|string|max:255|unique:siswas,nik_siswa,' . $siswaId,
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',

            'no_kk' => 'nullable|string|max:255',
            'nama_ayah' => 'nullable|string|max:255',
            'ttl_ayah' => 'nullable|string|max:255',
            'pendidikan_ayah' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'ttl_ibu' => 'nullable|string|max:255',
            'pendidikan_ibu' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',

            'anak_ke' => 'nullable|integer',
            'jumlah_saudara' => 'nullable|integer',
            'sekolah_asal' => 'nullable|string|max:255',
            'status_mukim' => 'nullable|string|max:255',

            'nama_wali' => 'nullable|string|max:255',
            'ttl_wali' => 'nullable|string|max:255',
            'alamat_wali' => 'nullable|string',
            'pekerjaan_wali' => 'nullable|string|max:255',

            'alamat_orangtua' => 'nullable|string',
            'kelurahan' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kota' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'kodepos' => 'nullable|string|max:255',

            'hp_ayah' => 'nullable|string|max:255',
            'hp_ibu' => 'nullable|string|max:255',
            'email_ayah' => 'nullable|email|max:255',
            'email_ibu' => 'nullable|email|max:255',
        ];
    }
}
