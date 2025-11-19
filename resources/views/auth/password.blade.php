@extends('layouts.app')

@section('title', 'Ubah Password | SITU Al-Awwabin')

@section('content')
<div class="max-w-2xl mx-auto">
    
    {{-- Header --}}
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('home') }}" class="text-gray-400 hover:text-[#2C5F2D] transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" />
                </svg>
            </a>
            <h2 class="text-2xl font-bold text-[#2C5F2D]">Ubah Password</h2>
        </div>
        <p class="ml-8 text-sm text-gray-600">
            Ganti password Anda secara berkala untuk menjaga keamanan akun.
        </p>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('password.update') }}" method="POST" class="space-y-6" x-data="{ 
            showCurrent: false, 
            showNew: false, 
            showConfirm: false,
            strength: 0,
            checkStrength() {
                const password = document.getElementById('new_password').value;
                let strength = 0;
                if (password.length >= 8) strength++;
                if (password.match(/[a-z]/)) strength++;
                if (password.match(/[A-Z]/)) strength++;
                if (password.match(/[0-9]/)) strength++;
                if (password.match(/[^a-zA-Z0-9]/)) strength++;
                this.strength = strength;
            }
        }">
            @csrf

            {{-- Current Password --}}
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password Saat Ini <span class="text-red-600">*</span>
                </label>
                <div class="relative">
                    <input :type="showCurrent ? 'text' : 'password'" 
                           name="current_password" 
                           id="current_password" 
                           required
                           class="block w-full px-3 py-2.5 pr-10 bg-white border border-gray-300 rounded-lg text-gray-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#2C5F2D] focus:border-transparent sm:text-sm @error('current_password') ring-2 ring-red-500 @enderror">
                    <button type="button" 
                            @click="showCurrent = !showCurrent"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                        <svg x-show="!showCurrent" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="showCurrent" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
                @error('current_password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- New Password --}}
            <div>
                <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password Baru <span class="text-red-600">*</span>
                </label>
                <div class="relative">
                    <input :type="showNew ? 'text' : 'password'" 
                           name="new_password" 
                           id="new_password" 
                           required
                           @input="checkStrength()"
                           class="block w-full px-3 py-2.5 pr-10 bg-white border border-gray-300 rounded-lg text-gray-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#2C5F2D] focus:border-transparent sm:text-sm @error('new_password') ring-2 ring-red-500 @enderror">
                    <button type="button" 
                            @click="showNew = !showNew"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                        <svg x-show="!showNew" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="showNew" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
                
                {{-- Password Strength Indicator --}}
                <div class="mt-2">
                    <div class="flex gap-1">
                        <div class="h-1 flex-1 rounded-full transition-colors" :class="strength >= 1 ? (strength <= 2 ? 'bg-red-500' : strength <= 3 ? 'bg-yellow-500' : 'bg-green-500') : 'bg-gray-200'"></div>
                        <div class="h-1 flex-1 rounded-full transition-colors" :class="strength >= 2 ? (strength <= 2 ? 'bg-red-500' : strength <= 3 ? 'bg-yellow-500' : 'bg-green-500') : 'bg-gray-200'"></div>
                        <div class="h-1 flex-1 rounded-full transition-colors" :class="strength >= 3 ? (strength <= 3 ? 'bg-yellow-500' : 'bg-green-500') : 'bg-gray-200'"></div>
                        <div class="h-1 flex-1 rounded-full transition-colors" :class="strength >= 4 ? 'bg-green-500' : 'bg-gray-200'"></div>
                        <div class="h-1 flex-1 rounded-full transition-colors" :class="strength >= 5 ? 'bg-green-500' : 'bg-gray-200'"></div>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">
                        <span x-show="strength === 0">Masukkan password baru</span>
                        <span x-show="strength === 1 || strength === 2" class="text-red-600">Password lemah</span>
                        <span x-show="strength === 3" class="text-yellow-600">Password sedang</span>
                        <span x-show="strength === 4" class="text-green-600">Password kuat</span>
                        <span x-show="strength === 5" class="text-green-600">Password sangat kuat</span>
                    </p>
                </div>
                
                @error('new_password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                
                <p class="mt-2 text-xs text-gray-500">
                    Password harus minimal 8 karakter dan mengandung huruf besar, huruf kecil, angka, dan simbol.
                </p>
            </div>

            {{-- Confirm New Password --}}
            <div>
                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Konfirmasi Password Baru <span class="text-red-600">*</span>
                </label>
                <div class="relative">
                    <input :type="showConfirm ? 'text' : 'password'" 
                           name="new_password_confirmation" 
                           id="new_password_confirmation" 
                           required
                           class="block w-full px-3 py-2.5 pr-10 bg-white border border-gray-300 rounded-lg text-gray-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#2C5F2D] focus:border-transparent sm:text-sm">
                    <button type="button" 
                            @click="showConfirm = !showConfirm"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                        <svg x-show="!showConfirm" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="showConfirm" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Security Tips --}}
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex gap-3">
                    <svg class="h-5 w-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-sm text-blue-800">
                        <p class="font-medium mb-1">Tips Keamanan Password:</p>
                        <ul class="list-disc list-inside space-y-1 text-xs">
                            <li>Gunakan kombinasi huruf besar, kecil, angka, dan simbol</li>
                            <li>Jangan gunakan informasi pribadi yang mudah ditebak</li>
                            <li>Hindari menggunakan password yang sama di berbagai akun</li>
                            <li>Ganti password secara berkala (minimal 3 bulan sekali)</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-[#2C5F2D] px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#214621] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 transition-all">
                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Perbarui Password
                </button>
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-all">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection