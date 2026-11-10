<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Berita & Pengumuman - CMS Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-800">
    <div class="max-w-7xl mx-auto px-4 py-8 space-y-6">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold text-blue-600 hover:underline">&larr; Kembali ke Dashboard</a>
            <h1 class="text-2xl font-extrabold text-slate-900 mt-1">Publikasi Berita & Agenda Sekolah</h1>
            <p class="text-xs text-slate-500">Kelola artikel warta, agenda kegiatan dinas, dan pengumuman PPDB.</p>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-xs font-bold text-emerald-800">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Add Form -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h2 class="text-sm font-bold text-slate-900 border-b pb-2">Buat Pengumuman Baru</h2>
                <form action="{{ route('admin.cms.announcements.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Judul Artikel</label>
                        <input type="text" name="title" required class="w-full px-3 py-2 border rounded-lg text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Kategori</label>
                        <select name="category" class="w-full px-3 py-2 border rounded-lg text-xs">
                            <option value="pengumuman">Pengumuman Resmi</option>
                            <option value="berita">Berita Sekolah</option>
                            <option value="agenda">Agenda Kegiatan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Thumbnail Foto</label>
                        <input type="file" name="thumbnail" accept="image/*" class="w-full text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Isi Konten Artikel</label>
                        <textarea name="content" rows="6" required class="w-full px-3 py-2 border rounded-lg text-xs"></textarea>
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-blue-900 hover:bg-blue-800 text-white rounded-lg text-xs font-bold transition">
                        Publikasikan
                    </button>
                </form>
            </div>

            <!-- List -->
            <div class="md:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-4 border-b">
                    <h3 class="text-sm font-bold text-slate-900">Daftar Konten Terpublikasi</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-600 uppercase font-bold border-b">
                            <tr>
                                <th class="px-4 py-3">Judul Berita</th>
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($announcements as $ann)
                                <tr>
                                    <td class="px-4 py-3 font-bold text-slate-900 max-w-xs truncate">{{ $ann->title }}</td>
                                    <td class="px-4 py-3 uppercase text-[10px] font-bold text-blue-700">{{ $ann->category }}</td>
                                    <td class="px-4 py-3 text-slate-500">{{ $ann->published_at?->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <form action="{{ route('admin.cms.announcements.destroy', $ann->id) }}" method="POST" onsubmit="return confirm('Hapus pengumuman ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-bold">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-slate-400">Belum ada pengumuman dibuat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t">{{ $announcements->links() }}</div>
            </div>
        </div>
    </div>
</body>
</html>

