<nav class="flex flex-1 flex-col">
    <ul role="list" class="flex flex-1 flex-col gap-y-7">
        <li>
            <ul role="list" class="-mx-2 space-y-1">
                {{-- 1. DASBOR --}}
                <li>
                    <a href="{{ route('home') }}" 
                       class="{{ request()->routeIs('home') ? 'bg-green-700 text-white' : 'text-gray-400 hover:text-white hover:bg-green-700' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        Dasbor
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <div class="text-xs font-semibold leading-6 text-gray-400">DATA SEKOLAH</div>
            <ul role="list" class="-mx-2 mt-2 space-y-1">
                {{-- 2. DATA SISWA --}}
                <li>
                    <a href="{{ route('siswa.index') }}" 
                       class="{{ request()->routeIs('siswa.*') ? 'bg-green-700 text-white' : 'text-gray-400 hover:text-white hover:bg-green-700' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                        <svg class="h-6 w-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.003c0 1.113.285 2.16.786 3.07M15 19.128c.331.18.681.303 1.05.372m0 0c3.072.51 5.986.337 8.528-1.48.393-.272.602-.747.602-1.228 0-.481-.21-.956-.602-1.228-2.543-1.816-5.456-1.99-8.528-1.479a.998.998 0 00-.543.539c-.194.335-.194.74 0 1.076.262.454.68.804 1.155 1.021m-2.1 0c.369-.07.738-.19.1.05-.372M8.25 6.75h9m-9 3h9m-9 3h9m-9 3h9M3.75 6.75h.008v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 10.5h.008v.008H3.75V10.5zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 14.25h.008v.008H3.75V14.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 18h.008v.008H3.75V18zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        Data Siswa
                    </a>
                </li>
                {{-- 3. DATA GURU --}}
                <li>
                    <a href="{{ route('guru.index') }}" 
                       class="{{ request()->routeIs('guru.*') ? 'bg-green-700 text-white' : 'text-gray-400 hover:text-white hover:bg-green-700' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                       <svg class="h-6 w-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                       </svg>
                        Data Guru
                    </a>
                </li>
                
                {{-- 4. MANAJEMEN KELAS (DROPDOWN) --}}
                <li x-data="{ open: {{ request()->routeIs('kelas.*') ? 'true' : 'false' }} }">
                    {{-- Tombol Dropdown Utama --}}
                    <button @click="open = !open" 
                            class="{{ request()->routeIs('kelas.*') ? 'bg-green-700 text-white' : 'text-gray-400 hover:text-white hover:bg-green-700' }} group flex w-full items-center gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                        <svg class="h-6 w-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                        </svg>
                        Manajemen Kelas
                        <svg class="ml-auto h-5 w-5 shrink-0 transform transition-transform" :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    
                    {{-- --- INI BARIS YANG DIPERBAIKI --- --}}
                    {{-- Sub-menu (pl-11 dihapus dari sini) --}}
                    <ul x-show="open" x-transition class="mt-1 space-y-1">
                        <li>
                            {{-- pl-11 dan bg-green-700 ditambahkan di sini --}}
                            <a href="{{ route('kelas.index') }}" 
                               class="{{ request()->routeIs('kelas.index', 'kelas.create', 'kelas.edit', 'kelas.show') ? 'bg-green-700 text-white' : 'text-gray-400 hover:text-white hover:bg-green-700' }} 
                                      block rounded-md py-2 pr-2 pl-11 text-sm leading-6">
                                Daftar Kelas
                            </a>
                        </li>
                        <li>
                            {{-- pl-11 dan bg-green-700 ditambahkan di sini --}}
                            <a href="{{ route('kelas.promotionTool') }}" 
                               class="{{ request()->routeIs('kelas.promotionTool') ? 'bg-green-700 text-white' : 'text-gray-400 hover:text-white hover:bg-green-700' }} 
                                      block rounded-md py-2 pr-2 pl-11 text-sm leading-6">
                                Alat Kenaikan Kelas
                            </a>
                        </li>
                    </ul>
                    {{-- --------------------------------- --}}
                </li>
                
                {{-- 5. DATA MAPEL --}}
                <li>
                    <a href="{{ route('mapels.index') }}" 
                       class="{{ request()->routeIs('mapels.*') ? 'bg-green-700 text-white' : 'text-gray-400 hover:text-white hover:bg-green-700' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                        <svg class="h-6 w-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18c-2.305 0-4.408.867-6 2.292m0-14.25v14.25" />
                        </svg>
                        Data Mata Pelajaran
                    </a>
                </li>
                {{-- 6. DATA JADWAL --}}
                <li>
                    <a href="{{ route('jadwal.index') }}" 
                       class="{{ request()->routeIs('jadwal.*') ? 'bg-green-700 text-white' : 'text-gray-400 hover:text-white hover:bg-green-700' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                        <svg class="h-6 w-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-18 0h18" />
                        </svg>
                        Data Jadwal
                    </a>
                </li>
            </ul>
        </li>
        {{-- ... (sisa menu Anda) ... --}}
    </ul>
</nav>