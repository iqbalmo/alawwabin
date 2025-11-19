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
<html lang="id" class="h-full bg-[#F9F9F9]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SITU Al-Awwabin')</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/alawwabin-logo.png') }}">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css' rel='stylesheet' />
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="h-full">
    {{-- Loading Bar --}}
    <div wire:loading.delay.longest
        class="fixed top-0 left-0 right-0 h-1 bg-gradient-to-r from-[#C8963E] to-[#2C5F2D] z-[10001]"
        style="animation: indeterminateAnimation 1s infinite linear;">
        <style>
            @keyframes indeterminateAnimation { 
                0% { transform: translateX(-100%) scaleX(0.5); } 
                100% { transform: translateX(100%) scaleX(0.5); } 
            }
        </style>
    </div>
    
    {{-- Offline Indicator --}}
    <div wire:offline class="fixed top-0 left-0 right-0 p-3 text-center bg-red-600 text-white text-sm font-medium z-[10000] shadow-lg">
        <svg class="inline-block w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 010 12.728m0 0l-2.829-2.829m2.829 2.829L21 21M15.536 8.464a5 5 0 010 7.072m0 0l-2.829-2.829m-4.243 2.829a4.978 4.978 0 01-1.414-2.83m-1.414 5.658a9 9 0 01-2.167-9.238m7.824 2.167a1 1 0 111.414 1.414m-1.414-1.414L3 3m8.293 8.293l1.414 1.414" />
        </svg>
        Koneksi terputus. Beberapa fitur mungkin tidak berfungsi.
    </div>

    <div x-data="{ sidebarOpen: false }" class="relative h-full">
        
        {{-- Mobile Sidebar --}}
        <div x-show="sidebarOpen" class="relative z-50 lg:hidden" x-cloak x-ref="dialog" aria-modal="true">
            <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm"></div>

            <div class="fixed inset-0 flex">
                <div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform"
                     x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                     x-transition:leave="transition ease-in-out duration-300 transform"
                     x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                     class="relative mr-16 flex w-full max-w-xs flex-1"
                     @click.away="sidebarOpen = false">
                    
                    <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                        <button type="button" class="-m-2.5 p-2.5 hover:bg-white/10 rounded-full transition-colors" @click="sidebarOpen = false">
                            <span class="sr-only">Tutup sidebar</span>
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-[#2C5F2D] px-6 pb-4">
                        <div class="flex h-16 shrink-0 items-center gap-3">
                            <img class="h-10 w-auto" src="{{ asset('img/alawwabin-logo.png') }}" alt="SITU Al-Awwabin">
                            <span class="text-white font-semibold text-lg">SITU Al-Awwabin</span>
                        </div>

                        @auth
                            @include('layouts.partials.navigation')
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        {{-- Desktop Sidebar --}}
        <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-64 lg:flex-col">
            <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-[#2C5F2D] px-6 pb-4 shadow-xl">
                <div class="flex h-16 shrink-0 items-center gap-3">
                    <img class="h-10 w-auto" src="{{ asset('img/alawwabin-logo.png') }}" alt="SITU Al-Awwabin">
                    <span class="text-white font-semibold text-lg">SITU Al-Awwabin</span>
                </div>

                @auth
                    @include('layouts.partials.navigation')
                @endauth
            </div>
        </div>

        {{-- Main Layout --}}
        <div class="lg:pl-64 flex flex-col h-full">
            {{-- Header / Topbar --}}
            <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
                <button type="button" class="-m-2.5 p-2.5 text-gray-700 hover:text-[#2C5F2D] lg:hidden transition-colors" @click="sidebarOpen = true">
                    <span class="sr-only">Buka sidebar</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                {{-- Breadcrumb --}}
                <nav class="flex flex-1" aria-label="Breadcrumb">
                    <ol role="list" class="flex items-center space-x-2 text-sm">
                        @section('breadcrumbs')
                            <li>
                                <span class="text-gray-600 font-medium">Sistem Informasi Terpadu Al-Awwabin</span>
                            </li>
                        @show
                    </ol>
                </nav>

                {{-- Right Menu --}}
                <div class="flex items-center gap-x-4 lg:gap-x-6">
                    {{-- Notification Button --}}
                    <button type="button" class="-m-2.5 p-2.5 text-gray-400 hover:text-[#2C5F2D] transition-colors relative">
                        <span class="sr-only">Lihat notifikasi</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                    </button>

                    {{-- User Dropdown --}}
                    @auth
                    <div class="h-6 w-px bg-gray-200 hidden lg:block"></div>
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="-m-1.5 flex items-center p-1.5 hover:bg-gray-50 rounded-lg transition-colors">
                            <img class="h-8 w-8 rounded-full bg-gray-50 ring-2 ring-white"
                                 src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'U') }}&background=C8963E&color=333333"
                                 alt="">
                            <span class="hidden lg:flex lg:items-center">
                                <span class="ml-3 text-sm font-semibold leading-6 text-gray-900">{{ Auth::user()->name ?? 'User' }}</span>
                                <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.23 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition
                             class="absolute right-0 z-10 mt-2.5 w-56 origin-top-right rounded-xl bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none"
                             x-cloak>
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="{{ route('password.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                                Ubah Password
                            </a>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
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

            {{-- Main Content --}}
            <main class="py-8 flex-grow">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    {{-- Success Notification --}}
                    @if(session('success'))
                        <div class="rounded-xl bg-green-50 p-4 mb-6 border border-green-200 shadow-sm" x-data="{ show: true }" x-show="show" x-transition>
                            <div class="flex items-start gap-3">
                                <svg class="h-5 w-5 text-green-600 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <p class="text-sm font-medium text-green-800 flex-1">{{ session('success') }}</p>
                                <button @click="show = false" class="text-green-600 hover:text-green-800 transition-colors">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif

                    {{-- Error Notification --}}
                    @if(session('error'))
                        <div class="rounded-xl bg-red-50 p-4 mb-6 border border-red-200 shadow-sm" x-data="{ show: true }" x-show="show" x-transition>
                            <div class="flex items-start gap-3">
                                <svg class="h-5 w-5 text-red-600 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                                <p class="text-sm font-medium text-red-800 flex-1">{{ session('error') }}</p>
                                <button @click="show = false" class="text-red-600 hover:text-red-800 transition-colors">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif

                    {{-- Page Content --}}
                    @yield('content')
                </div>
            </main>

            {{-- Footer --}}
            <footer class="shrink-0 border-t border-gray-200 bg-white">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <p class="text-sm text-gray-500">
                            &copy; {{ date('Y') }} <span class="font-semibold text-[#2C5F2D]">SITU Al-Awwabin</span>. Hak Cipta Dilindungi.
                        </p>
                        <div class="flex items-center gap-4 text-xs text-gray-400">
                            <span>MTs Al-Awwabin</span>
                            <span>•</span>
                            <span>v1.0.0</span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    @stack('scripts')
    @livewireScripts
</body>
</html>