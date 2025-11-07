{{-- resources/views/gaji/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Pembayaran Gaji Guru - SITU Al-Awwabin')
@section('header-title', 'Pembayaran Gaji Guru')

@section('content')

{{-- Header & Filter Bulan/Tahun --}}
<div class="sm:flex sm:items-center sm:justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold tracking-tight text-[#333333]">Pembayaran Gaji Guru</h2>
        <p class="mt-2 text-sm text-gray-500">
            Tandai gaji guru yang sudah dibayarkan untuk periode tertentu.
        </p>
    </div>
    {{-- Form Filter --}}
    <form method="GET" action="{{ route('gaji.index') }}" class="mt-4 sm:mt-0 sm:ml-16 flex items-end space-x-2">
        <div>
            <label for="bulan" class="block text-sm font-medium text-gray-700">Bulan</label>
            <select name="bulan" id="bulan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#C8963E] focus:ring-[#C8963E] sm:text-sm">
                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>
        </div>
        <div>
            <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
            <input type="number" name="tahun" id="tahun" value="{{ $tahun }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#C8963E] focus:ring-[#C8963E] sm:text-sm" placeholder="YYYY">
        </div>
        <button type="submit" class="inline-flex items-center rounded-md border border-transparent bg-[#2C5F2D] px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-[#254f26]">
            Filter
        </button>
    </form>
</div>

{{-- Pesan Sukses/Error --}}
@if(session('success'))
    <div class="mb-6 rounded-md bg-green-50 p-4 border border-green-200"> Pembayaran gaji sudah lunas </div>
@endif
@if(session('error'))
    <div class="mb-6 rounded-md bg-red-50 p-4 border border-red-200"> Pembayaran tidak dapat dilakukan </div>
@endif

{{-- Tabel Gaji --}}
<div class="flow-root">
    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Nama Guru</th>
                            <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Gaji Pokok (Rp)</th>
                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Status Pembayaran ({{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }})</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tanggal Bayar</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($gurus as $guru)
                        @php
                            $sudahDibayar = $gajisDibayar->has($guru->id);
                            $tanggalBayar = $sudahDibayar ? $gajisDibayar->get($guru->id)->format('d M Y') : '-';
                        @endphp
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $guru->nama }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-right">{{ number_format($guru->gaji_pokok ?? 0, 0, ',', '.') }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-center">
                                @if($sudahDibayar)
                                    <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">Sudah Dibayar</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">Belum Dibayar</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $tanggalBayar }}</td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-center text-sm font-medium sm:pr-6">
                                @if(!$sudahDibayar)
                                    <form action="{{ route('gaji.bayar', $guru) }}" method="POST" onsubmit="return confirm('Tandai gaji {{ $guru->nama }} untuk bulan {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }} sebagai LUNAS?')">
                                        @csrf
                                        <input type="hidden" name="bulan" value="{{ $bulan }}">
                                        <input type="hidden" name="tahun" value="{{ $tahun }}">
                                        <button type="submit" class="text-white bg-[#2C5F2D] hover:bg-[#1e421f] rounded-md px-3 py-1 text-xs">
                                            Tandai Lunas
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-xs italic">Lunas</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">
                                Belum ada data guru.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection