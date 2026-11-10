@extends('layouts.public')

@section('content')
<article class="max-w-4xl mx-auto px-4 sm:px-8 py-16">
    <div class="space-y-4">
        <div class="flex items-center gap-3 text-xs text-slate-500">
            <span class="px-2.5 py-1 rounded-md bg-blue-100 text-blue-800 font-bold uppercase">{{ $announcement->category }}</span>
            <span>Dipublikasikan: {{ $announcement->published_at?->format('d F Y') }}</span>
            <span>&bull; {{ $announcement->views_count }} x dibaca</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
            {{ $announcement->title }}
        </h1>
    </div>

    @if(!empty($announcement->thumbnail) && file_exists(public_path('storage/' . $announcement->thumbnail)))
        <div class="my-8 rounded-3xl overflow-hidden shadow-md max-h-[480px]">
            <img src="{{ asset('storage/' . $announcement->thumbnail) }}" alt="{{ $announcement->title }}" class="w-full h-full object-cover">
        </div>
    @endif

    <div class="mt-8 prose prose-slate max-w-none text-slate-700 leading-relaxed space-y-4">
        {!! $announcement->content !!}
    </div>

    <div class="mt-12 pt-8 border-t border-slate-200">
        <a href="{{ route('public.announcements') }}" class="inline-flex items-center gap-2 text-xs font-bold text-primary hover:underline">
            &larr; Kembali ke Arsip Berita
        </a>
    </div>
</article>
@endsection

