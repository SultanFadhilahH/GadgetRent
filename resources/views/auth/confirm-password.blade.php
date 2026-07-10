<x-guest-layout>
    <div class="min-h-screen w-full flex flex-col justify-center items-center bg-[#12141c] px-4">

        <div class="mb-6 flex items-center gap-2">
            <span class="text-amber-500 text-2xl">◆</span>
            <span class="font-bold text-xl tracking-wider text-white uppercase">GADGETRENT</span>
        </div>

        <div class="w-full max-w-[440px] bg-[#1a1d26] border border-gray-800/80 rounded-xl p-8 shadow-2xl text-sm">
            <div class="mb-6">
                <h2 class="text-lg font-bold text-white tracking-wide">Konfirmasi Keamanan</h2>
                <p class="text-xs text-gray-400 mt-2 leading-relaxed">
                    Ini adalah area aman aplikasi. Silakan konfirmasikan password Anda sebelum melanjutkan tindakan sensitif ini.
                </p>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mb-3 text-xs" />

            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="password" class="block text-gray-400 mb-1.5 font-medium">Password Anda</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                           class="w-full bg-[#12141c] border border-gray-800 rounded-lg px-3 py-2.5 text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition">
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-[#12141c] font-bold py-2.5 rounded-lg transition tracking-wide shadow-md">
                        Konfirmasi Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
