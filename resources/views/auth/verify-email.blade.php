<x-guest-layout>
    <div class="min-h-screen w-full flex flex-col justify-center items-center bg-[#12141c] px-4">

        <div class="mb-6 flex items-center gap-2">
            <span class="text-amber-500 text-2xl">◆</span>
            <span class="font-bold text-xl tracking-wider text-white uppercase">GADGETRENT</span>
        </div>

        <div class="w-full max-w-[440px] bg-[#1a1d26] border border-gray-800/80 rounded-xl p-8 shadow-2xl text-sm">
            <div class="mb-6">
                <h2 class="text-lg font-bold text-white tracking-wide">Verifikasi Email Anda</h2>
                <p class="text-xs text-gray-400 mt-2 leading-relaxed">
                    Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi alamat email Anda dengan mengeklik tautan yang baru saja kami kirimkan. Jika Anda tidak menerimanya, kami akan mengirimkan ulang.
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-xs text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 p-3 rounded-lg">
                    Tautan verifikasi baru telah dikirim ke alamat email Anda.
                </div>
            @endif

            <div class="mt-4 flex flex-col gap-3">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-[#12141c] font-bold py-2.5 rounded-lg transition tracking-wide shadow-md text-center">
                        Kirim Ulang Email Verifikasi
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="text-center">
                    @csrf
                    <button type="submit" class="text-xs text-gray-400 hover:text-white underline transition">
                        Keluar (Log Out)
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
