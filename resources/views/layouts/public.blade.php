<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['school_name'] ?? 'Portal Sekolah Terpadu' }} - Diskominfo Kab. Tangerang</title>
    <meta name="description" content="{{ $settings['school_motto'] ?? 'Sistem Informasi & Pendataan Sekolah Terpadu' }}">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1E3A8A', // Diskominfo Tangerang Blue
                        secondary: '#D97706', // Tangerang Gold
                        accent: '#059669', // Emerald
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased flex flex-col min-h-screen">

    <!-- Top Bar Instansi -->
    <div class="bg-primary text-white text-xs py-2 px-4 sm:px-8 border-b border-blue-900">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Pemerintah Kabupaten Tangerang &bull; Dinas Komunikasi dan Informatika</span>
            </div>
            <div class="flex items-center space-x-3">
                <span class="hidden sm:inline text-blue-200">NPSN: {{ $settings['school_npsn'] ?? '-' }}</span>
                <span class="hidden sm:inline text-blue-400">|</span>
                <a href="{{ route('login.admin_sistem') }}" class="hover:text-amber-300 font-semibold transition flex items-center gap-1 bg-white/10 px-2.5 py-1 rounded-lg border border-white/10">
                    <svg class="w-3.5 h-3.5 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span>Login CMS</span>
                </a>
                <a href="{{ route('login.admin_data') }}" class="hover:text-emerald-300 font-semibold transition flex items-center gap-1 bg-emerald-500/20 px-2.5 py-1 rounded-lg border border-emerald-400/30">
                    <svg class="w-3.5 h-3.5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <span>Login Operator</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Navigation Header -->
    <header class="bg-white/95 backdrop-blur-md sticky top-0 z-50 shadow-sm border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-8 py-3.5 flex justify-between items-center">
            <a href="{{ route('landing') }}" class="flex items-center space-x-3 group">
                @if(!empty($settings['school_logo']) && file_exists(public_path('storage/' . $settings['school_logo'])))
                    <img src="{{ asset('storage/' . $settings['school_logo']) }}" alt="Logo" class="h-10 w-auto object-contain">
                @else
                    <div class="w-10 h-10 rounded-xl bg-blue-900 text-amber-300 flex items-center justify-center font-black text-sm shadow-sm border border-blue-800 flex-shrink-0">
                        TK
                    </div>
                @endif
                <div>
                    <h1 class="text-base font-bold text-slate-900 group-hover:text-primary transition leading-tight">
                        {{ $settings['school_name'] ?? 'SMK Terpadu Kab. Tangerang' }}
                    </h1>
                    <p class="text-xs text-slate-500 font-medium">Binaan Diskominfo Kab. Tangerang</p>
                </div>
            </a>

            <nav class="hidden md:flex items-center space-x-7 text-sm font-semibold text-slate-600">
                <a href="{{ route('landing') }}" class="hover:text-primary transition">Beranda</a>
                <a href="#profil" class="hover:text-primary transition">Profil Sekolah</a>
                <a href="#sambutan" class="hover:text-primary transition">Sambutan</a>
                <a href="#berita" class="hover:text-primary transition">Berita & Pengumuman</a>
                <a href="#galeri" class="hover:text-primary transition">Galeri</a>
                <a href="#kontak" class="hover:text-primary transition">Kontak</a>
            </nav>

            <div class="flex items-center space-x-3">
                <a href="#kontak" class="inline-flex items-center px-4 py-2 text-xs font-bold text-white bg-primary rounded-lg hover:bg-blue-800 shadow-sm transition">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </header>

    <!-- Content Slot -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer Dinamis -->
    <footer id="kontak" class="bg-slate-900 text-slate-300 pt-16 pb-8 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-8 grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-slate-800">
            <div class="md:col-span-2 space-y-4">
                <h3 class="text-lg font-bold text-white">{{ $settings['school_name'] ?? 'Sistem Informasi Sekolah' }}</h3>
                <p class="text-sm text-slate-400 leading-relaxed max-w-md">
                    {{ $settings['school_motto'] ?? 'Mewujudkan layanan pendidikan digital terpadu, terpercaya, dan transparan di Kabupaten Tangerang.' }}
                </p>
                <div class="text-xs text-slate-400 space-y-1">
                    <p class="flex items-start gap-2">
                        <span class="text-primary font-bold">📍</span>
                        <span>{{ $settings['school_address'] ?? 'Tangerang, Banten' }}</span>
                    </p>
                    <p class="flex items-center gap-2">
                        <span class="text-primary font-bold">📞</span>
                        <span>{{ $settings['school_phone'] ?? '-' }}</span>
                    </p>
                    <p class="flex items-center gap-2">
                        <span class="text-primary font-bold">✉️</span>
                        <span>{{ $settings['school_email'] ?? '-' }}</span>
                    </p>
                </div>
            </div>

            <div>
                <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Navigasi Cepat</h4>
                <ul class="text-sm space-y-2 text-slate-400">
                    <li><a href="{{ route('landing') }}" class="hover:text-white transition">Beranda</a></li>
                    <li><a href="#profil" class="hover:text-white transition">Profil & Visi Misi</a></li>
                    <li><a href="#berita" class="hover:text-white transition">Agenda & Pengumuman</a></li>
                    <li><a href="#galeri" class="hover:text-white transition">Dokumentasi Kegiatan</a></li>
                    <li><a href="{{ route('login.admin_sistem') }}" class="hover:text-amber-400 transition">Login Admin Sistem (CMS)</a></li>
                    <li><a href="{{ route('login.admin_data') }}" class="hover:text-emerald-400 transition">Login Admin Data (Operator)</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Mitra Pemerintah</h4>
                <div class="p-4 rounded-xl bg-slate-800/80 border border-slate-700/60 text-xs text-slate-300 space-y-2">
                    <p class="font-semibold text-white">Diskominfo Kab. Tangerang</p>
                    <p class="text-slate-400 text-xs leading-normal">
                        Mendukung transformasi digitalisasi data dan sistem tata kelola pendidikan daerah.
                    </p>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-8 pt-8 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500">
            <p>&copy; {{ date('Y') }} {{ $settings['school_name'] ?? 'Portal Sekolah' }} &bull; Diskominfo Kabupaten Tangerang.</p>
            <p>Developed with clean Laravel Architecture by Tim Magang Diskominfo.</p>
        </div>
    </footer>

</body>
</html>

