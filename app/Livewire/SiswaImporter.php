<?php

namespace App\Livewire;

use App\Imports\SiswaImport;
use App\Models\Kelas;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class SiswaImporter extends Component
{
    use WithFileUploads;

    public $file;

    public $excelHeaders = [];

    public $friendlyHeaders = [];

    public $dbColumns = [
        'Data Inti (Wajib)' => [
            'nama' => 'Nama Lengkap',
            'nis' => 'NIS (Lokal)',
            'tingkat' => 'Tingkat Kelas (Cth: 7, 8, atau 9)',
            'nama_kelas' => 'Nama Kelas/Rombel (Cth: A, B, atau MIPA 1)',
        ],
        'Data Pribadi Siswa' => [
            'no_absen' => 'No. Absen',
            'nisn' => 'NISN',
            'nik_siswa' => 'NIK Siswa',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir (Cth: 2013-02-21)',
            'jenis_kelamin' => 'Jenis Kelamin (L/P)',
            'no_kk' => 'Nomor KK',
        ],
        'Data Kesiswaan' => [
            'anak_ke' => 'Anak Ke-',
            'jumlah_saudara' => 'Jumlah Saudara',
            'sekolah_asal' => 'Sekolah Asal',
            'status_mukim' => 'Status Mukim (MUKIM / PP)',
        ],
        'Data Ayah' => [
            'nama_ayah' => 'Nama Ayah',
            'ttl_ayah' => 'Tempat & Tgl Lahir Ayah',
            'pendidikan_ayah' => 'Pendidikan Ayah',
            'pekerjaan_ayah' => 'Pekerjaan Ayah',
            'hp_ayah' => 'No. HP Ayah',
            'email_ayah' => 'Email Ayah',
        ],
        'Data Ibu' => [
            'nama_ibu' => 'Nama Ibu',
            'ttl_ibu' => 'Tempat & Tgl Lahir Ibu',
            'pendidikan_ibu' => 'Pendidikan Ibu',
            'pekerjaan_ibu' => 'Pekerjaan Ibu',
            'hp_ibu' => 'No. HP Ibu',
            'email_ibu' => 'Email Ibu',
        ],
        'Data Wali (Opsional)' => [
            'nama_wali' => 'Nama Wali',
            'ttl_wali' => 'Tempat & Tgl Lahir Wali',
            'alamat_wali' => 'Alamat Wali',
            'pekerjaan_wali' => 'Pekerjaan Wali',
        ],
        'Data Alamat Orang Tua' => [
            'alamat_orangtua' => 'Alamat Orang Tua',
            'kelurahan' => 'Kelurahan/Desa',
            'kecamatan' => 'Kecamatan',
            'kota' => 'Kabupaten/Kota',
            'provinsi' => 'Provinsi',
            'kodepos' => 'Kode Pos',
        ],
    ];

    public $mapping = [];

    public $importErrors = [];

    public $importSuccess = false;

    /**
     * Dipanggil setiap kali file baru di-upload.
     */
    public function updatedFile()
    {
        $this->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240', // Maks 10MB
        ]);

        $this->reset(['excelHeaders', 'friendlyHeaders', 'mapping', 'importErrors', 'importSuccess']);

        try {
            $this->excelHeaders = (new HeadingRowImport)->toArray($this->file)[0][0];
            $this->buildFriendlyHeaders();
            $this->autoMapHeaders(); // Panggil auto-mapping yang baru

        } catch (\Exception $e) {
            $this->addError('file', 'Gagal membaca file. Pastikan file tidak rusak dan formatnya benar. Error: '.$e->getMessage());
        }
    }

    /**
     * Membuat nama header yang mudah dibaca manusia
     */
    private function buildFriendlyHeaders()
    {
        $headerCounts = [];
        $this->friendlyHeaders = [];

        foreach ($this->excelHeaders as $header) {
            if (is_null($header)) {
                continue;
            } // Lewati header yang null

            $friendlyName = ucwords(str_replace('_', ' ', $header));
            $baseName = preg_replace('/ [0-9]+$/', '', $friendlyName);

            if (! isset($headerCounts[$baseName])) {
                $headerCounts[$baseName] = 0;
            }
            $headerCounts[$baseName]++;

            if ($headerCounts[$baseName] > 1) {
                $friendlyName = $baseName.' (Kolom ke-'.$headerCounts[$baseName].')';
            }

            $this->friendlyHeaders[$header] = $friendlyName;
        }
    }

    /**
     * --- INI ADALAH FUNGSI AUTO-MAPPING YANG DIPERBARUI (LEBIH PINTAR) ---
     */
    public function autoMapHeaders()
    {
        $this->mapping = [];
        $usedExcelHeaders = [];

        $cleanStr = function ($str) {
            return strtolower(trim(preg_replace('/\s*\(.+\)/', '', str_replace('_', ' ', $str))));
        };

        // --- TAHAP 1: CARI KECOCOKAN SEMPURNA (EXACT MATCH) ---
        // Kita tambahkan loop luar untuk $group
        foreach ($this->dbColumns as $group => $columns) {
            foreach ($columns as $dbCol => $label) {
                $cleanDbCol = $cleanStr($dbCol);
                $cleanLabel = $cleanStr($label);

                foreach ($this->friendlyHeaders as $originalHeader => $friendlyName) {
                    if (in_array($originalHeader, $usedExcelHeaders)) {
                        continue;
                    }

                    $cleanHeader = $cleanStr($friendlyName);

                    if ($cleanDbCol == $cleanHeader || $cleanLabel == $cleanHeader) {
                        $this->mapping[$dbCol] = $originalHeader;
                        $usedExcelHeaders[] = $originalHeader;
                        break;
                    }
                }
            }
        }

        // --- TAHAP 2: CARI KECOCOKAN BERDASARKAN KATA KUNCI SPESIFIK ---
        // Kita tambahkan loop luar untuk $group
        foreach ($this->dbColumns as $group => $columns) {
            foreach ($columns as $dbCol => $label) {
                if (isset($this->mapping[$dbCol])) {
                    continue;
                }

                foreach ($this->friendlyHeaders as $originalHeader => $friendlyName) {
                    if (in_array($originalHeader, $usedExcelHeaders)) {
                        continue;
                    }

                    $cleanHeader = $cleanStr($friendlyName);
                    $matched = false;

                    // Tentukan aturan spesifik
                    switch ($dbCol) {
                        case 'no_kk':
                            $matched = str_contains($cleanHeader, 'kk') || str_contains($cleanHeader, 'kartu keluarga');
                            break;
                        case 'hp_ayah':
                            $matched = (str_contains($cleanHeader, 'hp') || str_contains($cleanHeader, 'telepon')) && str_contains($cleanHeader, 'ayah');
                            break;
                        case 'hp_ibu':
                            $matched = (str_contains($cleanHeader, 'hp') || str_contains($cleanHeader, 'telepon')) && str_contains($cleanHeader, 'ibu');
                            break;
                        case 'no_absen':
                            $matched = str_contains($cleanHeader, 'absen');
                            break;
                        case 'nis':
                            $matched = str_contains($cleanHeader, 'nis') && ! str_contains($cleanHeader, 'nisn'); // Pastikan bukan NISN
                            break;
                        case 'nisn':
                            $matched = str_contains($cleanHeader, 'nisn');
                            break;
                        case 'nik_siswa':
                            $matched = str_contains($cleanHeader, 'nik');
                            break;
                    }

                    if ($matched) {
                        $this->mapping[$dbCol] = $originalHeader;
                        $usedExcelHeaders[] = $originalHeader;
                        break;
                    }
                }
            }
        }
    }

    /**
     * Ini adalah Langkah 3: Proses Import.
     */
    public function import()
    {
        // Validasi baru, pastikan 4 kolom wajib terpetakan
        $this->validate([
            'file' => 'required',
            'mapping.nama' => 'required',
            'mapping.nis' => 'required',
            'mapping.tingkat' => 'required',
            'mapping.nama_kelas' => 'required',
        ], [
            'mapping.*.required' => 'Kolom ini wajib dipetakan.',
        ]);

        $this->reset(['importErrors', 'importSuccess']);
        $filePath = $this->file->getRealPath();

        try {
            // Buat instance Kelas cache dan kirim ke worker
            $kelasCache = Kelas::all()->mapWithKeys(function ($kelas) {
                // Buat key unik cth: "7-a"
                $key = strtolower(trim($kelas->tingkat)).'-'.strtolower(trim($kelas->nama_kelas));

                return [$key => $kelas->id];
            });

            // Kirim pemetaan DAN cache kelas ke class Import
            Excel::import(new SiswaImport($this->mapping, $kelasCache->toArray()), $filePath);

            $this->importSuccess = true;
            $this->reset('file', 'mapping', 'excelHeaders', 'friendlyHeaders'); // Hapus file & reset form

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // Tangkap error validasi dari dalam Excel
            $this->importErrors = collect($e->failures())->map(function ($f) {
                return [
                    'row' => $f->row(),
                    'attribute' => $f->attribute(),
                    'errors' => $f->errors(),
                    'values' => $f->values(),
                ];
            })->toArray();
        } catch (\Exception $e) {
            // Tangkap error umum (misal: kelas tidak ditemukan)
            $this->addError('file', 'Terjadi kesalahan saat impor. Error: '.$e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.siswa-importer');
    }
}
