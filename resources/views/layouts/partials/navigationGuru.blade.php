{{-- 
    File ini untuk sidebar khusus Guru
    Tidak ada Data Master, dan menambahkan Rekap & Riwayat Data Kelas
--}}

<nav class="flex flex-1 flex-col">
    <ul role="list" class="flex flex-1 flex-col gap-y-7">
        <li>
            {{-- Link Dashboard --}}
            <ul role="list" class="-mx-2 space-y-1">
                <li>
                    <a href="{{ route('gurulog.index') }}"
                       class="{{ request()->routeIs('home') ? 'bg-[#C8963E] text-[#333333]' : 'text-gray-300 hover:bg-[#C8963E] hover:text-[#333333]' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        Dashboard
                    </a>
                </li>

                {{-- Jadwal Guru --}}
                <li>
                    <a href="{{ route('jadwal.index') }}"
                       class="{{ request()->routeIs('jadwal.*') ? 'bg-[#C8963E] text-[#333333]' : 'text-gray-300 hover:bg-[#C8963E] hover:text-[#333333]' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        Jadwal Guru
                    </a>
                </li>

                {{-- Rekap Data Kelas --}}
                <li>
                    <a href="{{ route('rekap.index') }}"
                       class="{{ request()->routeIs('rekap.*') ? 'bg-[#C8963E] text-[#333333]' : 'text-gray-300 hover:bg-[#C8963E] hover:text-[#333333]' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3 3v18h18M9 17V9m4 8V5m4 12v-6" />
                        </svg>
                        Rekap Data Kelas
                    </a>
                </li>

                {{-- Riwayat Data Kelas --}}
                <li>
                    <a href="{{ route('riwayat.index') }}"
                       class="{{ request()->routeIs('riwayat.*') ? 'bg-[#C8963E] text-[#333333]' : 'text-gray-300 hover:bg-[#C8963E] hover:text-[#333333]' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-9-9 9 9 0 019 9z" />
                        </svg>
                        Riwayat Data Kelas
                    </a>
                </li>
            </ul>
        </li>

        {{-- Settings di bagian bawah --}}
        <li class="mt-auto">
            <a href="#"
               class="text-gray-300 hover:bg-[#C8963E] hover:text-[#333333] group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6">
                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9.594 3.94c.09-.542.56-1.003 1.11-1.226.55-.223 1.159-.223 1.709 0 .55.223 1.02.684 1.11 1.226M10.162 18.812c.09.542.56 1.004 1.11 1.227.55.223 1.159.223 1.709 0 .55-.223 1.02-.684 1.11-1.227m-5.181 2.353a.75.75 0 01.211-1.033 3.87 3.87 0 00-1.007-1.007.75.75 0 01-1.033-.21A11.13 11.13 0 012.5 10.5c0-1.57.312-3.072.872-4.44m17.256 0a.75.75 0 01-.21 1.033 3.87 3.87 0 00-1.007 1.007.75.75 0 01-1.033.21A11.13 11.13 0 0021.5 10.5c0 1.57-.312 3.072-.872 4.44m.21 1.033a.75.75 0 01-1.033.21 3.87 3.87 0 00-1.007-1.007.75.75 0 01-.21-1.033M3.372 19.24a.75.75 0 011.033-.21 3.87 3.87 0 001.007 1.007.75.75 0 01.21 1.033m13.2-1.618a.75.75 0 01-1.033.21 3.87 3.87 0 00-1.007-1.007.75.75 0 01-.21-1.033M10.5 14.25a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 10.5a1.125 1.125 0 11-2.25 0 1.125 1.125 0 012.25 0z" />
                </svg>
                Settings
            </a>
        </li>
    </ul>
</nav>
