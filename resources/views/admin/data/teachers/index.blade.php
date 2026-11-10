<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Data Guru - Operator Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-800">
    <div class="max-w-7xl mx-auto px-4 py-8 space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold text-emerald-700 hover:underline">&larr; Kembali ke Dashboard</a>
                <h1 class="text-2xl font-extrabold text-slate-900 mt-1">Database Guru & Tenaga Kependidikan</h1>
                <p class="text-xs text-slate-500">Kelola informasi tenaga pendidik, keahlian mata pelajaran, dan status kepegawaian.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-xs font-bold text-emerald-800">
                ✅ {{ session('success') }}
            </div>
        @endif

        <!-- Teacher Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-600 uppercase font-bold border-b">
                        <tr>
                            <th class="px-4 py-3">NIP</th>
                            <th class="px-4 py-3">Nama Lengkap & Gelar</th>
                            <th class="px-4 py-3">L/P</th>
                            <th class="px-4 py-3">Mata Pelajaran</th>
                            <th class="px-4 py-3">Status Pegawai</th>
                            <th class="px-4 py-3">Wali Kelas</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($teachers as $t)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 font-mono font-semibold">{{ $t->nip ?? '-' }}</td>
                                <td class="px-4 py-3 font-bold text-slate-900">{{ $t->name }}</td>
                                <td class="px-4 py-3">{{ $t->gender }}</td>
                                <td class="px-4 py-3 font-semibold text-blue-900">{{ $t->subject_specialty }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800">{{ $t->status }}</span>
                                </td>
                                <td class="px-4 py-3 font-medium text-emerald-700">{{ $t->homeroomClass?->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-right">
                                    <form action="{{ route('admin.data.teachers.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Hapus data guru ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-bold">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-slate-400">Belum ada data guru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t">{{ $teachers->links() }}</div>
        </div>
    </div>
</body>
</html>

