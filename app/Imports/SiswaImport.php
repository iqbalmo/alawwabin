<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithStartRow; // <-- 1. TAMBAHKAN IMPORT INI

class SiswaImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts, WithChunkReading, WithStartRow // <-- 2. TAMBAHKAN INTERFACE INI
{
    private $mapping;
    private $kelasCache; 

    public function __construct(array $mapping, array $kelasCache)
    {
        $this->mapping = $mapping;
        $this->kelasCache = $kelasCache;
    }

    // --- 3. TAMBAHKAN METHOD BARU DI BAWAH INI ---
    /**
     * Tentukan baris dimulainya data (bukan header).
     * Dengan WithHeadingRow, baris 1 adalah header.
     * Kita ingin skip baris 2 (sub-header), jadi data dimulai di baris 3.
     */
    public function startRow(): int
    {
        return 3; 
    }
    // ---------------------------------------------

    /**
     * Mengubah nama header Excel (dari mapping) menjadi key yang bersih.
     * Cth: "Nama Lengkap" -> "nama_lengkap"
     */
    private function getRowKey($dbColumnName)
    {
        if (!isset($this->mapping[$dbColumnName])) {
            return null; // Kolom ini tidak dipetakan
        }
        
        $excelHeader = $this->mapping[$dbColumnName];
        return strtolower(str_replace(' ', '_', $excelHeader));
    }
    
    /**
     * Mencari ID Kelas dari cache.
     */
    private function getKelasId(array $row)
    {
        $tingkatKey = $this->getRowKey('tingkat');
        $namaKelasKey = $this->getRowKey('nama_kelas');

        if (!$tingkatKey || !$namaKelasKey) {
            return null; // Jika tingkat atau nama kelas tidak dipetakan
        }

        $tingkat = strtolower(trim($row[$tingkatKey] ?? ''));
        $namaKelas = strtolower(trim($row[$namaKelasKey] ?? ''));
        
        // Buat key cache, cth: "7-a"
        $cacheKey = $tingkat . '-' . $namaKelas;

        // Cari di cache yang sudah kita buat di Controller
        return $this->kelasCache[$cacheKey] ?? null;
    }

    /**
     * Mengubah format tanggal dari Excel.
     */
    private function parseTanggal($row, $dbColumnName)
    {
        $key = $this->getRowKey($dbColumnName);
        if (!$key || empty($row[$key])) {
            return null;
        }

        $tglExcel = $row[$key];

        try {
            if (is_numeric($tglExcel)) {
                // Konversi dari format 'Serial Number Date' Excel (cth: 45123)
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tglExcel);
            }
            // Coba parse format string (cth: "21-02-2013" atau "2013/02/21")
            return \Carbon\Carbon::parse($tglExcel);
        } catch (\Exception $e) {
            return null; // Biarkan null jika formatnya tidak dikenal
        }
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Fungsi ini dipanggil untuk SETIAP BARIS di Excel

        // 1. Dapatkan ID Kelas
        $kelasId = $this->getKelasId($row);
        
        // Jika kelasId tidak ditemukan DAN kolom wajib (nama/nis) kosong, 
        // kemungkinan ini baris kosong di akhir file. Skip.
        if (empty($kelasId) && empty($row[$this->getRowKey('nama')]) && empty($row[$this->getRowKey('nis')])) {
            return null;
        }

        // 2. Dapatkan Tanggal Lahir
        $tanggalLahir = $this->parseTanggal($row, 'tanggal_lahir');

        // 3. Buat model Siswa dengan SEMUA data yang dipetakan
        return new Siswa([
            'nama'            => $row[$this->getRowKey('nama')] ?? null,
            'nis'             => $row[$this->getRowKey('nis')] ?? null,
            'kelas_id'        => $kelasId,
            
            'no_absen'        => $row[$this->getRowKey('no_absen')] ?? null,
            'nisn'            => $row[$this->getRowKey('nisn')] ?? null,
            'nik_siswa'       => $row[$this->getRowKey('nik_siswa')] ?? null,
            'tempat_lahir'    => $row[$this->getRowKey('tempat_lahir')] ?? null,
            'tanggal_lahir'   => $tanggalLahir,
            'jenis_kelamin'   => $row[$this->getRowKey('jenis_kelamin')] ?? null,
            'no_kk'           => $row[$this->getRowKey('no_kk')] ?? null,
            'anak_ke'         => $row[$this->getRowKey('anak_ke')] ?? null,
            'jumlah_saudara'  => $row[$this->getRowKey('jumlah_saudara')] ?? null,
            'sekolah_asal'    => $row[$this->getRowKey('sekolah_asal')] ?? null,
            'status_mukim'    => $row[$this->getRowKey('status_mukim')] ?? null,
            
            'nama_ayah'       => $row[$this->getRowKey('nama_ayah')] ?? null,
            'ttl_ayah'        => $row[$this->getRowKey('ttl_ayah')] ?? null,
            'pendidikan_ayah' => $row[$this->getRowKey('pendidikan_ayah')] ?? null,
            'pekerjaan_ayah'  => $row[$this->getRowKey('pekerjaan_ayah')] ?? null,
            'hp_ayah'         => $row[$this->getRowKey('hp_ayah')] ?? null,
            'email_ayah'      => $row[$this->getRowKey('email_ayah')] ?? null,
            
            'nama_ibu'        => $row[$this->getRowKey('nama_ibu')] ?? null,
            'ttl_ibu'         => $row[$this->getRowKey('ttl_ibu')] ?? null,
            'pendidikan_ibu'  => $row[$this->getRowKey('pendidikan_ibu')] ?? null,
            'pekerjaan_ibu'   => $row[$this->getRowKey('pekerjaan_ibu')] ?? null,
            'hp_ibu'          => $row[$this->getRowKey('hp_ibu')] ?? null,
            'email_ibu'       => $row[$this->getRowKey('email_ibu')] ?? null,
            
            'nama_wali'       => $row[$this->getRowKey('nama_wali')] ?? null,
            'ttl_wali'        => $row[$this->getRowKey('ttl_wali')] ?? null,
            'alamat_wali'     => $row[$this->getRowKey('alamat_wali')] ?? null,
            'pekerjaan_wali'  => $row[$this->getRowKey('pekerjaan_wali')] ?? null,
            
            'alamat_orangtua' => $row[$this->getRowKey('alamat_orangtua')] ?? null,
            'kelurahan'       => $row[$this->getRowKey('kelurahan')] ?? null,
            'kecamatan'       => $row[$this->getRowKey('kecamatan')] ?? null,
            'kota'            => $row[$this->getRowKey('kota')] ?? null,
            'provinsi'        => $row[$this->getRowKey('provinsi')] ?? null,
            'kodepos'         => $row[$this->getRowKey('kodepos')] ?? null,
        ]);
    }

    /**
     * Tentukan aturan validasi untuk data di dalam Excel.
     */
    public function rules(): array
    {
        // Validasi akan berjalan pada NAMA HEADER ASLI di Excel
        return [
            $this->getRowKey('nama') => 'required|string',
            $this->getRowKey('nis') => 'required|string|unique:siswas,nis',
            
            // Validasi Tingkat & Nama Kelas (agar 'getKelasId' tidak error)
            $this->getRowKey('tingkat') => 'required',
            $this->getRowKey('nama_kelas') => 'required',
            
            // Validasi opsional (jika ada)
            $this->getRowKey('nisn') => 'nullable|string|unique:siswas,nisn',
            $this->getRowKey('nik_siswa') => 'nullable|string|unique:siswas,nik_siswa',
            $this->getRowKey('jenis_kelamin') => 'nullable|in:L,P,l,p,Laki-laki,Perempuan',
            $this->getRowKey('email_ayah') => 'nullable|email',
            $this->getRowKey('email_ibu') => 'nullable|email',
        ];
    }

    /**
     * Tentukan pesan error kustom.
     */
    public function customValidationMessages()
    {
        return [
            $this->getRowKey('nama').'.required' => 'Kolom Nama (yang Anda petakan) wajib diisi di setiap baris Excel.',
            $this->getRowKey('nis').'.required' => 'Kolom NIS (yang Anda petakan) wajib diisi.',
            $this->getRowKey('nis').'.unique' => 'NIS di Excel ada yang duplikat dengan data di sistem.',
            $this->getRowKey('tingkat').'.required' => 'Kolom Tingkat (yang Anda petakan) wajib diisi.',
            $this->getRowKey('nama_kelas').'.required' => 'Kolom Nama Kelas (yang Anda petakan) wajib diisi.',
            $this->getRowKey('nisn').'.unique' => 'NISN di Excel ada yang duplikat dengan data di sistem.',
            $this->getRowKey('nik_siswa').'.unique' => 'NIK Siswa di Excel ada yang duplikat dengan data di sistem.',
        ];
    }

    // Fungsi performa
    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }
}