<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil Saya - GadgetRent</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#0c0d12] text-[#9ca3af] flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav class="border-b border-[#1a1f29] bg-[#0c0d12] py-4 px-6 md:px-12 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center gap-2">
            <a href="/" class="flex items-center gap-2">
                <span class="flex h-3.5 w-3.5 rotate-45 items-center justify-center rounded-sm bg-[#e49322]"></span>
                <span class="text-sm font-black tracking-wider text-white uppercase font-sans">GADGETRENT</span>
            </a>
        </div>

        <div class="hidden md:flex gap-6 text-xs font-semibold text-[#9ca3af]">
            <a href="/" class="hover:text-white transition">Home</a>
            <a href="#" class="hover:text-white transition">Katalog</a>
            <a href="#" class="hover:text-white transition">Blog</a>
            <a href="#" class="hover:text-white transition">Tentang Kami</a>
        </div>

        <div class="flex items-center gap-4">
            @include('components.navbar-cart')
            <div class="h-8 w-8 bg-[#e49322] rounded-md flex items-center justify-center text-black font-extrabold text-xs uppercase shadow-md shadow-[#e49322]/10">
                {{ substr(auth()->user()->name, 0, 2) }}
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow py-12 px-6 md:px-12 max-w-7xl w-full mx-auto">

        <!-- Header Text -->
        <div class="mb-10">
            <p class="text-[#e49322] font-bold tracking-widest text-[10px] uppercase mb-1 font-mono">Akun Saya</p>
            <h1 class="text-3xl font-extrabold text-white tracking-tight mb-2">Halo, {{ auth()->user()->name }}</h1>
            <p class="text-xs text-[#9ca3af] max-w-2xl leading-relaxed">
                Kelola profil, alamat pengiriman, keamanan akun, dan pantau semua pesanan sewa kamu di sini.
            </p>
        </div>

        <!-- Two Columns Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">

            <!-- SIDEBAR KIRI -->
            <div class="lg:col-span-1 bg-[#13161e] border border-[#1a1f29] rounded-xl p-4 space-y-6">
                <!-- Mini Profile -->
                <div class="flex items-center gap-3 pb-4 border-b border-[#1a1f29]">
                    <div class="h-11 w-11 bg-[#e49322] rounded-lg flex items-center justify-center text-black font-extrabold text-sm uppercase">
                        {{ substr(auth()->user()->name, 0, 2) }}
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-white truncate max-w-[140px]">{{ auth()->user()->name }}</h3>
                        <a href="{{ route('profile.edit') }}" class="text-[10px] text-[#556075] flex items-center gap-1 cursor-pointer hover:text-[#e49322] transition mt-0.5">
                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Ubah Profil
                        </a>
                    </div>
                </div>

                <!-- Navigation List -->
                <div class="space-y-5 text-[11px]">
                    <div>
                        <p class="text-[9px] font-bold text-[#475166] uppercase tracking-wider mb-2 px-2">Akun Saya</p>
                        <div class="space-y-1">
                            <a href="{{ route('profile.edit') }}" class="flex items-center px-3 py-2 rounded-lg {{ $currentTab === 'profile' ? 'bg-[#1a1f29] border-l-2 border-[#e49322] text-white font-semibold' : 'text-[#9ca3af] hover:text-white hover:bg-[#1a1f29]/40 font-medium' }} transition">
                                Profil Saya
                            </a>
                            <a href="{{ route('profile.identity') }}" class="flex items-center px-3 py-2 rounded-lg {{ $currentTab === 'identity' ? 'bg-[#1a1f29] border-l-2 border-[#e49322] text-white font-semibold' : 'text-[#9ca3af] hover:text-white hover:bg-[#1a1f29]/40 font-medium' }} transition">
                                Verifikasi Identitas
                            </a>
                            <a href="{{ route('addresses.index') }}" class="flex items-center px-3 py-2 rounded-lg {{ $currentTab === 'addresses' ? 'bg-[#1a1f29] border-l-2 border-[#e49322] text-white font-semibold' : 'text-[#9ca3af] hover:text-white hover:bg-[#1a1f29]/40 font-medium' }} transition">
                                Alamat
                            </a>
                            <a href="{{ route('password.edit') }}" class="flex items-center px-3 py-2 rounded-lg {{ $currentTab === 'password' ? 'bg-[#1a1f29] border-l-2 border-[#e49322] text-white font-semibold' : 'text-[#9ca3af] hover:text-white hover:bg-[#1a1f29]/40 font-medium' }} transition">
                                Ubah Kata Sandi
                            </a>
                        </div>
                    </div>

                    <div>
                        <p class="text-[9px] font-bold text-[#475166] uppercase tracking-wider mb-2 px-2">Pesanan</p>
                        <div class="space-y-1">
                            <a href="{{ route('orders.index') }}" class="flex justify-between items-center px-3 py-2 rounded-lg {{ $currentTab === 'orders' ? 'bg-[#1a1f29] border-l-2 border-[#e49322] text-white font-semibold' : 'text-[#9ca3af] hover:text-white hover:bg-[#1a1f29]/40' }} transition">
                                <span>Pesanan Saya</span>
                                <span class="text-[#475166] font-bold font-mono">4</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KONTEN UTAMA KANAN -->
            <div class="lg:col-span-3 bg-[#13161e] border border-[#1a1f29] rounded-xl {{ $currentTab === 'orders' ? 'p-0 bg-transparent border-none' : 'p-6 md:p-7' }}">

                @if($currentTab === 'profile')
                    <!-- ================= KONTEN 1: PROFIL SAYA ================= -->
                    <div class="flex justify-between items-center mb-6 border-b border-[#1a1f29] pb-4">
                        <h2 class="text-sm font-bold text-white tracking-wide">Profil Saya</h2>
                        <p class="text-[10px] text-[#556075] font-medium font-mono">Kelola data pribadi kamu</p>
                    </div>

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="flex flex-col md:flex-row gap-8">
                            <div class="flex-grow grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[11px] font-bold text-[#9ca3af] mb-1.5">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full bg-[#1a1f29] border border-[#242b38] rounded-lg px-3.5 py-2 text-xs text-white focus:border-[#e49322] focus:outline-none transition">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-[#9ca3af] mb-1.5">Username</label>
                                    <input type="text" name="username" value="{{ old('username', auth()->user()->username ?? Str::slug(auth()->user()->name, '')) }}" class="w-full bg-[#1a1f29] border border-[#242b38] rounded-lg px-3.5 py-2 text-xs text-white focus:border-[#e49322] focus:outline-none transition">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-[#9ca3af] mb-1.5">NIK</label>
                                    <input type="text" name="nik" value="{{ old('nik', auth()->user()->nik) }}" placeholder="3201234567890001" class="w-full bg-[#1a1f29] border border-[#242b38] rounded-lg px-3.5 py-2 text-xs text-white focus:border-[#e49322] focus:outline-none transition">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-[#9ca3af] mb-1.5">No. HP</label>
                                    <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" placeholder="081234567890" class="w-full bg-[#1a1f29] border border-[#242b38] rounded-lg px-3.5 py-2 text-xs text-white focus:border-[#e49322] focus:outline-none transition">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-[#9ca3af] mb-1.5">Email</label>
                                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full bg-[#1a1f29] border border-[#242b38] rounded-lg px-3.5 py-2 text-xs text-white focus:border-[#e49322] focus:outline-none transition">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-[#9ca3af] mb-1.5">Tanggal Lahir</label>
                                    <input type="date" name="birth_date" value="{{ old('birth_date', auth()->user()->birth_date ? \Carbon\Carbon::parse(auth()->user()->birth_date)->format('Y-m-d') : '') }}" class="w-full bg-[#1a1f29] border border-[#242b38] rounded-lg px-3.5 py-2 text-xs text-white focus:border-[#e49322] focus:outline-none transition accent-[#e49322]">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-[11px] font-bold text-[#9ca3af] mb-1.5">Jenis Kelamin</label>
                                    <div class="relative">
                                        <select name="gender" class="w-full bg-[#1a1f29] border border-[#242b38] rounded-lg px-3.5 py-2 text-xs text-white focus:border-[#e49322] focus:outline-none transition appearance-none">
                                            <option value="" disabled {{ !auth()->user()->gender ? 'selected' : '' }}>Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki" {{ auth()->user()->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ auth()->user()->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#9ca3af]">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col items-center justify-start md:w-44 pt-2">
                                <div class="h-24 w-24 bg-[#e49322] rounded-xl flex items-center justify-center text-black font-black text-2xl uppercase shadow-lg shadow-[#e49322]/10 mb-3">
                                    {{ substr(auth()->user()->name, 0, 2) }}
                                </div>
                                <button type="button" class="bg-[#1a1f29] border border-[#242b38] hover:border-[#e49322] hover:text-white transition text-[10px] font-bold text-white px-3 py-1.5 rounded-md">
                                    Ganti Foto
                                </button>
                                <p class="text-[9px] text-[#556075] mt-2 font-medium font-mono">JPG/PNG, maks. 2MB</p>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-[#1a1f29]">
                            <button type="submit" class="bg-[#e49322] hover:bg-[#c97e1b] text-black font-extrabold text-xs px-5 py-2.5 rounded-lg transition shadow-md shadow-[#e49322]/5">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                @elseif($currentTab === 'identity')
                    <!-- ================= KONTEN 2: VERIFIKASI IDENTITAS ================= -->
                    <div class="flex justify-between items-center mb-6 border-b border-[#1a1f29] pb-4">
                        <h2 class="text-sm font-bold text-white tracking-wide">Verifikasi Identitas</h2>
                        <p class="text-[10px] text-[#556075] font-medium font-mono tracking-wider">Wajib untuk mengambil unit sewa</p>
                    </div>

                    <div class="space-y-6" x-data="{
                        isUploading: false,
                        uploadError: '',
                        handleUpload(e) {
                            let file = e.target.files[0];
                            if(!file) return;

                            this.isUploading = true;
                            this.uploadError = '';

                            let formData = new FormData();
                            formData.append('ktp_image', file);
                            formData.append('_token', '{{ csrf_token() }}');

                            fetch('{{ route('profile.verifyKtp') }}', {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'Accept': 'application/json'
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                this.isUploading = false;
                                if(data.success) {
                                    window.location.reload();
                                } else {
                                    this.uploadError = data.message || 'Gagal mengupload KTP';
                                }
                            })
                            .catch(err => {
                                this.isUploading = false;
                                this.uploadError = 'Terjadi kesalahan jaringan.';
                            });
                        }
                    }">
                        @if(auth()->user()->ktp_verified_at)
                            <div class="flex items-center gap-3 bg-[#1c2e24]/40 border border-[#234e34] rounded-xl p-4 text-[#4ade80]">
                                <div class="flex-shrink-0 bg-[#234e34] rounded-full p-1">
                                    <svg class="w-4 h-4 text-[#4ade80]" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div class="text-xs">
                                    <span class="font-bold mr-2">Akun Terverifikasi</span>
                                    <span class="text-[#86efac]/80 font-medium">KTP diverifikasi {{ \Carbon\Carbon::parse(auth()->user()->ktp_verified_at)->format('d M Y') }} — kamu bisa langsung checkout tanpa hambatan.</span>
                                </div>
                            </div>
                            
                            <div>
                                <p class="text-[11px] font-bold text-[#9ca3af] mb-2.5">Dokumen Tersimpan</p>
                                <div class="border border-dashed border-[#242b38] bg-[#161922] bg-stripes p-8 rounded-xl text-center flex flex-col items-center justify-center min-h-[160px]">
                                    <svg class="w-5 h-5 text-[#e49322] mb-2" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    <span class="text-xs text-white font-bold block mb-0.5">{{ basename(auth()->user()->ktp_image_path) }}</span>
                                    <span class="text-[10px] text-[#556075] font-mono block mb-4">Diunggah {{ \Carbon\Carbon::parse(auth()->user()->ktp_verified_at)->format('d M Y') }} • Terverifikasi</span>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-3 bg-red-500/10 border border-red-500/30 rounded-xl p-4 text-red-400">
                                <div class="flex-shrink-0 bg-red-500/20 rounded-full p-1">
                                    <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                                <div class="text-xs">
                                    <span class="font-bold mr-2">Belum Diverifikasi</span>
                                    <span class="text-red-300 font-medium">Unggah KTP kamu untuk memverifikasi akun dan melengkapi data otomatis.</span>
                                </div>
                            </div>
                            
                            <div>
                                <p class="text-[11px] font-bold text-[#9ca3af] mb-2.5">Unggah KTP</p>
                                
                                <div x-show="uploadError" x-text="uploadError" class="mb-4 text-xs text-red-400 bg-red-500/10 p-3 rounded-lg"></div>

                                <label class="border border-dashed border-[#242b38] hover:border-[#e49322] bg-[#161922] p-8 rounded-xl text-center flex flex-col items-center justify-center min-h-[160px] cursor-pointer transition relative overflow-hidden group">
                                    <input type="file" class="hidden" accept="image/*" @change="handleUpload">
                                    
                                    <div x-show="!isUploading" class="flex flex-col items-center">
                                        <div class="h-12 w-12 rounded-full bg-[#1a1f29] group-hover:bg-[#e49322]/20 flex items-center justify-center mb-3 transition">
                                            <svg class="w-6 h-6 text-[#9ca3af] group-hover:text-[#e49322]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        </div>
                                        <span class="text-sm text-white font-bold block mb-1">Klik untuk memilih file</span>
                                        <span class="text-xs text-[#556075]">JPG/PNG maksimal 2MB</span>
                                    </div>
                                    
                                    <div x-show="isUploading" class="flex flex-col items-center">
                                        <svg class="animate-spin h-8 w-8 text-[#e49322] mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span class="text-sm text-white font-bold block mb-1 animate-pulse">Memverifikasi Identitas...</span>
                                        <span class="text-xs text-[#e49322]">Mengekstrak NIK dan Nama otomatis</span>
                                    </div>
                                </label>
                            </div>
                        @endif
                    </div>

                @elseif($currentTab === 'addresses')
                    <!-- ================= KONTEN 3: ALAMAT SAYA ================= -->
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-sm font-bold text-white tracking-wide">Alamat Saya</h2>
                        <button class="bg-[#e49322] hover:bg-[#c97e1b] text-black font-extrabold text-xs px-3.5 py-1.5 rounded-lg transition shadow-md shadow-[#e49322]/5">
                            + Tambah Alamat Baru
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-[#13161e] border border-[#e49322]/40 rounded-xl p-5 relative shadow-sm">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h4 class="text-xs font-black text-white">Budi Santoso</h4>
                                    <span class="text-[11px] font-medium text-[#475166] font-mono">081234567890</span>
                                    <span class="bg-[#e49322]/10 text-[#e49322] text-[9px] font-black font-mono px-1.5 py-0.5 rounded tracking-wide uppercase">Utama</span>
                                </div>
                                <div class="flex items-center gap-3 text-[11px] font-bold">
                                    <button class="text-[#9ca3af] hover:text-white transition">Ubah</button>
                                    <button class="text-[#ef4444] hover:text-[#f87171] transition">Hapus</button>
                                </div>
                            </div>
                            <p class="text-[11px] text-[#9ca3af] leading-relaxed max-w-3xl">
                                Jl. Merdeka No. 10, RT 04/RW 02, Kel. Cihapit, Kec. Bandung Wetan, Kota Bandung, Jawa Barat 40114
                            </p>
                        </div>

                        <div class="bg-[#13161e] border border-[#1a1f29] rounded-xl p-5 relative">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h4 class="text-xs font-black text-[#f3f4f6]">Budi Santoso (Kantor)</h4>
                                    <span class="text-[11px] font-medium text-[#475166] font-mono">081234567890</span>
                                </div>
                                <div class="flex items-center gap-3 text-[11px] font-bold">
                                    <button class="text-[#9ca3af] hover:text-white transition">Jadikan Utama</button>
                                    <button class="text-[#9ca3af] hover:text-white transition">Ubah</button>
                                    <button class="text-[#ef4444] hover:text-[#f87171] transition">Hapus</button>
                                </div>
                            </div>
                            <p class="text-[11px] text-[#556075] leading-relaxed max-w-3xl">
                                Jl. Ir. H. Djuanda No. 45, Lantai 3, Kel. Dago, Kec. Coblong, Kota Bandung, Jawa Barat 40135
                            </p>
                        </div>
                    </div>

                @elseif($currentTab === 'password')
                    <!-- ================= KONTEN 4: UBAH KATA SANDI (PERSIS MOCKUP) ================= -->
                    <div class="flex justify-between items-center mb-6 border-b border-[#1a1f29] pb-4">
                        <h2 class="text-sm font-bold text-white tracking-wide">Ubah Kata Sandi</h2>
                        <p class="text-[10px] text-[#556075] font-medium font-mono">Demi keamanan, jangan bagikan ke siapa pun</p>
                    </div>

                    <form method="POST" action="{{ route('password.update') }}" class="space-y-4 max-w-lg">
                        @csrf
                        @method('put')

                        <div>
                            <label class="block text-[11px] font-bold text-[#9ca3af] mb-1.5">Kata Sandi Saat Ini</label>
                            <input type="password" name="current_password" placeholder="••••••••" class="w-full bg-[#1a1f29] border border-[#242b38] rounded-lg px-3.5 py-2 text-xs text-white focus:border-[#e49322] focus:outline-none transition">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-[#9ca3af] mb-1.5">Kata Sandi Baru</label>
                            <input type="password" name="password" placeholder="Minimal 8 karakter" class="w-full bg-[#1a1f29] border border-[#242b38] rounded-lg px-3.5 py-2 text-xs text-white focus:border-[#e49322] focus:outline-none transition">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-[#9ca3af] mb-1.5">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru" class="w-full bg-[#1a1f29] border border-[#242b38] rounded-lg px-3.5 py-2 text-xs text-white focus:border-[#e49322] focus:outline-none transition">
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="bg-[#e49322] hover:bg-[#c97e1b] text-black font-extrabold text-xs px-5 py-2.5 rounded-lg transition shadow-md shadow-[#e49322]/5">
                                Simpan Kata Sandi
                            </button>
                        </div>
                    </form>

                @elseif($currentTab === 'orders')
                    <!-- ================= KONTEN 5: PESANAN SAYA (PERSIS MOCKUP DENGAN FILTRASI TAB AKTIF) ================= -->
                    <div id="orders-app" class="space-y-4">
                        <!-- Navigation Tab Header -->
                        <div class="flex items-center gap-6 border-b border-[#1a1f29] pb-px text-xs font-bold text-[#9ca3af] overflow-x-auto whitespace-nowrap">
                            <button onclick="switchSubTab('all')" id="tab-all" class="subtab-btn pb-3 px-1 text-[#e49322] border-b-2 border-[#e49322] transition">Semua</button>
                            <button onclick="switchSubTab('unpaid')" id="tab-unpaid" class="subtab-btn pb-3 px-1 hover:text-white transition">Belum Bayar</button>
                            <button onclick="switchSubTab('processing')" id="tab-processing" class="subtab-btn pb-3 px-1 hover:text-white transition">Dikemas</button>
                            <button onclick="switchSubTab('shipping')" id="tab-shipping" class="subtab-btn pb-3 px-1 hover:text-white transition">Dikirim</button>
                            <button onclick="switchSubTab('completed')" id="tab-completed" class="subtab-btn pb-3 px-1 hover:text-white transition">Selesai</button>
                            <button onclick="switchSubTab('cancelled')" id="tab-cancelled" class="subtab-btn pb-3 px-1 hover:text-white transition">Dibatalkan</button>
                        </div>

                        <!-- LIST KARTU PESANAN -->
                        <div class="space-y-4 mt-4">

                            <!-- ITEM 1: Belum Bayar (Sony A7 III) -->
                            <div class="order-card bg-[#13161e] border border-[#1a1f29] rounded-xl p-5" data-status="unpaid">
                                <div class="flex justify-between items-center border-b border-[#1a1f29] pb-3 mb-4 text-[11px]">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 text-[#556075]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                        <span class="font-bold text-white uppercase tracking-wide">GADGETRENT Official</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="font-mono text-[#556075]">INV-20260712-006</span>
                                        <span class="bg-[#e49322]/10 text-[#e49322] text-[10px] font-bold font-mono px-2 py-0.5 rounded-md flex items-center gap-1.5">
                                            <span class="h-1.5 w-1.5 rounded-full bg-[#e49322]"></span>Belum Bayar
                                        </span>
                                    </div>
                                </div>
                                <div class="flex gap-4 items-start">
                                    <div class="h-14 w-14 bg-[#1a1f29] border border-[#242b38] rounded-lg flex items-center justify-center text-[#556075]">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                                    </div>
                                    <div class="flex-grow">
                                        <h4 class="text-xs font-extrabold text-white">Sony A7 III</h4>
                                        <p class="text-[10px] text-[#556075] font-mono mt-0.5">12–15 Jul 2026  •  Kirim ke Alamat</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] text-[#556075] font-mono">1 unit × 3 hari</p>
                                        <p class="text-xs font-black text-white mt-0.5">Rp 1.065.000</p>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center border-t border-[#1a1f29] pt-4 mt-4">
                                    <div class="text-[11px] text-[#556075]">Total Pesanan: <span class="font-extrabold text-white ml-1 font-mono">Rp 1.065.000</span></div>
                                    <div class="flex gap-2 text-[11px] font-bold">
                                        <button class="bg-[#1a1f29] border border-[#242b38] text-white px-4 py-2 rounded-lg hover:bg-[#202531] transition">Batalkan Pesanan</button>
                                        <button class="bg-[#e49322] text-black px-4 py-2 rounded-lg hover:bg-[#c97e1b] transition">Bayar Sekarang</button>
                                    </div>
                                </div>
                            </div>

                            <!-- ITEM 2: Dikemas (PlayStation 5) -->
                            <div class="order-card bg-[#13161e] border border-[#1a1f29] rounded-xl p-5" data-status="processing">
                                <div class="flex justify-between items-center border-b border-[#1a1f29] pb-3 mb-4 text-[11px]">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 text-[#556075]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                        <span class="font-bold text-white uppercase tracking-wide">GADGETRENT Official</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="font-mono text-[#556075]">INV-20260710-002</span>
                                        <span class="bg-[#3b82f6]/10 text-[#60a5fa] text-[10px] font-bold font-mono px-2 py-0.5 rounded-md flex items-center gap-1.5">
                                            <span class="h-1.5 w-1.5 rounded-full bg-[#3b82f6]"></span>Dikemas
                                        </span>
                                    </div>
                                </div>
                                <div class="flex gap-4 items-start">
                                    <div class="h-14 w-14 bg-[#1a1f29] border border-[#242b38] rounded-lg flex items-center justify-center text-[#556075]">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 009 11V7a4 4 0 00-8 0v4c0 2.454.636 4.76 1.753 6.76l.053.09m15.548 0L17 17.5m3.441 2.04C18.657 17.799 17.647 14.517 17 11V7a4 4 0 00-8 0v4c0 2.454.636 4.76 1.752 6.76l.053.09M12 3v18"></path></svg>
                                    </div>
                                    <div class="flex-grow">
                                        <h4 class="text-xs font-extrabold text-white">PlayStation 5</h4>
                                        <p class="text-[10px] text-[#556075] font-mono mt-0.5">10–12 Jul 2026  •  Ambil di Hub Dago</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] text-[#556075] font-mono">1 unit × 2 hari</p>
                                        <p class="text-xs font-black text-white mt-0.5">Rp 315.000</p>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center border-t border-[#1a1f29] pt-4 mt-4">
                                    <div class="text-[11px] text-[#556075]">Total Pesanan: <span class="font-extrabold text-white ml-1 font-mono">Rp 315.000</span></div>
                                    <div class="flex gap-2 text-[11px] font-bold">
                                        <button class="bg-[#1a1f29] border border-[#242b38] text-white px-4 py-2 rounded-lg hover:bg-[#202531] transition">Hubungi Penyewa</button>
                                    </div>
                                </div>
                            </div>

                            <!-- ITEM 3: Dikirim / Sedang Disewa (Canon EOS R6 Mark II) -->
                            <div class="order-card bg-[#13161e] border border-[#1a1f29] rounded-xl p-5" data-status="shipping">
                                <div class="flex justify-between items-center border-b border-[#1a1f29] pb-3 mb-4 text-[11px]">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 text-[#556075]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                        <span class="font-bold text-white uppercase tracking-wide">GADGETRENT Official</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="font-mono text-[#556075]">INV-20260703-001</span>
                                        <span class="bg-[#e49322]/10 text-[#e49322] text-[10px] font-bold font-mono px-2 py-0.5 rounded-md flex items-center gap-1.5">
                                            <span class="h-1.5 w-1.5 rounded-full bg-[#e49322]"></span>Sedang Disewa
                                        </span>
                                    </div>
                                </div>
                                <div class="flex gap-4 items-start">
                                    <div class="h-14 w-14 bg-[#1a1f29] border border-[#242b38] rounded-lg flex items-center justify-center text-[#556075]">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                                    </div>
                                    <div class="flex-grow">
                                        <h4 class="text-xs font-extrabold text-white">Canon EOS R6 Mark II</h4>
                                        <p class="text-[10px] text-[#556075] font-mono mt-0.5">03–06 Jul 2026  •  ongoing</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] text-[#556075] font-mono">1 unit × 3 hari</p>
                                        <p class="text-xs font-black text-white mt-0.5">Rp 1.200.000</p>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center border-t border-[#1a1f29] pt-4 mt-4">
                                    <div class="text-[11px] text-[#556075]">Total Pesanan: <span class="font-extrabold text-white ml-1 font-mono">Rp 1.200.000</span></div>
                                    <div class="flex gap-2 text-[11px] font-bold">
                                        <button class="bg-[#1a1f29] border border-[#242b38] text-white px-4 py-2 rounded-lg hover:bg-[#202531] transition">Lacak Pesanan</button>
                                    </div>
                                </div>
                            </div>

                            <!-- ITEM 4: Selesai (MacBook Air M2) -->
                            <div class="order-card bg-[#13161e] border border-[#1a1f29] rounded-xl p-5" data-status="completed">
                                <div class="flex justify-between items-center border-b border-[#1a1f29] pb-3 mb-4 text-[11px]">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 text-[#556075]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                        <span class="font-bold text-white uppercase tracking-wide">GADGETRENT Official</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="font-mono text-[#556075]">INV-20260625-003</span>
                                        <span class="bg-[#10b981]/10 text-[#34d399] text-[10px] font-bold font-mono px-2 py-0.5 rounded-md flex items-center gap-1.5">
                                            <span class="h-1.5 w-1.5 rounded-full bg-[#10b981]"></span>Selesai
                                        </span>
                                    </div>
                                </div>
                                <div class="flex gap-4 items-start">
                                    <div class="h-14 w-14 bg-[#1a1f29] border border-[#242b38] rounded-lg flex items-center justify-center text-[#556075]">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 21h6l-.75-4M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div class="flex-grow">
                                        <h4 class="text-xs font-extrabold text-white">MacBook Air M2</h4>
                                        <p class="text-[10px] text-[#556075] font-mono mt-0.5">20–25 Jun 2026  •  completed</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] text-[#556075] font-mono">1 unit × 5 hari</p>
                                        <p class="text-xs font-black text-white mt-0.5">Rp 1.250.000</p>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center border-t border-[#1a1f29] pt-4 mt-4">
                                    <div class="text-[11px] text-[#556075]">Total Pesanan: <span class="font-extrabold text-white ml-1 font-mono">Rp 1.250.000</span></div>
                                    <div class="flex gap-2 text-[11px] font-bold">
                                        <button class="bg-[#1a1f29] border border-[#242b38] text-white px-4 py-2 rounded-lg hover:bg-[#202531] transition">Ajukan Komplain</button>
                                        <button class="bg-[#1a1f29] border border-[#242b38] text-white px-4 py-2 rounded-lg hover:bg-[#202531] transition">Beri Penilaian</button>
                                        <button class="bg-[#e49322] text-black px-4 py-2 rounded-lg hover:bg-[#c97e1b] transition">Sewa Lagi</button>
                                    </div>
                                </div>
                            </div>

                            <!-- ITEM 5: Dibatalkan (Nintendo Switch OLED) -->
                            <div class="order-card bg-[#13161e] border border-[#1a1f29] rounded-xl p-5" data-status="cancelled">
                                <div class="flex justify-between items-center border-b border-[#1a1f29] pb-3 mb-4 text-[11px]">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 text-[#556075]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                        <span class="font-bold text-white uppercase tracking-wide">GADGETRENT Official</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="font-mono text-[#556075]">INV-20260618-011</span>
                                        <span class="bg-[#ef4444]/10 text-[#f87171] text-[10px] font-bold font-mono px-2 py-0.5 rounded-md flex items-center gap-1.5">
                                            <span class="h-1.5 w-1.5 rounded-full bg-[#ef4444]"></span>Dibatalkan
                                        </span>
                                    </div>
                                </div>
                                <div class="flex gap-4 items-start">
                                    <div class="h-14 w-14 bg-[#1a1f29] border border-[#242b38] rounded-lg flex items-center justify-center text-[#556075]">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.907c.961 0 1.36 1.243.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                                    </div>
                                    <div class="flex-grow">
                                        <h4 class="text-xs font-extrabold text-white">Nintendo Switch OLED</h4>
                                        <p class="text-[10px] text-[#556075] font-mono mt-0.5">18 Jun 2026  •  dibatalkan oleh sistem</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] text-[#556075] font-mono">1 unit × 2 hari</p>
                                        <p class="text-xs font-black text-white mt-0.5">Rp 200.000</p>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center border-t border-[#1a1f29] pt-4 mt-4">
                                    <div class="text-[11px] text-[#556075]">Alasan: <span class="font-extrabold text-white ml-1">Pembayaran tidak diselesaikan</span></div>
                                    <div class="flex gap-2 text-[11px] font-bold">
                                        <button class="bg-[#e49322] text-black px-4 py-2 rounded-lg hover:bg-[#c97e1b] transition">Pesan Lagi</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                @endif

            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-[#0c0d12] pt-16 pb-8 px-6 md:px-12 border-t border-[#1a1f29] mt-auto">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <span class="flex h-3 w-3 rotate-45 items-center justify-center rounded-sm bg-[#e49322]"></span>
                    <span class="text-xs font-black tracking-wider text-white uppercase">GADGETRENT</span>
                </div>
                <p class="text-[11px] text-[#556075] leading-relaxed max-w-xs">
                    Sewa kamera, laptop, dan konsol game harian dengan proses klaim seperti tiket — tinggal ambil, pakai, kembalikan.
                </p>
            </div>
            <div>
                <h3 class="text-[9px] font-bold text-[#475166] uppercase tracking-wider mb-3">Navigasi</h3>
                <ul class="space-y-2 text-[11px]">
                    <li><a href="/" class="hover:text-[#e49322] transition">Home</a></li>
                    <li><a href="#" class="hover:text-[#e49322] transition">Katalog</a></li>
                    <li><a href="#" class="hover:text-[#e49322] transition">Blog</a></li>
                    <li><a href="#" class="hover:text-[#e49322] transition">Tentang Kami</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-[9px] font-bold text-[#475166] uppercase tracking-wider mb-3">Bantuan</h3>
                <ul class="space-y-2 text-[11px]">
                    <li><a href="#" class="hover:text-[#e49322] transition">Informasi Customer</a></li>
                    <li><a href="#" class="hover:text-[#e49322] transition">Checkout</a></li>
                    <li><a href="#" class="hover:text-[#e49322] transition">Syarat & Ketentuan</a></li>
                    <li><a href="#" class="hover:text-[#e49322] transition">Kebijakan Privasi</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-[9px] font-bold text-[#475166] uppercase tracking-wider mb-3">Kontak</h3>
                <ul class="space-y-2 text-[11px] text-[#9ca3af]">
                    <li>Jl. Kreatif No. 12, Bandung</li>
                    <li>halo@gadgetrent.id</li>
                    <li>+62 812-3456-7890</li>
                </ul>
            </div>
        </div>
        <div class="pt-6 border-t border-[#1a1f29]/40 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-[10px] text-[#475166] font-mono">&copy; {{ date('Y') }} GadgetRent. Semua hak dilindungi.</p>
        </div>
    </footer>

    <!-- CSS & JS Logic Filters (Persis Screenshot) -->
    <style>
        .bg-stripes {
            background-image: linear-gradient(45deg, #13161e 25%, #1a1e29 25%, #1a1e29 50%, #13161e 50%, #13161e 75%, #1a1e29 75%, #1a1e29 100%);
            background-size: 40px 40px;
        }
    </style>

    <script>
        function switchSubTab(status) {
            // 1. Reset class semua button tab header
            document.querySelectorAll('.subtab-btn').forEach(btn => {
                btn.classList.remove('text-[#e49322]', 'border-b-2', 'border-[#e49322]');
                btn.classList.add('text-[#9ca3af]');
            });

            // 2. Pasang styling aktif ke button yang diklik
            const activeBtn = document.getElementById('tab-' + status);
            if(activeBtn) {
                activeBtn.classList.remove('text-[#9ca3af]');
                activeBtn.classList.add('text-[#e49322]', 'border-b-2', 'border-[#e49322]');
            }

            // 3. Filter visibilitas kartu pesanan
            document.querySelectorAll('.order-card').forEach(card => {
                if (status === 'all') {
                    card.style.display = 'block';
                } else {
                    if (card.getAttribute('data-status') === status) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                }
            });
        }
    </script>
</body>
</html>
