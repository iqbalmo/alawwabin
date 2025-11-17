<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autentikasi | SITU Al-Awwabin</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/alawwabin-logo.png') }}">
    @vite('resources/css/app.css')
    <style>
        /* * Palet "Harmoni Klasik"
         * Hijau Utama: #2C5F2D
         * Aksen Emas: #C8963E
         * Netral Latar: #F9F9F9
         * Netral Sekunder: #F0E6D2
         * Teks Arang: #333333
        */

        /* Mengganti warna latar belakang autofill (light mode) */
        [x-cloak] { display: none !important; }
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-text-fill-color: #333333 !important; /* */
            -webkit-box-shadow: 0 0 0px 1000px #FFFFFF inset !important; /* */
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
    <script src="//unpkg.com/alpinejs"></script>
</head>
<body class="bg-[#F9F9F9] font-sans">

  <div class="flex min-h-screen">
    <div class="flex flex-1 flex-col justify-center pt-8 pb-29 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
      <div class="mx-auto w-full max-w-sm lg:w-96">
        
        <div>
          <div class="text-center mb-6">
            <img src="/img/alawwabin-logo.png" alt="Logo Al-Awwabin" class="mx-auto w-24 h-auto">
          </div>
          <h2 class="mt-6 text-3xl font-bold tracking-tight text-[#2C5F2D]">SITU Al-Awwabin</h2>
          <p class="mt-2 text-sm text-gray-600">
            Sistem Informasi Tata Usaha MA/MTs Al-Awwabin
          </p>
        </div>

        <div class="mt-8">
          <div class="mt-6">
            <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
              @csrf
              <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email/NIP</label>
                <div class="mt-1">
                  <input id="email" name="email" type="text" autocomplete="email" value="{{ old('email') }}" required 
                         class="block w-full appearance-none rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-400 shadow-sm focus:border-[#C8963E] focus:outline-none focus:ring-[#C8963E] sm:text-sm @error('email') border-red-500 @enderror">
                </div>
                
                {{-- 🚨 NOTIFIKASI ERROR UNTUK EMAIL/PASSWORD SALAH --}}
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>
              
              <div x-data="{ showPassword: false }">
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                    <div class="mt-2 relative">
                        <input id="password" name="password" 
                               {{-- 1. Buat tipe input dinamis --}}
                               :type="showPassword ? 'text' : 'password'" 
                               autocomplete="current-password" required
                               {{-- 2. Tambahkan padding kanan (pr-10) untuk ruang ikon --}}
                               class="block w-full appearance-none rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-400 shadow-sm focus:border-[#C8963E] focus:outline-none focus:ring-[#C8963E] sm:text-sm @error('email') border-red-500 @enderror">
                        
                        {{-- 3. Tambahkan Tombol Ikon Mata --}}
                        <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-3"
                                aria-label="Tampilkan atau sembunyikan password">
                            
                            {{-- Ikon Mata (saat password tersembunyi) --}}
                            <svg x-show="!showPassword" class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>

                            {{-- Ikon Mata Tercoret (saat password terlihat) --}}
                            <svg x-show="showPassword" x-cloak class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 rounded border-gray-300 bg-white text-[#C8963E] focus:ring-[#C8963E]">
                  <label for="remember-me" class="ml-2 block text-sm text-gray-600">Ingat saya</label>
                </div>
              </div>

              <div>
                <button type="submit" class="flex w-full justify-center rounded-md border border-transparent bg-[#C8963E] py-2 px-4 text-sm font-medium text-[#333333] shadow-sm hover:bg-[#b58937] focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:ring-offset-2 focus:ring-offset-[#F9F9F9]">Masuk </button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>

    <div class="relative hidden w-0 flex-1 lg:block">
      <div class="absolute inset-0 bg-[#2C5F2D] opacity-60 z-10"></div>
      <img class="absolute inset-0 h-full w-full object-cover" 
           src="/img/alawwabin-gedung.png" 
           alt="Gedung Al-Awwabin">
    </div>
  </div>

</body>
</html>