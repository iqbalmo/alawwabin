<!DOCTYPE html>
{{-- 
    *
    * Palet Tema "Harmoni Klasik"
    * Hijau Utama   : #2C5F2D (Sidebar, Aksen Teks)
    * Aksen Emas    : #C8963E (Link Aktif, Tombol Utama)
    * Latar Body    : #F9F9F9 (Latar belakang utama halaman)
    * Latar Konten  : #FFFFFF (Kotak putih di dalam main)
    * Krem Sekunder : #F0E6D2 (Latar header tabel, dropdown)
    * Teks Utama    : #333333 (Teks gelap)
    * Teks Sekunder : #6b7280 (Abu-abu)
    *
--}}
<html lang="en" class="h-full bg-[#F9F9F9]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SITU Al-Awwabin')</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/alawwabin-logo.png') }}">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css' rel='stylesheet' />
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    {{-- Alpine.js untuk dropdown & mobile menu --}}
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="h-full">
    {{-- Loading Bar: Muncul saat Livewire sedang memproses request --}}
    <div wire:loading.delay.longest
        class="fixed top-0 left-0 right-0 h-1 bg-green-500 z-[10001]"
        style="background-image: linear-gradient(to right, #C8963E, #2C5F2D); animation: indeterminateAnimation 1s infinite linear;">
        <style>
            @keyframes indeterminateAnimation { 0% { transform: translateX(-100%) scaleX(0.5); } 100% { transform: translateX(100%) scaleX(0.5); } }
            .livewire-progress { animation: indeterminateAnimation 1s infinite linear; }
        </style>
    </div>
    
    {{-- Offline Indicator: Muncul saat koneksi terputus --}}
    <div wire:offline class="fixed top-0 left-0 right-0 p-2 text-center bg-red-600 text-white z-[10000]">
        Anda sedang offline. Koneksi terputus.
    </div>

    <div x-data="{ sidebarOpen: false }" class="relative h-full">
        
        {{-- 1. Mobile Sidebar --}}
        <div x-show="sidebarOpen" class="relative z-50 lg:hidden" x-cloak x-ref="dialog" aria-modal="true">
            <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900/80"></div>

            <div class="fixed inset-0 flex">
                <div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform"
                     x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                     x-transition:leave="transition ease-in-out duration-300 transform"
                     x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                     class="relative mr-16 flex w-full max-w-xs flex-1"
                     @click.away="sidebarOpen = false">
                    
                    <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                        <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
                            <span class="sr-only">Tutup sidebar</span>
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- [PERUBAHAN 1]: Sidebar Mobile --}}
                    <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-[#2C5F2D] px-6 pb-4">
                        <div class="flex h-16 shrink-0 items-center">
                            <img class="h-10 w-auto" src="{{ asset('img/alawwabin-logo.png') }}" alt="SITU Al-Awwabin">
                            <span class="ml-3 text-white font-semibold">SITU Al-Awwabin</span>
                        </div>

                        {{-- ================================================================== --}}
                        {{-- PERBAIKAN DIMULAI DI SINI (BLOK LOGIKA 1) --}}
                        {{-- Logika @if/@elseif dihapus, semua user memuat 'navigation' --}}
                        {{-- ================================================================== --}}
                        @auth
                            @include('layouts.partials.navigation')
                        @endauth
                        {{-- ================================================================== --}}

                    </div>
                </div>
            </div>
        </div>

        {{-- 2. Sidebar Desktop --}}
        <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-64 lg:flex-col">
            <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-[#2C5F2D] px-6 pb-4">
                <div class="flex h-16 shrink-0 items-center">
                    <img class="h-10 w-auto" src="{{ asset('img/alawwabin-logo.png') }}" alt="SITU Al-Awwabin">
                    <span class="ml-3 text-white font-semibold">SITU Al-Awwabin</span>
                </div>

                {{-- [PERUBAHAN 2]: Sidebar Desktop --}}
                {{-- ================================================================== --}}
                {{-- PERBAIKAN DIMULAI DI SINI (BLOK LOGIKA 2) --}}
                {{-- ================================================================== --}}
                @auth
                    @include('layouts.partials.navigation')
                @endauth
                {{-- ================================================================== --}}
                
            </div>
        </div>

        {{-- 3. Main Layout --}}
        <div class="lg:pl-64 flex flex-col h-full">
            {{-- Header / Topbar --}}
            <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-yellow-900/10 bg-gray-50 px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8"
                 style="background-image: repeating-linear-gradient( -45deg, hsla(42, 57%, 51%, 0.05), hsla(42, 57%, 51%, 0.05) 1px, transparent 1px, transparent 8px );">
                <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden" @click="sidebarOpen = true">
                    <span class="sr-only">Buka sidebar</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                         aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                <nav class="flex flex-1" aria-label="Breadcrumb">
                        <ol role="list" class="flex items-center space-x-2 text-sm font-semibold">
                            
                            @section('breadcrumbs')
                                <li>
                                    <span class="text-gray-900">Sistem Informasi Terpadu Al-Awwabin</span>
                                </li>
                            @show

                        </ol>
                    </nav>

                {{-- Menu kanan (notifikasi + profil) --}}
                <div class="flex items-center gap-x-4 lg:gap-x-6">
                    <button type="button" class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Lihat notifikasi</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                    </button>

                    {{-- Dropdown User --}}
                    @auth {{-- Pastikan user login sebelum menampilkan ini --}}
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="-m-1.5 flex items-center p-1.5">
                            <img class="h-8 w-8 rounded-full bg-gray-50"
                                 src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'U') }}&background=C8963E&color=333333"
                                 alt="">
                            <span class="hidden lg:flex lg:items-center">
                                <span class="ml-4 text-sm font-semibold leading-6 text-gray-900"
                                      aria-hidden="true">{{ Auth::user()->name ?? 'User' }}</span>
                                <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.23 8.27a.75.75 0 01.02-1.06z"
                                          clip-rule="evenodd" />
                                </svg>
                            </span>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition
                             class="absolute right-0 z-10 mt-2.5 w-48 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none"
                             x-cloak>
                            <a href="{{ route('password.edit') }}" class="block px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50">
                                 Ubah Password
                             </a>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="block px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    </div>
                    @endauth
                </div>
            </div>

            {{-- 4. Konten Halaman --}}
            <main class="py-10 flex-grow">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    {{-- Notifikasi Sukses --}}
                    @if(session('success'))
                        <div class="rounded-md bg-green-50 p-4 mb-6 border border-green-200">
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

                    <div class="rounded-lg bg-white px-5 py-6 shadow sm:px-6">
                        <div class="rounded-lg border border-gray-200 p-6"
                             style="background-image: repeating-linear-gradient(-45deg, hsla(121, 39%, 27%, 0.03), hsla(121, 39%, 27%, 0.03) 1px, transparent 1px, transparent 8px );">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </main>

            {{-- 5. Footer --}}
            <footer class="shrink-0 border-t border-gray-200 bg-[#F0E6D2]">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <p class="text-center text-sm leading-5 text-gray-500">
                        &copy; {{ date('Y') }} SITU Al-Awwabin. Hak Cipta Dilindungi.
                    </D>
                </div>
            </footer>
        </div>
    </div>

    @stack('scripts')
    @livewireScripts
</body>
</html>