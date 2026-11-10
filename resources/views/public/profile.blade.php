@extends('layouts.public')

@section('content')
<section class="py-16 max-w-5xl mx-auto px-4 sm:px-8 space-y-12">
    <div class="text-center space-y-2">
        <span class="text-xs font-bold text-primary uppercase">Profil Resmi Lembaga</span>
        <h1 class="text-3xl font-extrabold text-slate-900">{{ $settings['school_name'] ?? 'SMK Terpadu' }}</h1>
        <p class="text-slate-500 text-sm">NPSN: {{ $settings['school_npsn'] ?? '-' }} &bull; Binaan Diskominfo Kabupaten Tangerang</p>
    </div>

    <!-- Sambutan -->
    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm space-y-4">
        <h2 class="text-xl font-bold text-slate-900 border-b pb-2">Prakata Kepala Sekolah</h2>
        <div class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">
            {{ $settings['headmaster_greeting'] ?? 'Prakata kepala sekolah.' }}
        </div>
        <p class="font-bold text-slate-900 text-sm mt-4">{{ $settings['headmaster_name'] ?? 'Kepala Sekolah' }}</p>
    </div>

    <!-- Visi Misi -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm space-y-3">
            <h3 class="text-lg font-bold text-primary">Visi</h3>
            <p class="text-slate-600 text-sm leading-relaxed">{{ $settings['vision'] ?? '-' }}</p>
        </div>
        <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm space-y-3">
            <h3 class="text-lg font-bold text-primary">Misi</h3>
            <div class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">{{ $settings['mission'] ?? '-' }}</div>
        </div>
    </div>
</section>
@endsection

