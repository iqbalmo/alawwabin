{{-- resources/views/keuangan/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Transaksi Keuangan - SITU Al-Awwabin')
@section('header-title', 'Tambah Transaksi Keuangan')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
    
    <h2 class="text-2xl font-bold text-[#333333] mb-6">Formulir Transaksi Keuangan</h2>

    {{-- Blok Error Validasi --}}
    @if ($errors->any())
        <div class="mb-6 rounded-md bg-red-50 p-4 border border-red-200">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Terdapat {{ $errors->count() }} error:</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul role="list" class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Form Tambah --}}
    <form action="{{ route('keuangan.store') }}" method="POST" class="space-y-6">
        @csrf
        
        {{-- Kategori --}}
        {{-- Kategori (DIUBAH) --}}
        <div>
            <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori Pengeluaran</label>
            <select name="kategori" id="kategori" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#C8963E] focus:ring-[#C8963E] sm:text-sm" required>
                <option value="">-- Pilih Kategori Operasional --</option>
                {{-- Daftar Kategori Operasional --}}
                <option value="ATK" {{ old('kategori') == 'ATK' ? 'selected' : '' }}>ATK (Alat Tulis Kantor)</option>
                <option value="Utilitas" {{ old('kategori') == 'Utilitas' ? 'selected' : '' }}>Utilitas (Listrik, Air, Internet)</option>
                <option value="Transportasi" {{ old('kategori') == 'Transportasi' ? 'selected' : '' }}>Transportasi</option>
                <option value="Konsumsi" {{ old('kategori') == 'Konsumsi' ? 'selected' : '' }}>Konsumsi</option>
                <option value="Perawatan Gedung" {{ old('kategori') == 'Perawatan Gedung' ? 'selected' : '' }}>Perawatan & Perbaikan Gedung</option>
                <option value="Kegiatan Siswa" {{ old('kategori') == 'Kegiatan Siswa' ? 'selected' : '' }}>Kegiatan Siswa</option>
                <option value="Peralatan" {{ old('kategori') == 'Peralatan' ? 'selected' : '' }}>Peralatan & Perlengkapan</option>
                <option value="Administrasi" {{ old('kategori') == 'Administrasi' ? 'selected' : '' }}>Administrasi</option>
                <option value="Lain-lain" {{ old('kategori') == 'Lain-lain' ? 'selected' : '' }}>Lain-lain</option>
                {{-- Hapus Opsi Gaji --}}
                {{-- <option value="Gaji" {{ old('kategori') == 'Gaji' ? 'selected' : '' }}>Gaji</option> --}}
            </select>
        </div>

        {{-- Deskripsi --}}
        <div>
            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            <input type="text" name="deskripsi" id="deskripsi" value="{{ old('deskripsi') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#C8963E] focus:ring-[#C8963E] sm:text-sm" placeholder="Contoh: Pembelian ATK Spidol, Laminating, Jilid, dll." required>
        </div>

        {{-- Jumlah --}}
        <div>
            <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">Jumlah (Rp)</label>
            <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah') }}" step="any" min="0" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#C8963E] focus:ring-[#C8963E] sm:text-sm" placeholder="Contoh: 500000" required>
        </div>

        {{-- Tanggal Transaksi --}}
        <div>
            <label for="tanggal_transaksi" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Transaksi</label>
            <input type="date" name="tanggal_transaksi" id="tanggal_transaksi" value="{{ old('tanggal_transaksi', date('Y-m-d')) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#C8963E] focus:ring-[#C8963E] sm:text-sm" required>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex items-center space-x-4 pt-4">
            <button type="submit" class="inline-flex items-center rounded-md border border-transparent bg-[#2C5F2D] px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-[#254f26] focus:outline-none focus:ring-2 focus:ring-[#2C5F2D] focus:ring-offset-2">
                Simpan Transaksi
            </button>
            <a href="{{ route('keuangan.index') }}" class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2">
               Kembali
            </a>
        </div>
    </form>
</div>
@endsection