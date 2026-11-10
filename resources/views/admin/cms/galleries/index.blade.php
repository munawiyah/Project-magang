<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Foto - CMS Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-800">
    <div class="max-w-7xl mx-auto px-4 py-8 space-y-6">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold text-blue-600 hover:underline">&larr; Kembali ke Dashboard</a>
            <h1 class="text-2xl font-extrabold text-slate-900 mt-1">Manajemen Galeri Dokumentasi</h1>
            <p class="text-xs text-slate-500">Unggah foto kegiatan belajar mengajar, sarana prasarana, dan dokumentasi dinas.</p>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-xs font-bold text-emerald-800">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h2 class="text-sm font-bold text-slate-900 border-b pb-2">Upload Foto Galeri</h2>
                <form action="{{ route('admin.cms.galleries.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Judul Foto</label>
                        <input type="text" name="title" required class="w-full px-3 py-2 border rounded-lg text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Kategori</label>
                        <select name="category" class="w-full px-3 py-2 border rounded-lg text-xs">
                            <option value="kegiatan">Kegiatan Sekolah</option>
                            <option value="sarana">Sarana & Prasarana</option>
                            <option value="prestasi">Prestasi Siswa</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Keterangan Singkat</label>
                        <textarea name="description" rows="2" class="w-full px-3 py-2 border rounded-lg text-xs"></textarea>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Pilih Foto (JPG/WebP/PNG, Max 4MB)</label>
                        <input type="file" name="image" accept="image/*" required class="w-full text-xs">
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-blue-900 hover:bg-blue-800 text-white rounded-lg text-xs font-bold transition">
                        Upload Foto
                    </button>
                </form>
            </div>

            <div class="md:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm p-4">
                <h3 class="text-sm font-bold text-slate-900 mb-4">Galeri Tersimpan</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @forelse($galleries as $g)
                        <div class="rounded-xl overflow-hidden border border-slate-100 bg-slate-50 space-y-1">
                            <div class="aspect-video bg-slate-200 overflow-hidden">
                                @if(file_exists(public_path('storage/' . $g->image_path)))
                                    <img src="{{ asset('storage/' . $g->image_path) }}" alt="{{ $g->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-xs text-slate-400">Foto</div>
                                @endif
                            </div>
                            <div class="p-2">
                                <p class="text-xs font-bold text-slate-900 truncate">{{ $g->title }}</p>
                                <span class="text-[10px] text-blue-700 uppercase font-semibold">{{ $g->category }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 col-span-3 text-center py-8">Belum ada foto galeri.</p>
                    @endforelse
                </div>
                <div class="mt-4">{{ $galleries->links() }}</div>
            </div>
        </div>
    </div>
</body>
</html>

