<x-guest-layout>
    <div class="min-h-screen w-full flex flex-col justify-center items-center bg-[#12141c] px-4">

        <div class="mb-6 flex items-center gap-2">
            <span class="text-amber-500 text-2xl">◆</span>
            <span class="font-bold text-xl tracking-wider text-white uppercase">GADGETRENT</span>
        </div>

        <div class="w-full max-w-[440px] bg-[#1a1d26] border border-gray-800/80 rounded-xl p-8 shadow-2xl">
            <div class="mb-6">
                <h2 class="text-lg font-bold text-white tracking-wide">Selamat Datang</h2>
                <p class="text-xs text-gray-400 mt-1">Silakan masuk ke akun manajemen toko Anda</p>
            </div>

            <x-auth-session-status class="mb-4 text-xs" :status="session('status')" />
            <x-input-error :messages="$errors->get('email')" class="mb-3 text-xs" />
            <x-input-error :messages="$errors->get('password')" class="mb-3 text-xs" />

            <form method="POST" action="{{ route('login') }}" class="space-y-4 text-sm">
                @csrf

                <div>
                    <label for="email" class="block text-gray-400 mb-1.5 font-medium">Alamat Email</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                           class="w-full bg-[#12141c] border border-gray-800 rounded-lg px-3 py-2.5 text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition">
                </div>

                <div>
                    <label for="password" class="block text-gray-400 mb-1.5 font-medium">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                           class="w-full bg-[#12141c] border border-gray-800 rounded-lg px-3 py-2.5 text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition">

                    @if (Route::has('password.request'))
                        <div class="flex justify-end mt-1.5">
                            <a href="{{ route('password.request') }}" class="text-xs text-amber-500 hover:underline">
                                Lupa Password?
                            </a>
                        </div>
                    @endif
                </div>

                <div class="flex items-center pt-1">
                    <input id="remember_me" type="checkbox" name="remember"
                           class="w-4 h-4 rounded bg-[#12141c] border-gray-800 text-amber-500 focus:ring-0 focus:ring-offset-0">
                    <label for="remember_me" class="ml-2 text-xs text-gray-400 select-none">Ingat perangkat saya</label>
                </div>

                <div class="pt-3">
                    <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-[#12141c] font-bold py-2.5 rounded-lg transition tracking-wide shadow-md">
                        Masuk
                    </button>
                </div>
            </form>

            <div class="flex items-center gap-3 my-5">
                <div class="flex-1 h-px bg-gray-800"></div>
                <span class="text-[11px] text-gray-500 uppercase tracking-wide">Atau</span>
                <div class="flex-1 h-px bg-gray-800"></div>
            </div>

            <a href="{{ route('auth.google.redirect') }}"
               class="w-full flex items-center justify-center gap-2 bg-[#12141c] border border-gray-800 hover:border-gray-700 hover:bg-gray-900 text-white text-sm font-medium py-2.5 rounded-lg transition">
                <svg class="w-4 h-4" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M23.49 12.27c0-.79-.07-1.54-.19-2.27H12v4.51h6.47c-.29 1.48-1.14 2.73-2.4 3.58v3h3.86c2.26-2.09 3.56-5.17 3.56-8.82z"/>
                    <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.86-3c-1.08.72-2.45 1.16-4.07 1.16-3.13 0-5.78-2.11-6.73-4.96H1.29v3.09C3.26 21.3 7.31 24 12 24z"/>
                    <path fill="#FBBC05" d="M5.27 14.29c-.25-.72-.38-1.49-.38-2.29s.14-1.57.38-2.29V6.62H1.29A11.96 11.96 0 000 12c0 1.93.46 3.76 1.29 5.38l3.98-3.09z"/>
                    <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.31 0 3.26 2.7 1.29 6.62l3.98 3.09C6.22 6.86 8.87 4.75 12 4.75z"/>
                </svg>
                Masuk dengan Google
            </a>

            @if (Route::has('register'))
                <p class="text-center text-xs text-gray-500 mt-6">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-amber-500 hover:underline font-medium">Daftar sekarang</a>
                </p>
            @endif
        </div>

    </div>
</x-guest-layout>
