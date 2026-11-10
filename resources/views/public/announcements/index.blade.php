@extends('layouts.public')

@section('content')
<section class="py-12 bg-slate-100 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-8">
        <h1 class="text-3xl font-extrabold text-slate-900">Arsip Warta & Pengumuman Sekolah</h1>
        <p class="text-sm text-slate-500 mt-2">Daftar publikasi kegiatan akademik, prestasi, dan pengumuman kedinasan.</p>
    </div>
</section>

<section class="py-12 max-w-7xl mx-auto px-4 sm:px-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse($announcements as $item)
            <article class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 flex flex-col justify-between">
                <div>
                    <div class="h-48 bg-slate-200 overflow-hidden">
                        @if(!empty($item->thumbnail) && file_exists(public_path('storage/' . $item->thumbnail)))
                            <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-slate-800 flex items-center justify-center text-white text-3xl">📰</div>
                        @endif
                    </div>
                    <div class="p-6 space-y-2">
                        <span class="text-[11px] font-bold text-primary uppercase">{{ $item->category }} &bull; {{ $item->published_at?->format('d M Y') }}</span>
                        <h2 class="text-base font-bold text-slate-900 hover:text-primary">
                            <a href="{{ route('public.announcements.show', $item->slug) }}">{{ $item->title }}</a>
                        </h2>
                        <p class="text-xs text-slate-500 line-clamp-3">{{ $item->excerpt }}</p>
                    </div>
                </div>
                <div class="p-6 pt-0 border-t border-slate-50">
                    <a href="{{ route('public.announcements.show', $item->slug) }}" class="text-xs font-bold text-primary hover:underline">Baca Selengkapnya &rarr;</a>
                </div>
            </article>
        @empty
            <div class="col-span-3 text-center py-12 text-slate-400">Belum ada berita dipublikasikan.</div>
        @endforelse
    </div>
    <div class="mt-8">{{ $announcements->links() }}</div>
</section>
@endsection

