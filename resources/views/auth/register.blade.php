<x-guest-layout>
    <div class="min-h-screen w-full flex flex-col justify-center items-center bg-[#12141c] px-4">

        <div class="mb-6 flex items-center gap-2">
            <span class="text-amber-500 text-2xl">◆</span>
            <span class="font-bold text-xl tracking-wider text-white uppercase">GADGETRENT</span>
        </div>

        <div class="w-full max-w-[440px] bg-[#1a1d26] border border-gray-800/80 rounded-xl p-8 shadow-2xl">
            <div class="mb-6">
                <h2 class="text-lg font-bold text-white tracking-wide">Buat Akun Baru</h2>
                <p class="text-xs text-gray-400 mt-1">Daftarkan akun administrator toko gadget Anda</p>
            </div>

            <x-input-error :messages="$errors->get('name')" class="mb-3 text-xs" />
            <x-input-error :messages="$errors->get('email')" class="mb-3 text-xs" />
            <x-input-error :messages="$errors->get('password')" class="mb-3 text-xs" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mb-3 text-xs" />

            <form method="POST" action="{{ route('register') }}" class="space-y-4 text-sm">
                @csrf

                <div>
                    <label for="name" class="block text-gray-400 mb-1.5 font-medium">Nama Lengkap</label>
                    <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                           class="w-full bg-[#12141c] border border-gray-800 rounded-lg px-3 py-2.5 text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition">
                </div>

                <div>
                    <label for="email" class="block text-gray-400 mb-1.5 font-medium">Alamat Email</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                           class="w-full bg-[#12141c] border border-gray-800 rounded-lg px-3 py-2.5 text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition">
                </div>

                <div>
                    <label for="password" class="block text-gray-400 mb-1.5 font-medium">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           class="w-full bg-[#12141c] border border-gray-800 rounded-lg px-3 py-2.5 text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-gray-400 mb-1.5 font-medium">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                           class="w-full bg-[#12141c] border border-gray-800 rounded-lg px-3 py-2.5 text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition">
                </div>

                <div class="pt-3">
                    <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-[#12141c] font-bold py-2.5 rounded-lg transition tracking-wide shadow-md">
                        Daftar Akun
                    </button>
                </div>
            </form>

            <p class="text-center text-xs text-gray-500 mt-6">
                Sudah memiliki akun?
                <a href="{{ route('login') }}" class="text-amber-500 hover:underline font-medium">Masuk di sini</a>
            </p>
        </div>

    </div>
</x-guest-layout>
