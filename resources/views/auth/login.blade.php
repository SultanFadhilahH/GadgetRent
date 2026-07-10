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

            @if (Route::has('register'))
                <p class="text-center text-xs text-gray-500 mt-6">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-amber-500 hover:underline font-medium">Daftar sekarang</a>
                </p>
            @endif
        </div>

    </div>
</x-guest-layout>
