<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ekstrakurikuler;
use App\Models\Siswa;
use Illuminate\Validation\Rule;

class ManageEkskulMembers extends Component
{
    public Ekstrakurikuler $ekskul;

    // Ini akan terhubung (bound) ke dropdown <select>
    public $siswa_id_to_add = '';

    /**
     * Mount (pasang) model Ekskul saat komponen dimuat.
     */
    public function mount(Ekstrakurikuler $ekskul)
    {
        $this->ekskul = $ekskul;
    }

    /**
     * Method ini akan dipanggil untuk menambahkan siswa.
     * Ini menggantikan EkskulController@attachSiswa
     */
    public function attachSiswa()
    {
        $this->validate([
            'siswa_id_to_add' => 'required|exists:siswas,id'
        ], [
            'siswa_id_to_add.required' => 'Anda harus memilih siswa terlebih dahulu.'
        ]);

        // Cek dulu apakah siswa sudah terdaftar
        if ($this->ekskul->siswas()->where('siswa_id', $this->siswa_id_to_add)->exists()) {
            // Kirim pesan error (flash)
            session()->flash('error', 'Siswa ini sudah terdaftar di ekskul ini.');
            $this->reset('siswa_id_to_add'); // Reset dropdown
            return;
        }

        // 'attach' adalah perintah untuk relasi Many-to-Many
        $this->ekskul->siswas()->attach($this->siswa_id_to_add);
        
        // Reset dropdown
        $this->reset('siswa_id_to_add');
        
        // Kirim pesan sukses
        session()->flash('success', 'Siswa berhasil ditambahkan ke ekskul.');
    }

    /**
     * Method ini akan dipanggil untuk mengeluarkan siswa.
     * Ini menggantikan EkskulController@detachSiswa
     */
    public function detachSiswa($siswaId)
    {
        // 'detach' adalah perintah untuk relasi Many-to-Many
        $this->ekskul->siswas()->detach($siswaId);
        session()->flash('success', 'Siswa berhasil dikeluarkan dari ekskul.');
    }

    /**
     * Method render() adalah inti dari komponen Livewire.
     * Ia akan berjalan setiap kali komponen di-update.
     */
    public function render()
    {
        // 1. Kita HARUS memuat ulang relasi di dalam render()
        //    agar daftar siswa selalu update
        $this->ekskul->load(['pembina', 'siswas' => function ($query) {
            $query->orderBy('nama', 'asc');
        }]);

        // 2. Ambil ID siswa yang SUDAH terdaftar di ekskul ini
        $siswaTerdaftarIds = $this->ekskul->siswas->pluck('id');

        // 3. Ambil daftar siswa (hanya yang aktif) yang BELUM terdaftar
        //    (Ini adalah query yang sudah kita perbaiki sebelumnya)
        $siswaTersedia = Siswa::where(function ($query) {
                                $query->where('status_mukim', '!=', 'Lulus')
                                      ->orWhereNull('status_mukim');
                            })
                            ->whereNotIn('id', $siswaTerdaftarIds)
                            ->orderBy('nama', 'asc')
                            ->get();

        // 4. Kirim data ke view Livewire
        return view('livewire.manage-ekskul-members', [
            'siswaTersedia' => $siswaTersedia
        ]);
    }
}