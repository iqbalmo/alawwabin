<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Guru;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class SearchGuru extends Component
{
    use WithPagination;

    //#[Url(except: '')]
    public $search = '';

    public function render()
    {
        // Logika query yang kita pindahkan dari GuruController
        $query = Guru::with('mapels', 'wali');

        if (strlen($this->search) >= 1) {
            $query->where(function($q) {
                // Sesuaikan kolom pencarian
                $q->where('nama', 'like', '%' . $this->search . '%') 
                  ->orWhere('nip', 'like', '%' . $this->search . '%');
            });
        }

        $guru = $query->orderBy('nama', 'asc')->paginate(15);

        return view('livewire.search-guru', [
            'guru' => $guru,
        ]);
    }

    // Method untuk mereset pencarian
    public function resetSearch()
    {
        $this->reset('search');
        $this->gotoPage(1);
    }

    // Dipanggil setiap kali $search di-update
    public function updatingSearch()
    {
        $this->gotoPage(1);
    }

    public function deleteGuru($guruId)
    {
        try {
            // 1. Cari guru
            $guru = Guru::findOrFail($guruId);
            $namaGuru = $guru->nama;
            
            // 2. Hapus guru
            $guru->delete();

            // 3. Kirim pesan sukses
            session()->flash('success', "Data guru ($namaGuru) berhasil dihapus.");

        } catch (\Exception $e) {
            // Tangkap jika ada error (misal: guru tidak ditemukan)
            session()->flash('error', 'Terjadi kesalahan saat menghapus data guru.');
        }
    }
}