@extends('layouts.app')

@section('title', 'Ubah Password')
@section('header-title', 'Ubah Password')

@section('content')
<div class="max-w-2xl mx-auto">

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
    
    <form action="{{ route('password.update') }}" method="POST" 
          class="bg-white shadow-md rounded-lg p-6 md:p-8"
          {{-- Kita gunakan Alpine.js untuk 'show password' --}}
          x-data="{ showCurrent: false, showNew: false, showConfirm: false }">
        @csrf
        
        <div class="space-y-6">

            <!-- Judul Form -->
            <div class="border-b border-gray-900/10 pb-6">
                <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Keamanan Akun</h2>
                <p class="mt-2 text-sm text-gray-600">Perbarui password Anda secara berkala untuk menjaga keamanan akun.</p>
            </div>

            <!-- Field 1: Password Saat Ini -->
            <div>
                <label for="current_password" class="block text-sm font-medium leading-6 text-gray-900">Password Saat Ini</label>
                <div class="mt-2 relative">
                    <input :type="showCurrent ? 'text' : 'password'" 
                           name="current_password" id="current_password" required
                           class="block w-full rounded-md border-0 px-3 py-1.5 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6 @error('current_password') ring-red-500 @enderror">
                    <button type="button" @click="showCurrent = !showCurrent" class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <svg x-show="!showCurrent" class="h-5 w-5 text-gray-400" ... (Ikon Mata) ...></svg>
                        <svg x-show="showCurrent" x-cloak class="h-5 w-5 text-gray-400" ... (Ikon Mata Coret) ...></svg>
                    </button>
                </div>
                @error('current_password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Field 2: Password Baru -->
            <div>
                <label for="new_password" class="block text-sm font-medium leading-6 text-gray-900">Password Baru</label>
                <div class="mt-2 relative">
                    <input :type="showNew ? 'text' : 'password'"
                           name="new_password" id="new_password" required
                           class="block w-full rounded-md border-0 px-3 py-1.5 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6 @error('new_password') ring-red-500 @enderror">
                    <button type="button" @click="showNew = !showNew" class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <svg x-show="!showNew" class="h-5 w-5 text-gray-400" ... (Ikon Mata) ...></svg>
                        <svg x-show="showNew" x-cloak class="h-5 w-5 text-gray-400" ... (Ikon Mata Coret) ...></svg>
                    </button>
                </div>
                @error('new_password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Field 3: Konfirmasi Password Baru -->
            <div>
                <label for="new_password_confirmation" class="block text-sm font-medium leading-6 text-gray-900">Konfirmasi Password Baru</label>
                <div class="mt-2 relative">
                    <input :type="showConfirm ? 'text' : 'password'"
                           name="new_password_confirmation" id="new_password_confirmation" required
                           class="block w-full rounded-md border-0 px-3 py-1.5 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6">
                    <button type="button" @click="showConfirm = !showConfirm" class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <svg x-show="!showConfirm" class="h-5 w-5 text-gray-400" ... (Ikon Mata) ...></svg>
                        <svg x-show="showConfirm" x-cloak class="h-5 w-5 text-gray-400" ... (Ikon Mata Coret) ...></svg>
                    </button>
                </div>
            </div>
            
            {{-- Placeholder untuk Ikon SVG Mata --}}
            {{-- 
                Ikon Mata (x-show="!show..."):
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>

                Ikon Mata Coret (x-show="show..."):
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                </svg>
            --}}

        </div>

        <!-- Tombol Aksi -->
        <div class="mt-8 flex items-center justify-end gap-x-6 border-t border-gray-900/10 pt-6">
            <button type="submit"
                    class="rounded-md bg-[#2C5F2D] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#214621] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                Update Password
            </button>
        </div>
    </form>
</div>

{{-- 
  Catatan: Saya telah menyingkat kode SVG Ikon Mata di atas untuk keterbacaan. 
  Silakan salin kode lengkap ikon dari file login.blade.php Anda
  dan tempelkan ke placeholder "Ikon Mata" dan "Ikon Mata Coret".
--}}
@endsection