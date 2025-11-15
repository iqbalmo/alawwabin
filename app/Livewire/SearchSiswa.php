<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Siswa;
use Livewire\WithPagination; // Penting untuk paginasi

class SearchSiswa extends Component
{
    use WithPagination; // Aktifkan paginasi Livewire

    // 'search' akan terhubung ke input field di view
    // 'live' berarti akan update otomatis saat mengetik
    //#[Url(except: '')]
    public $search = '';

    // Method untuk merender komponen
    public function render()
    {
        // Logika query yang kita pindahkan dari SiswaController
        $query = Siswa::with('kelas')
                      ->where(function ($q) {
                          // Hanya cari siswa yang AKTIF (bukan lulus atau null)
                          $q->where('status_mukim', '!=', 'Lulus')
                            ->orWhereNull('status_mukim');
                      });

        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                  ->orWhere('nis', 'like', '%' . $this->search . '%');
            });
        }

        $siswa = $query->orderBy('nama', 'asc')->paginate(15);

        return view('livewire.search-siswa', [
            'siswa' => $siswa,
        ]);
    }

    // Method untuk mereset pencarian
    public function resetSearch()
    {
        $this->reset('search');
        $this->gotoPage(1); // Kembali ke halaman 1
    }

    // Dipanggil setiap kali $search di-update
    public function updatingSearch()
    {
        $this->gotoPage(1); // Kembali ke halaman 1 setiap kali mengetik
    }

    public function deleteSiswa($siswaId)
    {
        // 1. Cari siswa (gunakan 'findOrFail' untuk keamanan)
        try {
            $siswa = Siswa::findOrFail($siswaId);
            
            // 2. Hapus siswa
            $siswa->delete();

            // 3. Kirim pesan sukses
            // Pesan ini akan ditangkap oleh blok @if(session...) di view
            session()->flash('success', 'Data siswa (' . $siswa->nama . ') berhasil dihapus.');

            // 4. (Otomatis) Livewire akan me-render ulang komponen
            //    dan siswa yang dihapus akan hilang dari tabel.

        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat menghapus data siswa.');
        }
    }
}