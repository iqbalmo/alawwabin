{{-- resources/views/keuangan/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Transaksi Keuangan - SITU Al-Awwabin')

@section('content')

{{-- Header Halaman --}}
<div class="sm:flex sm:items-center sm:justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold tracking-tight text-[#333333]">Riwayat Transaksi Keuangan</h2>
        <p class="mt-2 text-sm text-gray-500">
            Daftar semua pengeluaran operasional.
        </p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16">
        <a href="{{ route('keuangan.create') }}"
           class="inline-flex items-center rounded-md border border-transparent bg-[#2C5F2D] px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-[#254f26] focus:outline-none focus:ring-2 focus:ring-[#2C5F2D] focus:ring-offset-2">
           + Tambah Transaksi
        </a>
    </div>
</div>

{{-- Pesan Sukses --}}
@if(session('success'))
    <div class="mb-6 rounded-md bg-green-50 p-4 border border-green-200">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
        </div>
    </div>
@endif

{{-- Tabel Transaksi --}}
<div class="flow-root">
    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Tanggal</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Kategori</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Deskripsi</th>
                            <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Jumlah (Rp)</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                <span class="sr-only">Aksi</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($transaksis as $transaksi)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $transaksi->tanggal_transaksi->format('d M Y') }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $transaksi->kategori == 'Gaji' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $transaksi->kategori }}
                                </span>
                            </td>
                            <td class="px-3 py-4 text-sm text-gray-500">{{ $transaksi->deskripsi }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-right">{{ number_format($transaksi->jumlah, 0, ',', '.') }}</td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                {{-- Nanti tambahkan link Edit/Hapus --}}
                                <a href="#" class="text-[#2C5F2D] hover:text-[#1e421f]">Edit</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">
                                Belum ada data transaksi keuangan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Link Paginasi --}}
            <div class="mt-6">
                {{ $transaksis->links() }}
            </div>
        </div>
    </div>
</div>

@endsection