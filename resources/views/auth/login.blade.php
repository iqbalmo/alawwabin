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
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-text-fill-color: #333333 !important; /* */
            -webkit-box-shadow: 0 0 0px 1000px #FFFFFF inset !important; /* */
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
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
                  <input id="email" name="email" type="email" autocomplete="email" value="{{ old('email') }}" required 
                         class="block w-full appearance-none rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-400 shadow-sm focus:border-[#C8963E] focus:outline-none focus:ring-[#C8963E] sm:text-sm @error('email') border-red-500 @enderror">
                </div>
                
                {{-- 🚨 NOTIFIKASI ERROR UNTUK EMAIL/PASSWORD SALAH --}}
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>
              
              <div class="space-y-1">
                <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                <div class="mt-1">
                  <input id="password" name="password" type="password" autocomplete="current-password" required 
                         class="block w-full appearance-none rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-400 shadow-sm focus:border-[#C8963E] focus:outline-none focus:ring-[#C8963E] sm:text-sm @error('password') border-red-500 @enderror">
                </div>

                {{-- 🚨 NOTIFIKASI ERROR JIKA PASSWORD KOSONG --}}
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