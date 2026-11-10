<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Data Siswa - Operator Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-800">
    <div class="max-w-7xl mx-auto px-4 py-8 space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold text-emerald-700 hover:underline">&larr; Kembali ke Dashboard</a>
                <h1 class="text-2xl font-extrabold text-slate-900 mt-1">Database Siswa (Peserta Didik)</h1>
                <p class="text-xs text-slate-500">Kelola master data siswa, rombongan belajar, dan import/export CSV terintegrasi.</p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.data.students.template') }}" class="px-3 py-2 bg-slate-200 hover:bg-slate-300 rounded-lg text-xs font-bold text-slate-700 transition">
                    ⬇ Unduh Template CSV
                </a>
                <a href="{{ route('admin.data.students.export') }}" class="px-3 py-2 bg-amber-600 hover:bg-amber-700 rounded-lg text-xs font-bold text-white transition">
                    📤 Export Data Siswa
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-xs font-bold text-emerald-800">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-xs text-red-700">
                @foreach ($errors->all() as $error)
                    <p>⚠️ {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Import Form & Search Filter -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Import Card -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Import Data Siswa (CSV)</h3>
                <form action="{{ route('admin.data.students.import') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                    @csrf
                    <input type="file" name="file" accept=".csv" required class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                    <button type="submit" class="w-full py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-lg text-xs font-bold transition">
                        Mulai Import CSV
                    </button>
                </form>
            </div>

            <!-- Search & Filter Card -->
            <div class="md:col-span-2 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-center">
                <form action="{{ route('admin.data.students.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari NISN / Nama Siswa..." class="px-3 py-2 border rounded-lg text-xs">
                    <select name="class_id" class="px-3 py-2 border rounded-lg text-xs">
                        <option value="">Semua Rombel/Kelas</option>
                        @foreach($classes as $c)
                            <option value="{{ $c->id }}" {{ $classId == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 bg-blue-900 hover:bg-blue-800 text-white rounded-lg text-xs font-bold transition">
                        Filter Data
                    </button>
                </form>
            </div>
        </div>

        <!-- Student Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-600 uppercase font-bold border-b">
                        <tr>
                            <th class="px-4 py-3">NISN / NIS</th>
                            <th class="px-4 py-3">Nama Lengkap</th>
                            <th class="px-4 py-3">L/P</th>
                            <th class="px-4 py-3">Kelas</th>
                            <th class="px-4 py-3">Wali Murid</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($students as $st)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 font-mono font-semibold">{{ $st->nisn }} <span class="text-slate-400">/ {{ $st->nis ?? '-' }}</span></td>
                                <td class="px-4 py-3 font-bold text-slate-900">{{ $st->name }}</td>
                                <td class="px-4 py-3">{{ $st->gender }}</td>
                                <td class="px-4 py-3 font-semibold text-emerald-700">{{ $st->schoolClass?->name ?? 'Belum ada kelas' }}</td>
                                <td class="px-4 py-3">{{ $st->parent_name ?? '-' }} ({{ $st->parent_phone ?? '-' }})</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $st->status === 'Aktif' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">
                                        {{ $st->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <form action="{{ route('admin.data.students.destroy', $st->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-bold">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-slate-400">
                                    Tidak ada data siswa ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t">
                {{ $students->links() }}
            </div>
        </div>
    </div>
</body>
</html>

