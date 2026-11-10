<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Sistem Informasi & Pendataan Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 flex flex-col">

    <!-- Top Navigation -->
    <header class="bg-blue-950 text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-8 py-3.5 flex flex-wrap justify-between items-center gap-4">
            <div class="flex items-center space-x-3">
                <span class="w-9 h-9 rounded-xl bg-amber-400 text-blue-950 font-black flex items-center justify-center text-sm shadow">
                    TK
                </span>
                <div>
                    <h1 class="text-sm font-bold leading-tight">Sistem Informasi & Pendataan Sekolah</h1>
                    <p class="text-[11px] text-blue-300">Diskominfo Kab. Tangerang</p>
                </div>
            </div>

            <!-- Main Navigation Links -->
            <nav class="hidden md:flex items-center space-x-1 text-xs font-semibold">
                <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-lg bg-blue-900 text-white font-bold">
                    Dashboard
                </a>

                @if($user->isAdminSistem())
                    <a href="{{ route('admin.cms.settings') }}" class="px-3 py-2 rounded-lg text-blue-200 hover:text-white hover:bg-blue-900 transition flex items-center gap-1.5">
                        <span>✏️</span> Editor Halaman Utama
                    </a>
                    <a href="{{ route('admin.cms.sliders.index') }}" class="px-3 py-2 rounded-lg text-blue-200 hover:text-white hover:bg-blue-900 transition">
                        Banner Slider
                    </a>
                    <a href="{{ route('admin.cms.announcements.index') }}" class="px-3 py-2 rounded-lg text-blue-200 hover:text-white hover:bg-blue-900 transition">
                        Berita & Pengumuman
                    </a>
                    <a href="{{ route('admin.cms.galleries.index') }}" class="px-3 py-2 rounded-lg text-blue-200 hover:text-white hover:bg-blue-900 transition">
                        Galeri
                    </a>
                @endif

                @if($user->isAdminData())
                    <a href="{{ route('admin.data.students.index') }}" class="px-3 py-2 rounded-lg text-emerald-200 hover:text-white hover:bg-emerald-900 transition">
                        Data Siswa
                    </a>
                    <a href="{{ route('admin.data.teachers.index') }}" class="px-3 py-2 rounded-lg text-emerald-200 hover:text-white hover:bg-emerald-900 transition">
                        Data Guru
                    </a>
                    <a href="{{ route('admin.data.classes.index') }}" class="px-3 py-2 rounded-lg text-emerald-200 hover:text-white hover:bg-emerald-900 transition">
                        Rombel / Kelas
                    </a>
                @endif
            </nav>

            <div class="flex items-center space-x-4">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-bold">{{ $user->name }}</p>
                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-extrabold uppercase tracking-wider
                        {{ $user->role === 'admin_sistem' ? 'bg-indigo-600 text-white' : ($user->role === 'admin_data' ? 'bg-emerald-600 text-white' : 'bg-amber-500 text-slate-900') }}">
                        {{ str_replace('_', ' ', $user->role) }}
                    </span>
                </div>

                <a href="{{ route('landing') }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-white text-xs font-bold transition flex items-center gap-1">
                    <span>Web Publik</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-600/80 hover:bg-red-600 text-white text-xs font-bold transition">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-8 py-8 space-y-8 flex-grow w-full">
        <!-- 1. HERO CALLOUT UNTUK ADMIN SISTEM (EDITOR HALAMAN UTAMA) -->
        @if($user->isAdminSistem())
            <div class="bg-gradient-to-r from-blue-900 via-indigo-900 to-blue-950 rounded-3xl p-6 sm:p-8 text-white shadow-xl border border-blue-800 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden">
                <div class="space-y-3 z-10 max-w-2xl">
                    <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-amber-400 text-slate-900 uppercase tracking-wider shadow">
                        🎨 Fitur Utama Admin Sistem
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black tracking-tight">Editor Konten Halaman Utama</h2>
                    <p class="text-sm text-blue-200 leading-relaxed">
                        Anda dapat langsung mengubah seluruh teks sambutan kepala dinas/sekolah, visi-misi, banner slider, logo instansi, dan kontak publik secara realtime tanpa perlu mengubah kode pemrograman.
                    </p>
                </div>
                <div class="z-10 flex-shrink-0">
                    <a href="{{ route('admin.cms.settings') }}" class="inline-flex items-center gap-2 px-6 py-4 rounded-2xl bg-amber-400 hover:bg-amber-300 text-blue-950 font-black text-sm shadow-lg shadow-amber-400/20 transform hover:-translate-y-0.5 transition duration-200">
                        <svg class="w-5 h-5 text-blue-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Buka Editor Halaman Utama &rarr;
                    </a>
                </div>
                <div class="absolute -right-10 -bottom-10 opacity-10 text-white">
                    <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                </div>
            </div>
        @endif

        <!-- 2. QUICK METRICS OVERVIEW -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow transition">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Siswa Aktif</p>
                <p class="text-3xl font-extrabold text-blue-900 mt-2">{{ number_format($metrics['total_students']) }}</p>
                <p class="text-[11px] text-slate-500 mt-1">Terdaftar dalam rombel</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow transition">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tenaga Pendidik</p>
                <p class="text-3xl font-extrabold text-emerald-700 mt-2">{{ number_format($metrics['total_teachers']) }}</p>
                <p class="text-[11px] text-slate-500 mt-1">Guru aktif terdata</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow transition">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Rombongan Belajar</p>
                <p class="text-3xl font-extrabold text-amber-600 mt-2">{{ number_format($metrics['total_classes']) }}</p>
                <p class="text-[11px] text-slate-500 mt-1">Kelas aktif</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow transition">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Berita & Pengumuman</p>
                <p class="text-3xl font-extrabold text-indigo-700 mt-2">{{ number_format($metrics['total_announcements']) }}</p>
                <p class="text-[11px] text-slate-500 mt-1">Konten publikasi CMS</p>
            </div>
        </div>

        <!-- 3. ROLE WORKSPACE HUB (JELAS & LANGSUNG DIAKSES) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Modul CMS -->
            <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm space-y-5 flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-900 flex items-center justify-center text-2xl font-bold shadow-sm">
                            🎨
                        </div>
                        @if($user->isAdminSistem())
                            <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">Wewenang Anda (Aktif)</span>
                        @else
                            <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-500">Terkunci (Hanya Admin Sistem)</span>
                        @endif
                    </div>
                    <h3 class="text-xl font-extrabold text-slate-900">Modul CMS & Halaman Depan</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Kelola seluruh aset visual, logo instansi, teks sambutan, visi-misi, banner promosi, berita warta, dan foto galeri publik.
                    </p>
                </div>

                <div class="pt-4 border-t border-slate-100 grid grid-cols-2 gap-2.5">
                    @if($user->isAdminSistem())
                        <a href="{{ route('admin.cms.settings') }}" class="p-3 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-900 text-xs font-bold transition flex items-center gap-2">
                            <span>✏️</span> Edit Sambutan & Visi
                        </a>
                        <a href="{{ route('admin.cms.sliders.index') }}" class="p-3 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-900 text-xs font-bold transition flex items-center gap-2">
                            <span>🖼️</span> Banner Slider
                        </a>
                        <a href="{{ route('admin.cms.announcements.index') }}" class="p-3 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-900 text-xs font-bold transition flex items-center gap-2">
                            <span>📰</span> Warta & Agenda
                        </a>
                        <a href="{{ route('admin.cms.galleries.index') }}" class="p-3 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-900 text-xs font-bold transition flex items-center gap-2">
                            <span>📷</span> Galeri Foto
                        </a>
                    @else
                        <div class="col-span-2 p-3 rounded-xl bg-slate-50 text-slate-400 text-xs font-semibold text-center">
                            Modul ini khusus untuk staf Admin Sistem / Content Manager.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Modul Data Master -->
            <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm space-y-5 flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-900 flex items-center justify-center text-2xl font-bold shadow-sm">
                            📊
                        </div>
                        @if($user->isAdminData())
                            <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">Wewenang Anda (Aktif)</span>
                        @else
                            <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-500">Terkunci (Hanya Admin Data)</span>
                        @endif
                    </div>
                    <h3 class="text-xl font-extrabold text-slate-900">Modul Data Master & Akademik</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Kelola data operasional guru, siswa, rombongan belajar, wali kelas, serta impor dan ekspor data batch CSV/Excel.
                    </p>
                </div>

                <div class="pt-4 border-t border-slate-100 grid grid-cols-2 gap-2.5">
                    @if($user->isAdminData())
                        <a href="{{ route('admin.data.students.index') }}" class="p-3 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-900 text-xs font-bold transition flex items-center gap-2">
                            <span>🎓</span> Data Siswa
                        </a>
                        <a href="{{ route('admin.data.teachers.index') }}" class="p-3 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-900 text-xs font-bold transition flex items-center gap-2">
                            <span>👨‍🏫</span> Data Guru
                        </a>
                        <a href="{{ route('admin.data.classes.index') }}" class="p-3 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-900 text-xs font-bold transition flex items-center gap-2">
                            <span>🏫</span> Data Kelas
                        </a>
                        <a href="{{ route('admin.data.students.export') }}" class="p-3 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-900 text-xs font-bold transition flex items-center gap-2">
                            <span>📤</span> Export CSV
                        </a>
                    @else
                        <div class="col-span-2 p-3 rounded-xl bg-slate-50 text-slate-400 text-xs font-semibold text-center">
                            Modul ini khusus untuk staf Admin Data / Operator Sekolah.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

</body>
</html>
