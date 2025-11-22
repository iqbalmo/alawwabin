<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AbsensiRekapController extends Controller
{
    /**
     * Display overview of attendance recap
     */
    /**
     * Display overview of attendance recap
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);
        $tahunAjaranId = $request->input('tahun_ajaran_id');
        
        // If no academic year selected, use active one
        if (!$tahunAjaranId) {
            $activeTahunAjaran = TahunAjaran::getActive();
            $tahunAjaranId = $activeTahunAjaran?->id;
        }
        
        // Get all academic years for filter dropdown
        $tahunAjarans = TahunAjaran::orderBy('tanggal_mulai', 'desc')->get();
        $selectedTahunAjaran = TahunAjaran::find($tahunAjaranId);
        
        // Get all classes with attendance statistics
        // Refactored to avoid double querying for top classes
        $allKelas = Kelas::withCount(['siswa'])
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->get()
            ->map(function ($kelas) use ($bulan, $tahun, $tahunAjaranId) {
                $stats = $this->getKelasStats($kelas->id, $bulan, $tahun, $tahunAjaranId);
                return [
                    'kelas' => $kelas,
                    'stats' => $stats,
                ];
            });

        // Group for the main list
        $kelasData = $allKelas->groupBy(function ($item) {
            return $item['kelas']->tingkat;
        });

        // Calculate Dashboard Stats
        $todayStats = $this->getTodayStats();
        
        // Top 3 Classes (Highest Attendance %)
        $topClasses = $allKelas->sortByDesc(function ($item) {
            return $item['stats']['persentase_hadir'];
        })->take(3);

        // Top 5 Students (Most Absences/Alpa)
        $topAbsentees = $this->getTopAbsentees($bulan, $tahun, $tahunAjaranId);

        return view('absensi.rekap.index', compact('kelasData', 'todayStats', 'topClasses', 'topAbsentees', 'bulan', 'tahun', 'tahunAjarans', 'selectedTahunAjaran'));
    }

    /**
     * Get attendance statistics for today
     */
    private function getTodayStats()
    {
        $today = Carbon::today();
        $agendas = Agenda::whereDate('tanggal', $today)->get();
        
        $hadir = 0;
        $sakit = 0;
        $izin = 0;
        $alpa = 0;
        
        foreach ($agendas as $agenda) {
            foreach ($agenda->absensi_siswa ?? [] as $status) {
                switch (strtolower($status)) {
                    case 'hadir': $hadir++; break;
                    case 'sakit': $sakit++; break;
                    case 'izin': $izin++; break;
                    case 'alpa': $alpa++; break;
                }
            }
        }
        
        return compact('hadir', 'sakit', 'izin', 'alpa');
    }

    /**
     * Get top 5 students with most Alpa in the selected month
     */
    private function getTopAbsentees($bulan, $tahun, $tahunAjaranId = null)
    {
        $startDate = Carbon::parse("$tahun-$bulan-01")->startOfMonth();
        $endDate = Carbon::parse("$tahun-$bulan-01")->endOfMonth();

        $query = Agenda::whereBetween('tanggal', [$startDate, $endDate]);
        
        if ($tahunAjaranId) {
            $query->where('tahun_ajaran_id', $tahunAjaranId);
        }
        
        $agendas = $query->get();
        
        $alpaCounts = [];
        
        foreach ($agendas as $agenda) {
            foreach ($agenda->absensi_siswa ?? [] as $siswaId => $status) {
                if (strtolower($status) === 'alpa') {
                    if (!isset($alpaCounts[$siswaId])) {
                        $alpaCounts[$siswaId] = 0;
                    }
                    $alpaCounts[$siswaId]++;
                }
            }
        }
        
        // Sort by count desc
        arsort($alpaCounts);
        $topIds = array_slice(array_keys($alpaCounts), 0, 5);
        
        if (empty($topIds)) return collect([]);

        $students = Siswa::whereIn('id', $topIds)->with('kelas')->get()->keyBy('id');
        
        $results = [];
        foreach ($alpaCounts as $id => $count) {
            if (isset($students[$id]) && count($results) < 5) {
                $results[] = [
                    'siswa' => $students[$id],
                    'jumlah_alpa' => $count
                ];
            }
        }
        
        return collect($results);
    }

    /**
     * Display attendance recap for a specific class
     */
    public function perKelas(Request $request, $kelasId)
    {
        $kelas = Kelas::with('siswa')->findOrFail($kelasId);
        
        // Get filter parameters
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);
        $tahunAjaranId = $request->input('tahun_ajaran_id');
        
        // If no academic year selected, use active one
        if (!$tahunAjaranId) {
            $activeTahunAjaran = TahunAjaran::getActive();
            $tahunAjaranId = $activeTahunAjaran?->id;
        }
        
        // Get all academic years for filter dropdown
        $tahunAjarans = TahunAjaran::orderBy('tanggal_mulai', 'desc')->get();
        $selectedTahunAjaran = TahunAjaran::find($tahunAjaranId);
        
        // Get attendance statistics for each student in the class
        $siswaStats = $kelas->siswa->map(function ($siswa) use ($bulan, $tahun, $tahunAjaranId) {
            return [
                'siswa' => $siswa,
                'stats' => $this->getSiswaStats($siswa->id, $bulan, $tahun, $tahunAjaranId),
            ];
        });

        return view('absensi.rekap.per_kelas', compact('kelas', 'siswaStats', 'bulan', 'tahun', 'tahunAjarans', 'selectedTahunAjaran'));
    }

    /**
     * Display detailed attendance recap for a specific student
     */
    public function perSiswa(Request $request, $siswaId)
    {
        $siswa = Siswa::with('kelas')->findOrFail($siswaId);
        
        // Get filter parameters
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);
        $tahunAjaranId = $request->input('tahun_ajaran_id');
        
        // If no academic year selected, use active one
        if (!$tahunAjaranId) {
            $activeTahunAjaran = TahunAjaran::getActive();
            $tahunAjaranId = $activeTahunAjaran?->id;
        }
        
        // Get all academic years for filter dropdown
        $tahunAjarans = TahunAjaran::orderBy('tanggal_mulai', 'desc')->get();
        $selectedTahunAjaran = TahunAjaran::find($tahunAjaranId);
        
        // Get attendance statistics
        $stats = $this->getSiswaStats($siswaId, $bulan, $tahun, $tahunAjaranId);
        
        // Get detailed attendance records from agendas
        $startDate = Carbon::parse("$tahun-$bulan-01")->startOfMonth();
        $endDate = Carbon::parse("$tahun-$bulan-01")->endOfMonth();
        
        // Get all agendas for this student's class in the date range
        $attendanceQuery = Agenda::whereHas('jadwal', function ($query) use ($siswa) {
                $query->where('kelas_id', $siswa->kelas_id);
            })
            ->whereBetween('tanggal', [$startDate, $endDate]);
        
        if ($tahunAjaranId) {
            $attendanceQuery->where('tahun_ajaran_id', $tahunAjaranId);
        }
        
        $attendanceRecords = $attendanceQuery->orderBy('tanggal', 'desc')
            ->get()
            ->map(function ($agenda) use ($siswaId) {
                $absensiData = $agenda->absensi_siswa ?? [];
                $status = $absensiData[$siswaId] ?? null;
                
                if ($status) {
                    return (object) [
                        'tanggal' => $agenda->tanggal,
                        'status' => $status,
                        'keterangan' => null, // Agenda tidak menyimpan keterangan terpisah
                    ];
                }
                return null;
            })
            ->filter(); // Remove null entries

        return view('absensi.rekap.per_siswa', compact('siswa', 'stats', 'attendanceRecords', 'bulan', 'tahun', 'tahunAjarans', 'selectedTahunAjaran'));
    }

    /**
     * Export attendance data
     */
    public function export($type, $kelasId)
    {
        // TODO: Implement PDF/Excel export
        return redirect()->back()->with('info', 'Fitur export sedang dalam pengembangan.');
    }

    /**
     * Get attendance statistics for a specific student
     */
    private function getSiswaStats($siswaId, $bulan, $tahun, $tahunAjaranId = null)
    {
        $startDate = Carbon::parse("$tahun-$bulan-01")->startOfMonth();
        $endDate = Carbon::parse("$tahun-$bulan-01")->endOfMonth();

        // Get student's class
        $siswa = Siswa::find($siswaId);
        if (!$siswa) {
            return $this->emptyStats();
        }

        // Get all agendas for this student's class in the date range
        $query = Agenda::whereHas('jadwal', function ($query) use ($siswa) {
                $query->where('kelas_id', $siswa->kelas_id);
            })
            ->whereBetween('tanggal', [$startDate, $endDate]);
        
        if ($tahunAjaranId) {
            $query->where('tahun_ajaran_id', $tahunAjaranId);
        }
        
        $agendas = $query->get();

        // Count attendance statuses
        $hadir = 0;
        $sakit = 0;
        $izin = 0;
        $alpa = 0;

        foreach ($agendas as $agenda) {
            $absensiData = $agenda->absensi_siswa ?? [];
            $status = $absensiData[$siswaId] ?? null;
            
            if ($status) {
                switch (strtolower($status)) {
                    case 'hadir':
                        $hadir++;
                        break;
                    case 'sakit':
                        $sakit++;
                        break;
                    case 'izin':
                        $izin++;
                        break;
                    case 'alpa':
                        $alpa++;
                        break;
                }
            }
        }

        $total = $hadir + $sakit + $izin + $alpa;

        return [
            'hadir' => $hadir,
            'sakit' => $sakit,
            'izin' => $izin,
            'alpa' => $alpa,
            'total' => $total,
            'persentase_hadir' => $total > 0 ? round(($hadir / $total) * 100, 1) : 0,
        ];
    }

    /**
     * Get attendance statistics for a specific class
     */
    private function getKelasStats($kelasId, $bulan, $tahun, $tahunAjaranId = null)
    {
        $startDate = Carbon::parse("$tahun-$bulan-01")->startOfMonth();
        $endDate = Carbon::parse("$tahun-$bulan-01")->endOfMonth();

        // Get all agendas for this class in the date range
        $query = Agenda::whereHas('jadwal', function ($query) use ($kelasId) {
                $query->where('kelas_id', $kelasId);
            })
            ->whereBetween('tanggal', [$startDate, $endDate]);
        
        if ($tahunAjaranId) {
            $query->where('tahun_ajaran_id', $tahunAjaranId);
        }
        
        $agendas = $query->get();

        // Count attendance statuses
        $hadir = 0;
        $sakit = 0;
        $izin = 0;
        $alpa = 0;

        foreach ($agendas as $agenda) {
            $absensiData = $agenda->absensi_siswa ?? [];
            
            foreach ($absensiData as $siswaId => $status) {
                switch (strtolower($status)) {
                    case 'hadir':
                        $hadir++;
                        break;
                    case 'sakit':
                        $sakit++;
                        break;
                    case 'izin':
                        $izin++;
                        break;
                    case 'alpa':
                        $alpa++;
                        break;
                }
            }
        }

        $total = $hadir + $sakit + $izin + $alpa;

        return [
            'hadir' => $hadir,
            'sakit' => $sakit,
            'izin' => $izin,
            'alpa' => $alpa,
            'total' => $total,
            'persentase_hadir' => $total > 0 ? round(($hadir / $total) * 100, 1) : 0,
        ];
    }

    /**
     * Get school-wide attendance statistics
     */
    private function getSchoolStats($bulan, $tahun)
    {
        $startDate = Carbon::parse("$tahun-$bulan-01")->startOfMonth();
        $endDate = Carbon::parse("$tahun-$bulan-01")->endOfMonth();

        // Get all agendas in the date range
        $agendas = Agenda::whereBetween('tanggal', [$startDate, $endDate])->get();

        // Count attendance statuses
        $hadir = 0;
        $sakit = 0;
        $izin = 0;
        $alpa = 0;

        foreach ($agendas as $agenda) {
            $absensiData = $agenda->absensi_siswa ?? [];
            
            foreach ($absensiData as $siswaId => $status) {
                switch (strtolower($status)) {
                    case 'hadir':
                        $hadir++;
                        break;
                    case 'sakit':
                        $sakit++;
                        break;
                    case 'izin':
                        $izin++;
                        break;
                    case 'alpa':
                        $alpa++;
                        break;
                }
            }
        }

        $total = $hadir + $sakit + $izin + $alpa;

        return [
            'hadir' => $hadir,
            'sakit' => $sakit,
            'izin' => $izin,
            'alpa' => $alpa,
            'total' => $total,
            'persentase_hadir' => $total > 0 ? round(($hadir / $total) * 100, 1) : 0,
        ];
    }

    /**
     * Return empty statistics
     */
    private function emptyStats()
    {
        return [
            'hadir' => 0,
            'sakit' => 0,
            'izin' => 0,
            'alpa' => 0,
            'total' => 0,
            'persentase_hadir' => 0,
        ];
    }
}
