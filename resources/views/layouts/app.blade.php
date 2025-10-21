<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SITU Al-Awwabin')</title> {{-- Judul Tab Browser --}}
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/alawwabin-logo.png') }}">
    @vite('resources/css/app.css')
    @stack('styles')
</head>

<body class="flex flex-col min-h-screen bg-[#F9F9F9]">

    <div class="flex-grow">
        <nav x-data="{ open: false }" class="bg-[#2C5F2D]"> {{-- Warna Navbar Utama --}}
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">

                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <a href="{{ route('home') }}" class="text-white text-xl font-bold">
                                Al-Awwabin
                            </a>
                        </div>

                        {{-- Menu Desktop --}}
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-center space-x-4">
                                @auth
                                    {{-- Dropdown Data Master --}}
                                    <div x-data="{ dropdownOpen: false }" class="relative">
                                        <button @click="dropdownOpen = !dropdownOpen"
                                            class="{{ request()->routeIs('siswa.*', 'guru.*', 'kelas.*', 'mapels.*') ? 'bg-[#C8963E] text-[#333333]' : 'text-gray-100 hover:bg-[#C8963E] hover:text-[#333333]' }} flex items-center rounded-md px-3 py-2 text-sm font-medium">
                                            <svg class="mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.23 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                            </svg>
                                            <span>Data Master</span>
                                        </button>
                                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-transition class="absolute left-0 z-10 mt-2 w-48 origin-top-left rounded-md bg-[#F0E6D2] py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                            <a href="{{ route('siswa.index') }}" class="{{ request()->routeIs('siswa.*') ? 'bg-[#C8963E] text-[#333333]' : 'text-[#333333]' }} block px-4 py-2 text-sm hover:bg-[#C8963E]">Siswa</a>
                                            <a href="{{ route('guru.index') }}" class="{{ request()->routeIs('guru.*') ? 'bg-[#C8963E] text-[#333333]' : 'text-[#333333]' }} block px-4 py-2 text-sm hover:bg-[#C8963E]">Guru</a>
                                            <a href="{{ route('kelas.index') }}" class="{{ request()->routeIs('kelas.*') ? 'bg-[#C8963E] text-[#333333]' : 'text-[#333333]' }} block px-4 py-2 text-sm hover:bg-[#C8963E]">Kelas</a>
                                            <a href="{{ route('mapels.index') }}" class="{{ request()->routeIs('mapels.*') ? 'bg-[#C8963E] text-[#333333]' : 'text-[#333333]' }} block px-4 py-2 text-sm hover:bg-[#C8963E]">Mata Pelajaran</a>
                                        </div>
                                    </div>

                                    {{-- Link Jadwal Guru --}}
                                    <a href="{{ route('jadwal.index') }}"
                                       class="{{ request()->routeIs('jadwal.*') ? 'bg-[#C8963E] text-[#333333]' : 'text-gray-100 hover:bg-[#C8963E] hover:text-[#333333]' }} rounded-md px-3 py-2 text-sm font-medium">
                                       Jadwal Guru
                                    </a>

                                    {{-- 
                                      =========================================================
                                      DROPDOWN KEUANGAN BARU (DESKTOP)
                                      =========================================================
                                    --}}
                                    <div x-data="{ keuanganOpen: false }" class="relative">
                                        <button @click="keuanganOpen = !keuanganOpen"
                                            {{-- Periksa route 'keuangan.*' ATAU 'gaji.*' --}}
                                            class="{{ request()->routeIs(['keuangan.*', 'gaji.*']) ? 'bg-[#C8963E] text-[#333333]' : 'text-gray-100 hover:bg-[#C8963E] hover:text-[#333333]' }} flex items-center rounded-md px-3 py-2 text-sm font-medium">
                                            <svg class="mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.23 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                            </svg>
                                            <span>Keuangan</span>
                                        </button>
                                        <div x-show="keuanganOpen" @click.away="keuanganOpen = false" x-transition class="absolute left-0 z-10 mt-2 w-48 origin-top-left rounded-md bg-[#F0E6D2] py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                            {{-- Asumsi route operasional adalah 'keuangan.index' --}}
                                            <a href="{{ route('keuangan.index') }}" class="{{ request()->routeIs('keuangan.*') ? 'bg-[#C8963E] text-[#333333]' : 'text-[#333333]' }} block px-4 py-2 text-sm hover:bg-[#C8963E]">Operasional</a>
                                            <a href="{{ route('gaji.index') }}" class="{{ request()->routeIs('gaji.*') ? 'bg-[#C8963E] text-[#333333]' : 'text-[#333333]' }} block px-4 py-2 text-sm hover:bg-[#C8963E]">Gaji Guru</a>
                                        </div>
                                    </div>
                                    {{-- Link Keuangan & Gaji Guru yang lama dihapus --}}

                                @endauth
                            </div>
                        </div>
                    </div>

                    {{-- Bagian Kanan Navbar (Login/Logout) --}}
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            @auth
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="text-gray-100 hover:bg-[#C8963E] hover:text-[#333333] rounded-md px-3 py-2 text-sm font-medium">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                            @else
                                <a href="{{ route('login') }}"
                                    class="text-gray-100 hover:bg-[#C8963E] hover:text-[#333333] rounded-md px-3 py-2 text-sm font-medium">
                                    Login
                                </a>
                            @endauth
                        </div>
                    </div>

                    {{-- Tombol Hamburger Menu Mobile --}}
                    <div class="-mr-2 flex md:hidden">
                        <button @click="open = !open" type="button" class="inline-flex items-center justify-center rounded-md bg-[#2C5F2D] p-2 text-gray-100 hover:bg-[#C8963E] hover:text-[#333333] focus:outline-none" aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg :class="{ 'hidden': open, 'block': !open }" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                            <svg :class="{ 'block': open, 'hidden': !open }" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Menu Mobile --}}
            <div x-show="open" class="md:hidden" id="mobile-menu">
                <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
                    @auth
                        {{-- Accordion Data Master --}}
                        <div x-data="{ subMenuOpen: false }">
                            <button @click="subMenuOpen = !subMenuOpen" class="{{ request()->routeIs('siswa.*', 'guru.*', 'kelas.*', 'mapels.*') ? 'bg-[#C8963E] text-[#333333]' : 'text-gray-100 hover:bg-[#C8963E] hover:text-[#333333]' }} w-full flex items-center justify-between rounded-md px-3 py-2 text-base font-medium">
                                <span>Data Master</span>
                                <svg :class="{ 'rotate-180': subMenuOpen }" class="h-5 w-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.23 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" /></svg>
                            </button>
                            <div x-show="subMenuOpen" x-transition class="space-y-1 pl-4 pt-2 bg-[#F0E6D2] rounded-md">
                                <a href="{{ route('siswa.index') }}" class="{{ request()->routeIs('siswa.*') ? 'bg-[#C8963E] text-[#333333]' : 'text-[#333333]' }} block rounded-md px-3 py-2 text-base font-medium hover:bg-[#C8963E]">Siswa</a>
                                <a href="{{ route('guru.index') }}" class="{{ request()->routeIs('guru.*') ? 'bg-[#C8963E] text-[#333333]' : 'text-[#333333]' }} block rounded-md px-3 py-2 text-base font-medium hover:bg-[#C8963E]">Guru</a>
                                <a href="{{ route('kelas.index') }}" class="{{ request()->routeIs('kelas.*') ? 'bg-[#C8963E] text-[#333333]' : 'text-[#333333]' }} block rounded-md px-3 py-2 text-base font-medium hover:bg-[#C8963E]">Kelas</a>
                                <a href="{{ route('mapels.index') }}" class="{{ request()->routeIs('mapels.*') ? 'bg-[#C8963E] text-[#333333]' : 'text-[#333333]' }} block rounded-md px-3 py-2 text-base font-medium hover:bg-[#C8963E]">Mata Pelajaran</a>
                            </div>
                        </div>

                        {{-- Link Jadwal Guru --}}
                        <a href="{{ route('jadwal.index') }}"
                           class="{{ request()->routeIs('jadwal.*') ? 'bg-[#C8963E] text-[#333333]' : 'text-gray-100 hover:bg-[#C8963E] hover:text-[#333333]' }} block rounded-md px-3 py-2 text-base font-medium">
                           Jadwal Guru
                        </a>

                        {{-- 
                          =========================================================
                          DROPDOWN KEUANGAN BARU (MOBILE - ACCORDION)
                          =========================================================
                        --}}
                        <div x-data="{ subKeuanganOpen: false }">
                            <button @click="subKeuanganOpen = !subKeuanganOpen"
                                {{-- Periksa route 'keuangan.*' ATAU 'gaji.*' --}}
                                class="{{ request()->routeIs(['keuangan.*', 'gaji.*']) ? 'bg-[#C8963E] text-[#333333]' : 'text-gray-100 hover:bg-[#C8963E] hover:text-[#333333]' }} w-full flex items-center justify-between rounded-md px-3 py-2 text-base font-medium">
                                <span>Keuangan</span>
                                <svg :class="{ 'rotate-180': subKeuanganOpen }" class="h-5 w-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.23 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" /></svg>
                            </button>
                            <div x-show="subKeuanganOpen" x-transition class="space-y-1 pl-4 pt-2 bg-[#F0E6D2] rounded-md">
                                <a href="{{ route('keuangan.index') }}" class="{{ request()->routeIs('keuangan.*') ? 'bg-[#C8963E] text-[#333333]' : 'text-[#333333]' }} block rounded-md px-3 py-2 text-base font-medium hover:bg-[#C8963E]">Operasional</a>
                                <a href="{{ route('gaji.index') }}" class="{{ request()->routeIs('gaji.*') ? 'bg-[#C8963E] text-[#333333]' : 'text-[#333333]' }} block rounded-md px-3 py-2 text-base font-medium hover:bg-[#C8963E]">Gaji Guru</a>
                            </div>
                        </div>
                         {{-- Link Keuangan & Gaji Guru yang lama dihapus --}}
                         
                    @endauth
                </div>
                {{-- Bagian Logout/Login Mobile --}}
                <div class="border-t border-[#C8963E] pt-4 pb-3">
                    <div class="space-y-1 px-2">
                        @auth
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();"
                                class="block rounded-md px-3 py-2 text-base font-medium text-gray-100 hover:bg-[#C8963E] hover:text-[#333333]">
                                Logout
                            </a>
                            <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                        @else
                            <a href="{{ route('login') }}"
                                class="block rounded-md px-3 py-2 text-base font-medium text-gray-100 hover:bg-[#C8963E] hover:text-[#333333]">
                                Login
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        {{-- Sisa file (Header dan Main Content) --}}
        <header class="py-10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            </div>
        </header>

        <main class="-mt-10">
            <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
                <div class="rounded-lg bg-white px-5 py-6 shadow sm:px-6">
                    <div class="rounded-lg border border-gray-200 p-6"
                        style="background-image: repeating-linear-gradient( -45deg, hsla(121, 39%, 27%, 0.03), hsla(121, 39%, 27%, 0.03) 1px, transparent 1px, transparent 8px );">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>

    {{-- Footer --}}
    <footer class="bg-[#F0E6D2] shadow-inner mt-12">
        <div class="mx-auto max-w-7xl py-6 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm text-[#333333]">
                &copy; {{ date('Y') }} Sistem Informasi Tata Usaha (SITU) Pesantren Al-Awwabin.
            </p>
        </div>
    </footer>
    <script src="//unpkg.com/alpinejs" defer></script>
    @stack('scripts')
</body>
</html>