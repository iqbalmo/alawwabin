{{-- 
  File ini untuk sidebar khusus Guru
  Struktur dan warna diselaraskan dengan navigation.blade.php
--}}

<nav class="flex flex-1 flex-col">
    <ul role="list" class="flex flex-1 flex-col gap-y-7">
        <li>
            {{-- Link Dashboard --}}
            <ul role="list" class="-mx-2 space-y-1">
                
                {{-- 1. Dashboard (Log Guru) --}}
                @can('view gurulog')
                <li>
                    {{-- 
                      PERBAIKAN: 
                      - Mengganti routeIs('home') menjadi routeIs('gurulog.*') 
                      - Menyelaraskan warna (bg-green-700, text-gray-400)
                    --}}
                    <a href="{{ route('gurulog.index') }}"
                       class="{{ request()->routeIs('gurulog.*') ? 'bg-green-700 text-white' : 'text-gray-400 hover:text-white hover:bg-green-700' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        Dasbor
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        
        {{-- 
        ==================================================================
        PERBAIKAN: Menambahkan Struktur Heading "DATA AKADEMIK"
        ==================================================================
        --}}
        <li>
            {{-- Hanya tampilkan heading jika user punya salah satu izin di bawah --}}
            @canany(['view jadwal', 'manage absensi'])
            <div class="text-xs font-semibold leading-6 text-gray-400">DATA AKADEMIK</div>
            
            <ul role="list" class="-mx-2 mt-2 space-y-1">
                {{-- 2. Jadwal Guru --}}
                @can('view jadwal')
                <li>
                    <a href="{{ route('jadwal.index') }}"
                       class="{{ request()->routeIs('jadwal.*') ? 'bg-green-700 text-white' : 'text-gray-400 hover:text-white hover:bg-green-700' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        Jadwal Guru
                    </a>
                </li>
                @endcan

                {{-- 3. Rekap Data Kelas (Absensi) --}}
                @can('manage absensi')
                <li>
                    <a href="{{ route('rekap.index') }}"
                       class="{{ request()->routeIs('rekap.*') ? 'bg-green-700 text-white' : 'text-gray-400 hover:text-white hover:bg-green-700' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3 3v18h18M9 17V9m4 8V5m4 12v-6" />
                        </svg>
                        Rekap Data Kelas
                    </a>
                </li>
                @endcan
            </ul>
            @endcanany
        </li>
        {{-- ================================================================== --}}


        {{-- 
        ==================================================================
        PERBAIKAN: Menghapus link "Settings" (Ubah Password) di bawah.
        Link ini sudah ada di dropdown profil di 'app.blade.php'.
        Menghapusnya akan menyelaraskan file ini dengan 'navigation.blade.php'.
        ==================================================================
        --}}
        {{-- 
        <li class="mt-auto">
             <a href="{{ route('password.edit') }}"
                class="{{ request()->routeIs('password.edit') ? 'bg-[#C8963E] text-[#333333]' : 'text-gray-300 hover:bg-[#C8963E] hover:text-[#333333]' }} group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6">
                 <svg ...>...</svg>
                 Ubah Password
             </a>
        </li> 
        --}}
    </ul>
</nav>