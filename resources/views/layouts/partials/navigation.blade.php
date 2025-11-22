<nav class="flex flex-1 flex-col">
    <ul role="list" class="flex flex-1 flex-col gap-y-3">
        <li>
            <ul role="list" class="-mx-2 space-y-1">
                {{-- 1. DASBOR --}}
                <li>
                    @role('admin')
                        <a href="{{ route('home') }}"
                            class="{{ request()->routeIs('home') 
                                ? 'bg-[#C8963E] text-white shadow-md' 
                                : 'text-gray-100 hover:text-white hover:bg-[#3a7a3b]' }} 
                                group flex gap-x-3 rounded-lg p-2.5 text-sm leading-6 font-semibold transition-all duration-200">
                            <svg class="h-6 w-6 shrink-0 {{ request()->routeIs('home') ? 'text-white' : 'text-[#F0E6D2] group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            Dasbor
                        </a>
                    @else
                        <a href="{{ route('gurulog.index') }}"
                            class="{{ request()->routeIs('gurulog.*') 
                                ? 'bg-[#C8963E] text-white shadow-md' 
                                : 'text-gray-100 hover:text-white hover:bg-[#3a7a3b]' }} 
                                group flex gap-x-3 rounded-lg p-2.5 text-sm leading-6 font-semibold transition-all duration-200">
                            <svg class="h-6 w-6 shrink-0 {{ request()->routeIs('gurulog.*') ? 'text-white' : 'text-[#F0E6D2] group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            Dasbor
                        </a>
                    @endrole
                </li>
            </ul>
        </li>

        <li>
            @canany(['manage siswa', 'manage guru', 'manage kelas', 'manage mapel', 'manage ekskul'])
                <div class="text-xs font-bold leading-6 text-[#C8963E] tracking-wider uppercase mb-2">Data Sekolah</div>
            @endcanany

            <ul role="list" class="-mx-2 space-y-1">
                {{-- 2. DATA SISWA --}}
                @can('manage siswa')
                    <li x-data="{ open: {{ request()->routeIs('siswa.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open"
                            class="{{ request()->routeIs('siswa.*') 
                                ? 'bg-[#3a7a3b] text-white' 
                                : 'text-gray-100 hover:text-white hover:bg-[#3a7a3b]' }} 
                                group flex w-full items-center gap-x-3 rounded-lg p-2.5 text-sm leading-6 font-semibold transition-all duration-200">
                            <svg class="h-6 w-6 shrink-0 {{ request()->routeIs('siswa.*') ? 'text-[#C8963E]' : 'text-[#F0E6D2] group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.697 50.697 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                            </svg>
                            Data Siswa
                            <svg class="ml-auto h-5 w-5 shrink-0 transform transition-transform duration-200"
                                :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <ul x-show="open" x-collapse x-cloak class="mt-1 space-y-1">
                            <li>
                                <a href="{{ route('siswa.index') }}" wire:navigate
                                    class="{{ request()->routeIs('siswa.index', 'siswa.create', 'siswa.edit', 'siswa.show') 
                                        ? 'bg-[#C8963E] text-white shadow-sm' 
                                        : 'text-gray-300 hover:text-white hover:bg-[#3a7a3b]' }} 
                                        block rounded-lg py-2 pr-2 pl-11 text-sm leading-6 transition-all duration-200">
                                    Daftar Siswa
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('siswa.archive') }}" wire:navigate
                                    class="{{ request()->routeIs('siswa.archive') 
                                        ? 'bg-[#C8963E] text-white shadow-sm' 
                                        : 'text-gray-300 hover:text-white hover:bg-[#3a7a3b]' }} 
                                        block rounded-lg py-2 pr-2 pl-11 text-sm leading-6 transition-all duration-200">
                                    Arsip Lulusan
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('siswa.import') }}" wire:navigate
                                    class="{{ request()->routeIs('siswa.import') 
                                        ? 'bg-[#C8963E] text-white shadow-sm' 
                                        : 'text-gray-300 hover:text-white hover:bg-[#3a7a3b]' }} 
                                        block rounded-lg py-2 pr-2 pl-11 text-sm leading-6 transition-all duration-200">
                                    Import Excel
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                {{-- 3. DATA GURU --}}
                @can('manage guru')
                    <li>
                        <a href="{{ route('guru.index') }}" wire:navigate
                            class="{{ request()->routeIs('guru.*') 
                                ? 'bg-[#C8963E] text-white shadow-md' 
                                : 'text-gray-100 hover:text-white hover:bg-[#3a7a3b]' }} 
                                group flex gap-x-3 rounded-lg p-2.5 text-sm leading-6 font-semibold transition-all duration-200">
                            <svg class="h-6 w-6 shrink-0 {{ request()->routeIs('guru.*') ? 'text-white' : 'text-[#F0E6D2] group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            Data Guru
                        </a>
                    </li>
                @endcan

                {{-- 4. MANAJEMEN KELAS --}}
                @can('manage kelas')
                    <li x-data="{ open: {{ request()->routeIs('kelas.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open"
                            class="{{ request()->routeIs('kelas.*') 
                                ? 'bg-[#3a7a3b] text-white' 
                                : 'text-gray-100 hover:text-white hover:bg-[#3a7a3b]' }} 
                                group flex w-full items-center gap-x-3 rounded-lg p-2.5 text-sm leading-6 font-semibold transition-all duration-200">
                            <svg class="h-6 w-6 shrink-0 {{ request()->routeIs('kelas.*') ? 'text-[#C8963E]' : 'text-[#F0E6D2] group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                            </svg>
                            Manajemen Kelas
                            <svg class="ml-auto h-5 w-5 shrink-0 transform transition-transform duration-200"
                                :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <ul x-show="open" x-collapse x-cloak class="mt-1 space-y-1">
                            <li>
                                <a href="{{ route('kelas.index') }}" wire:navigate
                                    class="{{ request()->routeIs('kelas.index', 'kelas.create', 'kelas.edit', 'kelas.show') 
                                        ? 'bg-[#C8963E] text-white shadow-sm' 
                                        : 'text-gray-300 hover:text-white hover:bg-[#3a7a3b]' }} 
                                        block rounded-lg py-2 pr-2 pl-11 text-sm leading-6 transition-all duration-200">
                                    Daftar Kelas
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('kelas.promotionTool') }}" wire:navigate
                                    class="{{ request()->routeIs('kelas.promotionTool', 'kelas.showPromotionForm') 
                                        ? 'bg-[#C8963E] text-white shadow-sm' 
                                        : 'text-gray-300 hover:text-white hover:bg-[#3a7a3b]' }} 
                                        block rounded-lg py-2 pr-2 pl-11 text-sm leading-6 transition-all duration-200">
                                    Kenaikan Kelas
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('absensi.rekap.index') }}" wire:navigate
                                    class="{{ request()->routeIs('absensi.rekap.*') 
                                        ? 'bg-[#C8963E] text-white shadow-sm' 
                                        : 'text-gray-300 hover:text-white hover:bg-[#3a7a3b]' }} 
                                        block rounded-lg py-2 pr-2 pl-11 text-sm leading-6 transition-all duration-200">
                                    Rekap Absensi
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                {{-- 5. DATA MAPEL --}}
                @can('manage mapel')
                    <li>
                        <a href="{{ route('mapels.index') }}" wire:navigate
                            class="{{ request()->routeIs('mapels.*') 
                                ? 'bg-[#C8963E] text-white shadow-md' 
                                : 'text-gray-100 hover:text-white hover:bg-[#3a7a3b]' }} 
                                group flex gap-x-3 rounded-lg p-2.5 text-sm leading-6 font-semibold transition-all duration-200">
                            <svg class="h-6 w-6 shrink-0 {{ request()->routeIs('mapels.*') ? 'text-white' : 'text-[#F0E6D2] group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18c-2.305 0-4.408.867-6 2.292m0-14.25v14.25" />
                            </svg>
                            Data Mata Pelajaran
                        </a>
                    </li>
                @endcan

                {{-- 6. EKSKUL --}}
                @can('manage ekskul')
                    <li>
                        <a href="{{ route('ekskul.index') }}" wire:navigate
                            class="{{ request()->routeIs('ekskul.*') 
                                ? 'bg-[#C8963E] text-white shadow-md' 
                                : 'text-gray-100 hover:text-white hover:bg-[#3a7a3b]' }} 
                                group flex gap-x-3 rounded-lg p-2.5 text-sm leading-6 font-semibold transition-all duration-200">
                            <svg class="h-6 w-6 shrink-0 {{ request()->routeIs('ekskul.*') ? 'text-white' : 'text-[#F0E6D2] group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                            Ekstrakurikuler
                        </a>
                    </li>
                @endcan
            </ul>
        </li>

        <li>
            @canany(['view jadwal', 'manage absensi', 'manage nilai'])
                <div class="text-xs font-bold leading-6 text-[#C8963E] tracking-wider uppercase mb-2">Data Akademik</div>
            @endcanany

            <ul role="list" class="-mx-2 space-y-1">
                {{-- 7. DATA JADWAL --}}
                @can('view jadwal')
                    <li>
                        <a href="{{ route('jadwal.index') }}" wire:navigate
                            class="{{ request()->routeIs('jadwal.*') 
                                ? 'bg-[#C8963E] text-white shadow-md' 
                                : 'text-gray-100 hover:text-white hover:bg-[#3a7a3b]' }} 
                                group flex gap-x-3 rounded-lg p-2.5 text-sm leading-6 font-semibold transition-all duration-200">
                            <svg class="h-6 w-6 shrink-0 {{ request()->routeIs('jadwal.*') ? 'text-white' : 'text-[#F0E6D2] group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-18 0h18" />
                            </svg>
                            Data Jadwal
                        </a>
                    </li>
                @endcan

                @can('view agenda')
                <li>
                    <a href="{{ route('agenda.index') }}" wire:navigate
                       class="{{ request()->routeIs('agenda.*') 
                           ? 'bg-[#C8963E] text-white shadow-md' 
                           : 'text-gray-100 hover:text-white hover:bg-[#3a7a3b]' }} 
                           group flex gap-x-3 rounded-lg p-2.5 text-sm leading-6 font-semibold transition-all duration-200">
                        <svg class="h-6 w-6 shrink-0 {{ request()->routeIs('agenda.*') ? 'text-white' : 'text-[#F0E6D2] group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                        Agenda Mengajar
                    </a>
                </li>
                @endcan

                {{-- Tahun Ajaran --}}
                @can('manage siswa')
                <li>
                    <a href="{{ route('tahun-ajaran.index') }}" wire:navigate
                       class="{{ request()->routeIs('tahun-ajaran.*') 
                           ? 'bg-[#C8963E] text-white shadow-md' 
                           : 'text-gray-100 hover:text-white hover:bg-[#3a7a3b]' }} 
                           group flex gap-x-3 rounded-lg p-2.5 text-sm leading-6 font-semibold transition-all duration-200">
                        <svg class="h-6 w-6 shrink-0 {{ request()->routeIs('tahun-ajaran.*') ? 'text-white' : 'text-[#F0E6D2] group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        Tahun Ajaran
                    </a>
                </li>
                @endcan
            </ul>
        </li>
    </ul>
</nav>
