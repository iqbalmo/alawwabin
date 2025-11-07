{{-- 
    File ini untuk di-include di app.blade.php
    Berisi navigasi utama untuk sidebar desktop dan mobile.
--}}
<nav class="flex flex-1 flex-col">
    <ul role="list" class="flex flex-1 flex-col gap-y-7">
        <li>
            {{-- Daftar Link Utama --}}
            <ul role="list" class="-mx-2 space-y-1">
                <li>
                    <a href="{{ route('home') }}"
                       class="{{ request()->routeIs('home') ? 'bg-[#C8963E] text-[#333333]' : 'text-gray-300 hover:bg-[#C8963E] hover:text-[#333333]' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        Dashboard
                    </a>
                </li>

                {{-- Dropdown Data Master --}}
                <li x-data="{ open: {{ request()->routeIs(['siswa.*', 'guru.*', 'kelas.*', 'mapels.*']) ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                            class="{{ request()->routeIs(['siswa.*', 'guru.*', 'kelas.*', 'mapels.*']) ? 'bg-[#C8963E] text-[#333333]' : 'text-gray-300 hover:bg-[#C8963E] hover:text-[#333333]' }} group flex w-full items-center gap-x-3 rounded-md p-2 text-left text-sm font-semibold leading-6">
                        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.824-2.167-1.943-2.39a4.125 4.125 0 00-1.121.069c-.07.013-.138.028-.206.044m-7.228 0a4.125 4.125 0 01-1.533 2.493A9.337 9.337 0 0112 21.75a9.38 9.38 0 01-2.625-.372M6.35 13.028a9.337 9.337 0 01-4.121-.952 4.125 4.125 0 017.533 2.493m-7.533-2.493c.07-.013.138-.028.206-.044a4.125 4.125 0 011.121-.069c1.119.223 1.943 1.277 1.943 2.39v.003M4.88 8.072a4.125 4.125 0 017.533-2.493 9.337 9.337 0 014.121.952 4.125 4.125 0 01-7.533 2.493m7.533-2.493c-.07.013-.138.028-.206.044a4.125 4.125 0 00-1.121.069c-1.119-.223-1.943-1.277-1.943-2.39V5.625m0 0A9.337 9.337 0 0012 2.25a9.38 9.38 0 00-2.625.372M4.88 8.072L5 8.072m0 0l-.12.002M11.25 5.625v.003V5.625m0 0A9.337 9.337 0 0112 2.25a9.38 9.38 0 012.625.372m0 0V5.625m0 0l.12.002" />
                        </svg>
                        Data Master
                        <svg :class="open ? 'rotate-90' : ''"
                             class="ml-auto h-5 w-5 shrink-0 transform transition-colors duration-200 ease-in-out"
                             viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                  clip-rule="evenodd" />
                        </svg>
                    </button>
                    <ul x-show="open" class="mt-1 px-2 space-y-1" x-cloak>
                        <li>
                            <a href="{{ route('siswa.index') }}"
                               class="{{ request()->routeIs('siswa.*') ? 'bg-[#C8963E] text-[#333333]' : 'text-gray-300 hover:bg-[#C8963E] hover:text-[#333333]' }} group flex gap-x-3 rounded-md p-2 pl-11 text-sm leading-6 font-semibold">Siswa</a>
                        </li>
                        <li>
                            <a href="{{ route('guru.index') }}"
                               class="{{ request()->routeIs('guru.*') ? 'bg-[#C8963E] text-[#333333]' : 'text-gray-300 hover:bg-[#C8963E] hover:text-[#333333]' }} group flex gap-x-3 rounded-md p-2 pl-11 text-sm leading-6 font-semibold">Guru</a>
                        </li>
                        <li>
                            <a href="{{ route('kelas.index') }}"
                               class="{{ request()->routeIs('kelas.*') ? 'bg-[#C8963E] text-[#333333]' : 'text-gray-300 hover:bg-[#C8963E] hover:text-[#333333]' }} group flex gap-x-3 rounded-md p-2 pl-11 text-sm leading-6 font-semibold">Kelas</a>
                        </li>
                        <li>
                            <a href="{{ route('mapels.index') }}"
                               class="{{ request()->routeIs('mapels.*') ? 'bg-[#C8963E] text-[#333333]' : 'text-gray-300 hover:bg-[#C8963E] hover:text-[#333333]' }} group flex gap-x-3 rounded-md p-2 pl-11 text-sm leading-6 font-semibold">Mata Pelajaran</a>
                        </li>
                    </ul>
                </li>

                {{-- Link Jadwal Guru --}}
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
            </ul>
        </li>

        {{-- Link Settings di Bagian Bawah --}}
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