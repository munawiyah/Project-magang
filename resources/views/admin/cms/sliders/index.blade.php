<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Banner Slider - CMS Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-800">
    <div class="max-w-7xl mx-auto px-4 py-8 space-y-6">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold text-blue-600 hover:underline">&larr; Kembali ke Dashboard</a>
            <h1 class="text-2xl font-extrabold text-slate-900 mt-1">Banner & Hero Slider</h1>
            <p class="text-xs text-slate-500">Kelola gambar latar, judul promosi, dan tombol aksi pada banner utama landing page.</p>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-xs font-bold text-emerald-800">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Add Slider Form -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h2 class="text-sm font-bold text-slate-900 border-b pb-2">Tambah Banner Baru</h2>
                <form action="{{ route('admin.cms.sliders.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Judul Banner Utama</label>
                        <input type="text" name="title" required class="w-full px-3 py-2 border rounded-lg text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Subjudul / Penjelasan</label>
                        <textarea name="subtitle" rows="2" class="w-full px-3 py-2 border rounded-lg text-xs"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Teks Tombol</label>
                            <input type="text" name="button_text" placeholder="e.g. PPDB 2026" class="w-full px-3 py-2 border rounded-lg text-xs">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">URL Tombol</label>
                            <input type="text" name="button_url" placeholder="#berita" class="w-full px-3 py-2 border rounded-lg text-xs">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">File Gambar Banner (JPG/WebP, Max 3MB)</label>
                        <input type="file" name="image" accept="image/*" required class="w-full text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Urutan Prioritas</label>
                        <input type="number" name="order" value="1" class="w-full px-3 py-2 border rounded-lg text-xs">
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-blue-900 hover:bg-blue-800 text-white rounded-lg text-xs font-bold transition">
                        Upload & Publikasikan Banner
                    </button>
                </form>
            </div>

            <!-- Existing Sliders List -->
            <div class="md:col-span-2 space-y-4">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4">
                    <h3 class="text-sm font-bold text-slate-900 mb-4">Banner Slider Aktif</h3>
                    <div class="grid grid-cols-1 gap-4">
                        @forelse($sliders as $slider)
                            <div class="flex flex-col sm:flex-row gap-4 p-4 rounded-xl border border-slate-100 bg-slate-50 items-center justify-between">
                                <div class="w-full sm:w-36 h-20 bg-slate-200 rounded-lg overflow-hidden flex-shrink-0">
                                    @if(file_exists(public_path('storage/' . $slider->image_path)))
                                        <img src="{{ asset('storage/' . $slider->image_path) }}" alt="{{ $slider->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-xs text-slate-400">Gambar</div>
                                    @endif
                                </div>
                                <div class="flex-grow space-y-1">
                                    <h4 class="text-xs font-bold text-slate-900">{{ $slider->title }}</h4>
                                    <p class="text-[11px] text-slate-500 line-clamp-2">{{ $slider->subtitle }}</p>
                                    <span class="text-[10px] text-blue-700 font-semibold">Urutan: {{ $slider->order }}</span>
                                </div>
                                <div>
                                    <form action="{{ route('admin.cms.sliders.destroy', $slider->id) }}" method="POST" onsubmit="return confirm('Hapus banner ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-bold px-3 py-1.5 bg-red-50 rounded-lg">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 text-center py-8">Belum ada banner slider aktif.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

