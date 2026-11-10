@extends('layouts.public')

@section('content')
<section class="py-12 bg-slate-100 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-8">
        <h1 class="text-3xl font-extrabold text-slate-900">Galeri Foto & Dokumentasi</h1>
        <p class="text-sm text-slate-500 mt-2">Kumpulan arsip foto aktivitas belajar mengajar, sarana prasarana, dan prestasi siswa.</p>
    </div>
</section>

<section class="py-12 max-w-7xl mx-auto px-4 sm:px-8">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @forelse($galleries as $g)
            <div class="rounded-2xl overflow-hidden bg-white shadow-sm border border-slate-200 group">
                <div class="aspect-square bg-slate-200 overflow-hidden">
                    @if(file_exists(public_path('storage/' . $g->image_path)))
                        <img src="{{ asset('storage/' . $g->image_path) }}" alt="{{ $g->title }}" class="w-full h-full object-cover group-hover:scale-105 transition">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-3xl">📷</div>
                    @endif
                </div>
                <div class="p-3">
                    <p class="text-xs font-bold text-slate-900">{{ $g->title }}</p>
                    <span class="text-[10px] text-blue-700 font-semibold uppercase">{{ $g->category }}</span>
                </div>
            </div>
        @empty
            <div class="col-span-4 text-center py-12 text-slate-400">Belum ada foto dalam galeri.</div>
        @endforelse
    </div>
    <div class="mt-8">{{ $galleries->links() }}</div>
</section>
@endsection

