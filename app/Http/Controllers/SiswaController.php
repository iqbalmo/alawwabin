<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        // Mengurutkan berdasarkan nama dan paginasi
        $siswa = Siswa::with('kelas')->orderBy('nama', 'asc')->paginate(15);
        return view('siswa.index', compact('siswa'));
    }

    public function create()
    {
        $kelas = Kelas::orderBy('tingkat')->orderBy('nama_kelas')->get();
        return view('siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        // Validasi yang diperbarui
        $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|max:255|unique:siswas,nis',
            'kelas_id' => 'required|exists:kelas,id',
            
            'no_absen' => 'nullable|integer',
            'nisn' => 'nullable|string|max:255|unique:siswas,nisn',
            'nik_siswa' => 'nullable|string|max:255|unique:siswas,nik_siswa',
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
        ]);

        Siswa::create($request->all());
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    /**
     * Tampilkan halaman detail untuk satu siswa.
     */
    public function show(Siswa $siswa)
    {
        // Kita sudah mendapatkan $siswa berkat Route Model Binding
        // Eager load relasi 'kelas' untuk memastikan datanya ada
        $siswa->load('kelas'); 
        
        return view('siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::orderBy('tingkat')->orderBy('nama_kelas')->get();
        return view('siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        // Validasi yang diperbarui
        $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|max:255|unique:siswas,nis,'.$siswa->id,
            'kelas_id' => 'required|exists:kelas,id',

            'no_absen' => 'nullable|integer',
            'nisn' => 'nullable|string|max:255|unique:siswas,nisn,'.$siswa->id,
            'nik_siswa' => 'nullable|string|max:255|unique:siswas,nik_siswa,'.$siswa->id,
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
        ]);

        $siswa->update($request->all());
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}