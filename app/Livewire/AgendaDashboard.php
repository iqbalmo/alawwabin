<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Jadwal;
use App\Models\Guru;
use Illuminate\Support\Facades\Auth;

class AgendaDashboard extends Component
{
    // Properti ini akan menampung 'guru_id' yang dipilih dari dropdown.
    // 'live: true' berarti komponen akan otomatis me-refresh saat nilainya berubah.
    #[Url(as: 'guru', keep: true)]
    public $selectedGuruId = null;

    /**
     * Method ini akan dipanggil saat tombol "Reset" diklik.
     */
    public function resetFilter()
    {
        $this->selectedGuruId = null;
    }

    /**
     * Method render ini berisi SEMUA LOGIKA
     * yang sebelumnya ada di AgendaController@index.
     */
    public function render()
    {
        $user = Auth::user();
        $query = Jadwal::query();
        
        $allGurus = collect(); // Default koleksi kosong

        if ($user->hasRole('admin')) {
            // Admin bisa melihat semua guru di filter
            $allGurus = Guru::orderBy('nama')->get();
            
            // Jika Admin MEMILIH seorang guru dari dropdown, filter query-nya
            if ($this->selectedGuruId) {
                $query->where('guru_id', $this->selectedGuruId);
            }
            // Jika $this->selectedGuruId null, query tidak difilter (Admin melihat SEMUA jadwal)

        } else {
            // Jika user BUKAN admin (Guru/Wali Kelas),
            // paksa filter HANYA menampilkan jadwal milik mereka
            $query->where('guru_id', $user->guru_id);
        }
        
        // 1. Tentukan urutan hari
        $orderHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        // 2. Ambil semua jadwal (yang sudah difilter)
        $jadwals = $query->with(['kelas', 'mapel', 'guru'])
            ->withCount('agendas') // Hitung progres
            ->orderBy('jam_mulai', 'asc')
            ->get();

        // 3. Kelompokkan jadwal berdasarkan hari
        $groupedJadwals = $jadwals->groupBy('hari');

        // 4. Urutkan grup hari sesuai $orderHari
        $orderedJadwals = collect([]);
        foreach ($orderHari as $hari) {
            if ($groupedJadwals->has($hari)) {
                $orderedJadwals->put($hari, $groupedJadwals->get($hari));
            }
        }

        // 5. Kirim semua data ke view Livewire
        return view('livewire.agenda-dashboard', [
            'orderedJadwals' => $orderedJadwals,
            'allGurus' => $allGurus
        ]);
    }
}