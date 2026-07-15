<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran - GadgetRent</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#0b0c10] text-gray-200 flex flex-col min-h-screen">
    
    <!-- Navbar -->
    <nav class="border-b border-gray-900 bg-[#0b0c10] py-4 px-6 md:px-12 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center gap-2">
            <span class="flex h-4 w-4 rotate-45 items-center justify-center rounded-sm bg-amber-500"></span>
            <span class="text-sm font-bold tracking-wide text-white uppercase">GADGETRENT</span>
        </div>
        <div class="hidden md:flex gap-8 text-sm font-medium text-gray-400">
            <a href="/" class="hover:text-white transition">Home</a>
            <a href="{{ route('catalog.index') }}" class="hover:text-white transition">Katalog</a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center py-10 px-6">
        <div class="bg-[#15171e] border border-gray-800 rounded-xl p-8 max-w-lg w-full shadow-2xl">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-white mb-2">Menunggu Pembayaran</h2>
                <p class="text-gray-400 text-sm">Kode Pesanan: <span class="font-mono text-amber-500">{{ $invoiceCode }}</span></p>
                <p class="text-white text-3xl font-mono font-bold mt-4">Rp {{ number_format($finalAmount, 0, ',', '.') }}</p>
            </div>

            @if($paymentMethod === 'bank_transfer')
                <div class="bg-[#12141c] border border-gray-800 rounded-lg p-5 mb-6 text-sm text-gray-300">
                    <p class="font-bold text-white mb-3 text-base">Instruksi Transfer Bank (Seabank)</p>
                    <ol class="list-decimal pl-5 space-y-2 mb-4">
                        <li>Buka aplikasi m-banking atau ATM Anda.</li>
                        <li>Pilih menu Transfer > Ke Bank Lain.</li>
                        <li>Pilih bank tujuan: <strong>Seabank</strong></li>
                        <li>Masukkan nomor rekening: <strong class="text-white bg-gray-800 px-2 py-1 rounded tracking-widest text-base mx-1">901568616319</strong></li>
                        <li>Pastikan nama rekening tujuan adalah: <strong>Sultan Fadhilah Hilmiqashmal</strong></li>
                        <li>Masukkan nominal transfer tepat sebesar <strong class="text-amber-500">Rp {{ number_format($finalAmount, 0, ',', '.') }}</strong></li>
                        <li>Selesaikan pembayaran.</li>
                    </ol>
                </div>
            @elseif($paymentMethod === 'qris')
                <div class="bg-white rounded-lg p-5 mb-6 text-center">
                    <p class="font-bold text-black mb-3 text-base">Scan QRIS</p>
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=GADGETRENT-{{ $invoiceCode }}-{{ $finalAmount }}" alt="QRIS Dummy" class="mx-auto rounded-lg mb-3">
                    <p class="text-xs text-gray-500">Silakan scan kode QR di atas menggunakan aplikasi e-wallet atau m-banking Anda.</p>
                </div>
            @elseif($paymentMethod === 'cod')
                <div class="bg-emerald-500/10 border border-emerald-500/20 rounded-lg p-5 mb-6 text-emerald-400 text-center">
                    <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <p class="font-bold text-lg mb-1">Bayar di Tempat Dipilih</p>
                    <p class="text-sm">Anda dapat melakukan pembayaran langsung di toko/hub kami saat mengambil barang.</p>
                </div>
            @endif

            <form action="{{ route('checkout.confirmPayment') }}" method="POST">
                @csrf
                <input type="hidden" name="invoice_code" value="{{ $invoiceCode }}">
                
                @if($paymentMethod === 'cod')
                    <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-[#12141c] font-bold py-3.5 rounded-xl transition shadow-[0_0_15px_rgba(245,158,11,0.2)]">
                        Kembali ke Pesanan Saya
                    </button>
                @else
                    <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-[#12141c] font-bold py-3.5 rounded-xl transition shadow-[0_0_15px_rgba(245,158,11,0.2)]">
                        Konfirmasi Pembayaran
                    </button>
                    <p class="text-xs text-gray-500 text-center mt-3">Klik tombol ini setelah Anda selesai melakukan pembayaran. (Dummy)</p>
                @endif
            </form>
        </div>
    </main>
</body>
</html>
