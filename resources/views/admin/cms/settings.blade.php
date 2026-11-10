<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor Halaman Utama (CMS) - Diskominfo Kab. Tangerang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen flex flex-col">

    <!-- Top Admin Header -->
    <header class="bg-blue-950 text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3.5 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.dashboard') }}" class="w-8 h-8 rounded-lg bg-blue-900 hover:bg-blue-800 text-white flex items-center justify-center font-bold text-xs transition">
                    &larr;
                </a>
                <div>
                    <h1 class="text-sm font-bold leading-tight">Editor Konten Halaman Utama</h1>
                    <p class="text-[11px] text-blue-300">Ubah teks & gambar publik langsung tanpa koding</p>
                </div>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('landing') }}" target="_blank" class="px-3.5 py-1.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold transition flex items-center gap-1.5">
                    <span>Lihat Halaman Publik</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-8 space-y-8 flex-grow w-full">
        <!-- Notification Alert -->
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-xs font-bold text-emerald-800 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <span class="text-base">✅</span>
                    <span>{{ session('success') }}</span>
                </div>
                <a href="{{ route('landing') }}" target="_blank" class="underline text-emerald-900 hover:text-emerald-700">Lihat Hasil di Web &rarr;</a>
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-xs font-semibold text-red-700 space-y-1 shadow-sm">
                <p class="font-bold text-red-800">Terdapat kesalahan pengisian data:</p>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.cms.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- 1. IDENTITAS SEKOLAH & LOGO -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <span class="text-[11px] font-extrabold uppercase tracking-wider text-blue-700 bg-blue-50 px-2.5 py-1 rounded-md">Bagian 1</span>
                    <h2 class="text-lg font-bold text-slate-900 mt-2">Identitas Sekolah, Motto & Logo Lembaga</h2>
                    <p class="text-xs text-slate-500">Teks dan logo ini muncul di bar paling atas (header) dan footer halaman publik.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Nama Sekolah / Lembaga</label>
                        <input type="text" name="school_name" value="{{ \App\Models\SiteSetting::get('school_name') }}" required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 text-sm">
                        <p class="text-[11px] text-slate-400 mt-1">Contoh: SMK Negeri 1 Kabupaten Tangerang</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Nomor Pokok Sekolah Nasional (NPSN)</label>
                        <input type="text" name="school_npsn" value="{{ \App\Models\SiteSetting::get('school_npsn') }}"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 text-sm">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Motto Sekolah / Slogan</label>
                        <input type="text" name="school_motto" value="{{ \App\Models\SiteSetting::get('school_motto') }}"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 text-sm">
                    </div>

                    <!-- Upload Logo Sekolah -->
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                        <label class="block text-xs font-bold text-slate-800 uppercase">Upload Logo Sekolah Baru</label>
                        <p class="text-[11px] text-slate-500">Format: PNG, WebP, JPG, SVG. Maks 2MB.</p>
                        @if(\App\Models\SiteSetting::get('school_logo') && file_exists(public_path('storage/' . \App\Models\SiteSetting::get('school_logo'))))
                            <div class="flex items-center gap-3 p-2 bg-white rounded-xl border">
                                <img src="{{ asset('storage/' . \App\Models\SiteSetting::get('school_logo')) }}" alt="Logo Saat Ini" class="h-10 w-auto object-contain">
                                <span class="text-xs text-slate-600 font-semibold">Logo sekolah aktif terpasang</span>
                            </div>
                        @endif
                        <input type="file" name="school_logo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-900 file:text-white hover:file:bg-blue-800">
                    </div>

                    <!-- Upload Logo Diskominfo -->
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                        <label class="block text-xs font-bold text-slate-800 uppercase">Upload Logo Diskominfo Kab. Tangerang</label>
                        <p class="text-[11px] text-slate-500">Format: PNG, WebP, JPG, SVG. Maks 2MB.</p>
                        @if(\App\Models\SiteSetting::get('diskominfo_logo') && file_exists(public_path('storage/' . \App\Models\SiteSetting::get('diskominfo_logo'))))
                            <div class="flex items-center gap-3 p-2 bg-white rounded-xl border">
                                <img src="{{ asset('storage/' . \App\Models\SiteSetting::get('diskominfo_logo')) }}" alt="Logo Diskominfo" class="h-10 w-auto object-contain">
                                <span class="text-xs text-slate-600 font-semibold">Logo dinas aktif terpasang</span>
                            </div>
                        @endif
                        <input type="file" name="diskominfo_logo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-900 file:text-white hover:file:bg-blue-800">
                    </div>
                </div>
            </div>

            <!-- 2. SAMBUTAN KEPALA SEKOLAH -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <span class="text-[11px] font-extrabold uppercase tracking-wider text-primary bg-blue-50 px-2.5 py-1 rounded-md">Bagian 2</span>
                    <h2 class="text-lg font-bold text-slate-900 mt-2">Prakata & Sambutan Kepala Sekolah</h2>
                    <p class="text-xs text-slate-500">Teks dan foto ini tampil pada kartu sambutan utama di beranda publik.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Nama Lengkap Kepala Sekolah & Gelar</label>
                        <input type="text" name="headmaster_name" value="{{ \App\Models\SiteSetting::get('headmaster_name') }}" required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">NIP Kepala Sekolah</label>
                        <input type="text" name="headmaster_nip" value="{{ \App\Models\SiteSetting::get('headmaster_nip') }}"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 text-sm">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Judul Pokok Sambutan</label>
                        <input type="text" name="headmaster_greeting_title" value="{{ \App\Models\SiteSetting::get('headmaster_greeting_title', 'Transformasi Digital Pendidikan Terpadu') }}"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 text-sm">
                    </div>

                    <!-- Upload Foto Kepala Sekolah -->
                    <div class="md:col-span-2 p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col sm:flex-row items-center gap-6">
                        <div class="w-24 h-24 rounded-2xl overflow-hidden bg-white border border-slate-200 flex-shrink-0 shadow-sm flex items-center justify-center">
                            @if(\App\Models\SiteSetting::get('headmaster_photo') && file_exists(public_path('storage/' . \App\Models\SiteSetting::get('headmaster_photo'))))
                                <img src="{{ asset('storage/' . \App\Models\SiteSetting::get('headmaster_photo')) }}" alt="Foto Kepala Sekolah" class="w-full h-full object-cover">
                            @else
                                <span class="text-3xl text-slate-300">👨‍🏫</span>
                            @endif
                        </div>
                        <div class="space-y-2 w-full">
                            <label class="block text-xs font-bold text-slate-800 uppercase">Ganti / Upload Foto Resmi Kepala Sekolah</label>
                            <p class="text-[11px] text-slate-500">Pilih foto formal resolusi jernih (Format: JPG/PNG/WebP, Maks 2MB). Foto akan langsung tampil di kartu sambutan depan.</p>
                            <input type="file" name="headmaster_photo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-900 file:text-white hover:file:bg-blue-800">
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Naskah Teks Sambutan Lengkap</label>
                        <textarea name="headmaster_greeting" rows="6" required
                                  class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 text-sm leading-relaxed">{{ \App\Models\SiteSetting::get('headmaster_greeting') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- 3. VISI & MISI LEMBAGA -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <span class="text-[11px] font-extrabold uppercase tracking-wider text-indigo-700 bg-indigo-50 px-2.5 py-1 rounded-md">Bagian 3</span>
                    <h2 class="text-lg font-bold text-slate-900 mt-2">Visi & Misi Lembaga</h2>
                    <p class="text-xs text-slate-500">Pernyataan visi dan poin misi sekolah pada blok edukasi beranda.</p>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Teks Visi Sekolah</label>
                        <textarea name="vision" rows="3" required
                                  class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 text-sm leading-relaxed">{{ \App\Models\SiteSetting::get('vision') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Poin Misi Sekolah (Pisahkan per baris)</label>
                        <textarea name="mission" rows="5" required
                                  class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 text-sm leading-relaxed">{{ \App\Models\SiteSetting::get('mission') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- 4. STATISTIK CEPAT (QUICK STATS COUNTER) -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <span class="text-[11px] font-extrabold uppercase tracking-wider text-amber-700 bg-amber-50 px-2.5 py-1 rounded-md">Bagian 4</span>
                    <h2 class="text-lg font-bold text-slate-900 mt-2">4 Counter Angka Statistik Halaman Depan</h2>
                    <p class="text-xs text-slate-500">Angka pencapaian yang tampil di bar mengambang beranda.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Total Siswa Aktif</label>
                        <input type="text" name="stat_students" value="{{ \App\Models\SchoolStatistic::where('label', 'Total Siswa Aktif')->value('value') ?? '1.248' }}"
                               class="w-full px-3 py-2 rounded-xl border border-slate-200 text-sm font-bold text-blue-900">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Guru & Tendik</label>
                        <input type="text" name="stat_teachers" value="{{ \App\Models\SchoolStatistic::where('label', 'Tenaga Pendidik & Tendik')->value('value') ?? '86 Guru' }}"
                               class="w-full px-3 py-2 rounded-xl border border-slate-200 text-sm font-bold text-emerald-700">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Rombel (Kelas)</label>
                        <input type="text" name="stat_classes" value="{{ \App\Models\SchoolStatistic::where('label', 'Rombongan Belajar (Rombel)')->value('value') ?? '36 Kelas' }}"
                               class="w-full px-3 py-2 rounded-xl border border-slate-200 text-sm font-bold text-amber-600">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Status Akreditasi</label>
                        <input type="text" name="stat_accreditation" value="{{ \App\Models\SchoolStatistic::where('label', 'Status Akreditasi Sekolah')->value('value') ?? 'A (Unggul)' }}"
                               class="w-full px-3 py-2 rounded-xl border border-slate-200 text-sm font-bold text-purple-700">
                    </div>
                </div>
            </div>

            <!-- 5. ALAMAT, KONTAK & GOOGLE MAPS -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-700 bg-slate-100 px-2.5 py-1 rounded-md">Bagian 5</span>
                    <h2 class="text-lg font-bold text-slate-900 mt-2">Informasi Alamat, Kontak & Lokasi Peta</h2>
                    <p class="text-xs text-slate-500">Informasi ini tampil pada footer dan seksi kontak website.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Alamat Lengkap Sekolah / Instansi</label>
                        <textarea name="school_address" rows="2" required
                                  class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 text-sm">{{ \App\Models\SiteSetting::get('school_address') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Nomor Telepon / WhatsApp Resmi</label>
                        <input type="text" name="school_phone" value="{{ \App\Models\SiteSetting::get('school_phone') }}"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Alamat Email Resmi</label>
                        <input type="email" name="school_email" value="{{ \App\Models\SiteSetting::get('school_email') }}"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 text-sm">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">URL Google Maps Embed</label>
                        <input type="text" name="maps_embed_url" value="{{ \App\Models\SiteSetting::get('maps_embed_url') }}"
                               placeholder="https://www.google.com/maps/embed?..."
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 text-xs font-mono">
                    </div>
                </div>
            </div>

            <!-- STICKY ACTION BUTTON BAR -->
            <div class="sticky bottom-4 z-40 bg-white/95 backdrop-blur-md p-4 rounded-2xl border border-slate-200 shadow-xl flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="text-xs text-slate-500">
                    💡 Perubahan yang Anda simpan akan langsung terlihat pada halaman utama tanpa reload server.
                </div>
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <a href="{{ route('admin.dashboard') }}" class="px-5 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition text-center w-full sm:w-auto">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-3 rounded-xl bg-blue-900 hover:bg-blue-800 text-white text-xs font-extrabold uppercase tracking-wider shadow-lg shadow-blue-900/20 transition text-center w-full sm:w-auto">
                        💾 Simpan Seluruh Perubahan
                    </button>
                </div>
            </div>
        </form>
    </main>

</body>
</html>
