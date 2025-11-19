<!DOCTYPE html>
<html lang="id" class="h-full bg-[#F9F9F9]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | SITU Al-Awwabin</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/alawwabin-logo.png') }}">
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        [x-cloak] { display: none !important; }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="h-full font-sans antialiased text-[#333333]">

    <div class="min-h-screen flex">
        <!-- Left Side: Form Area -->
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24 bg-white z-10 relative">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                
                <!-- Header -->
                <div class="text-center lg:text-left animate-fade-in-up">
                    <img class="h-16 w-auto mx-auto lg:mx-0 hover:scale-105 transition-transform duration-300" src="{{ asset('img/alawwabin-logo.png') }}" alt="Logo Al-Awwabin">
                    <h2 class="mt-6 text-3xl font-extrabold text-[#2C5F2D]">
                        Selamat Datang
                    </h2>
                    <p class="mt-2 text-sm text-[#6b7280]">
                        Silakan masuk untuk mengakses SITU Al-Awwabin
                    </p>
                </div>

                <div class="mt-8 animate-fade-in-up" style="animation-delay: 0.1s;">
                    <div class="mt-6">
                        <form action="{{ route('login') }}" method="POST" class="space-y-6">
                            @csrf

                            <!-- Email Input -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-[#333333]">Email atau NIP</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                        </svg>
                                    </div>
                                    <input id="email" name="email" type="text" autocomplete="username" required value="{{ old('email') }}"
                                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm transition duration-150 ease-in-out @error('email') border-red-500 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                        placeholder="Email atau NIP">
                                </div>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password Input -->
                            <div x-data="{ showPassword: false }">
                                <label for="password" class="block text-sm font-medium text-[#333333]">Kata Sandi</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input :type="showPassword ? 'text' : 'password'" id="password" name="password" autocomplete="current-password" required
                                        class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#C8963E] focus:border-[#C8963E] sm:text-sm transition duration-150 ease-in-out @error('password') border-red-500 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                        placeholder="••••••••">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <button type="button" @click="showPassword = !showPassword" class="text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500 transition-colors">
                                            <svg x-show="!showPassword" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                            </svg>
                                            <svg x-show="showPassword" x-cloak class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                                                <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.742L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.064 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input id="remember-me" name="remember" type="checkbox" class="h-4 w-4 text-[#2C5F2D] focus:ring-[#2C5F2D] border-gray-300 rounded transition duration-150 ease-in-out">
                                    <label for="remember-me" class="ml-2 block text-sm text-[#333333]">
                                        Ingat saya
                                    </label>
                                </div>
                            </div>

                            <div>
                                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-[#2C5F2D] to-[#1e421f] hover:from-[#3a7a3b] hover:to-[#2C5F2D] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2C5F2D] transform transition hover:-translate-y-0.5 duration-200">
                                    Masuk
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="mt-8 text-center animate-fade-in-up" style="animation-delay: 0.2s;">
                    <p class="text-xs text-[#6b7280]">
                        &copy; {{ date('Y') }} MTs Al-Awwabin. All rights reserved.
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Side: Image Area -->
        <div class="hidden lg:block relative w-0 flex-1 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-[#2C5F2D] to-[#C8963E] mix-blend-multiply z-10 opacity-80"></div>
            <img class="absolute inset-0 h-full w-full object-cover transform hover:scale-105 transition-transform duration-[20s]" src="{{ asset('img/alawwabin-gedung.png') }}" alt="Gedung Sekolah">
            
            <!-- Quote / Text Overlay -->
            <div class="absolute inset-0 z-20 flex flex-col justify-end pb-24 px-12 text-white">
                <div class="animate-fade-in-up" style="animation-delay: 0.3s;">
                    <h3 class="text-4xl font-bold mb-4">Pendidikan Berkualitas</h3>
                    <p class="text-lg text-gray-100 max-w-lg">
                        Membangun generasi berakhlak mulia, cerdas, dan berprestasi untuk masa depan yang gemilang.
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>