@extends('layouts.app')

@section('title', 'Ubah Password | SITU Al-Awwabin')
@section('header-title', 'Ubah Password')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6 md:p-8">

    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-[#2C5F2D]">Ubah Password</h2>
            <p class="mt-2 text-sm text-gray-600">
                Ganti password Anda secara berkala untuk menjaga keamanan akun.
            </p>
        </div>
    </div>

    <div class="mt-10 max-w-xl">
        
        {{-- Notifikasi Sukses --}}
        @if(session('success'))
            <div class="rounded-md bg-green-50 p-4 mb-6">
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

        <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
            @csrf

            {{-- 1. Password Saat Ini --}}
            <div>
                <label for="current_password" class="block text-sm font-medium leading-6 text-gray-900">Password Saat Ini</label>
                <div class="mt-2">
                    <input type="password" name="current_password" id="current_password" required
                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6 @error('current_password') ring-red-500 @enderror">
                </div>
                @error('current_password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- 2. Password Baru --}}
            <div>
                <label for="new_password" class="block text-sm font-medium leading-6 text-gray-900">Password Baru</label>
                <div class="mt-2">
                    <input type="password" name="new_password" id="new_password" required
                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6 @error('new_password') ring-red-500 @enderror">
                </div>
                @error('new_password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- 3. Konfirmasi Password Baru --}}
            <div>
                <label for="new_password_confirmation" class="block text-sm font-medium leading-6 text-gray-900">Konfirmasi Password Baru</label>
                <div class="mt-2">
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" required
                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6">
                </div>
            </div>

            {{-- Tombol Simpan --}}
            <div class="flex justify-end">
                <button type="submit"
                        class="rounded-md bg-[#2C5F2D] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#214621] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                    Perbarui Password
                </button>
            </div>
        </form>
    </div>

    {{-- 
    ==================================================================
    BAGIAN INFO DEBUGGING RBAC
    ==================================================================
    --}}
    @auth
        <div class="mt-12 border-t border-gray-300 pt-8">
            <h3 class="text-xl font-semibold text-gray-900">
                Panel Info Debugging (RBAC)
            </h3>
            <p class="mt-1 text-sm text-gray-600">
                Ini adalah peran (Roles) dan izin (Permissions) yang terdeteksi untuk akun Anda.
            </p>
            <div class="mt-4 space-y-4 rounded-lg border border-blue-300 bg-blue-50 p-5">
                
                {{-- 1. Info User --}}
                <div>
                    <h4 class="text-sm font-semibold text-blue-900">Anda Login Sebagai:</h4>
                    <span class="text-md font-medium text-blue-700">{{ Auth::user()->name }}</span>
                    <span class="text-sm text-blue-600">({{ Auth::user()->email }})</span>
                </div>

                {{-- 2. Daftar Peran (Roles) --}}
                <div>
                    <h4 class="text-sm font-semibold text-blue-900">Peran (Roles) Anda:</h4>
                    @if(Auth::user()->getRoleNames()->isEmpty())
                        <span class="text-md font-medium text-red-700 italic">-- Tidak Punya Peran --</span>
                    @else
                        <ul class="list-inside list-disc text-md font-medium text-blue-700">
                            @foreach(Auth::user()->getRoleNames() as $role)
                                <li>{{ $role }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                {{-- 3. Daftar Izin (Permissions) --}}
                <div>
                    <h4 class="text-sm font-semibold text-blue-900">Semua Izin (Permissions) dari Peran:</h4>
                    @if(Auth::user()->getAllPermissions()->isEmpty())
                        <span class="text-md font-medium text-red-700 italic">-- Tidak Punya Izin Apapun --</span>
                    @else
                        <div class="mt-2 flex flex-wrap gap-2 text-xs">
                            @foreach(Auth::user()->getAllPermissions()->pluck('name') as $permission)
                                <span class="rounded-full bg-blue-200 px-3 py-1 font-medium text-blue-800">
                                    {{ $permission }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>
    @endauth
    {{-- ================================================================== --}}

</div>
@endsection