<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kelas & Jurusan - Operator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-800">
    <div class="max-w-7xl mx-auto px-4 py-8 space-y-6">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold text-emerald-700 hover:underline">&larr; Kembali ke Dashboard</a>
            <h1 class="text-2xl font-extrabold text-slate-900 mt-1">Daftar Rombongan Belajar (Rombel) & Jurusan</h1>
            <p class="text-xs text-slate-500">Kelola kelas, penugasan wali kelas, dan kuota siswa.</p>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-xs font-bold text-emerald-800">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Add Class Form -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h2 class="text-sm font-bold text-slate-900 border-b pb-2">Tambah Rombel Baru</h2>
                <form action="{{ route('admin.data.classes.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Nama Kelas (e.g. X RPL 1)</label>
                        <input type="text" name="name" required class="w-full px-3 py-2 border rounded-lg text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Tingkat (Grade)</label>
                        <select name="grade_level" class="w-full px-3 py-2 border rounded-lg text-xs" required>
                            <option value="10">Kelas 10 (X)</option>
                            <option value="11">Kelas 11 (XI)</option>
                            <option value="12">Kelas 12 (XII)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Jurusan / Konsentrasi</label>
                        <select name="major_id" class="w-full px-3 py-2 border rounded-lg text-xs">
                            <option value="">-- Tanpa Jurusan --</option>
                            @foreach($majors as $m)
                                <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->code }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Wali Kelas</label>
                        <select name="homeroom_teacher_id" class="w-full px-3 py-2 border rounded-lg text-xs">
                            <option value="">-- Pilih Wali Kelas --</option>
                            @foreach($teachers as $t)
                                <option value="{{ $t->id }}">{{ $t->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Tahun Ajaran</label>
                        <input type="text" name="academic_year" value="2025/2026" required class="w-full px-3 py-2 border rounded-lg text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Kapasitas Maksimal</label>
                        <input type="number" name="capacity" value="36" required class="w-full px-3 py-2 border rounded-lg text-xs">
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-lg text-xs font-bold transition">
                        Simpan Kelas
                    </button>
                </form>
            </div>

            <!-- List Classes -->
            <div class="md:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-4 border-b">
                    <h3 class="text-sm font-bold text-slate-900">Daftar Kelas Aktif</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-600 uppercase font-bold border-b">
                            <tr>
                                <th class="px-4 py-3">Nama Rombel</th>
                                <th class="px-4 py-3">Jurusan</th>
                                <th class="px-4 py-3">Wali Kelas</th>
                                <th class="px-4 py-3 text-center">Jumlah Siswa</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($classes as $c)
                                <tr>
                                    <td class="px-4 py-3 font-bold text-slate-900">{{ $c->name }}</td>
                                    <td class="px-4 py-3">{{ $c->major?->name ?? '-' }}</td>
                                    <td class="px-4 py-3 text-emerald-800 font-semibold">{{ $c->homeroomTeacher?->name ?? 'Belum ditentukan' }}</td>
                                    <td class="px-4 py-3 text-center font-bold">{{ $c->students_count }} / {{ $c->capacity }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-slate-400">Belum ada data rombel.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

