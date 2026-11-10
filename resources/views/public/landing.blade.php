@extends('layouts.public')

@section('content')

    <!-- 1. HERO SLIDER / BANNER DINAMIS -->
    <section class="relative bg-slate-900 overflow-hidden text-white min-h-[500px] flex items-center">
        @if($heroSliders->isNotEmpty())
            @php $primarySlider = $heroSliders->first(); @endphp
            <div class="absolute inset-0 z-0">
                @if(file_exists(public_path('storage/' . $primarySlider->image_path)))
                    <img src="{{ asset('storage/' . $primarySlider->image_path) }}" alt="{{ $primarySlider->title }}" class="w-full h-full object-cover opacity-35">
                @else
                    <div class="w-full h-full bg-gradient-to-r from-blue-950 via-slate-900 to-blue-900 opacity-90"></div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-900/60 to-transparent"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-8 py-20 lg:py-28">
                <div class="max-w-3xl space-y-6">
                    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold tracking-wide uppercase bg-blue-500/20 text-blue-300 border border-blue-400/30 backdrop-blur-md">
                        Pemerintah Kabupaten Tangerang
                    </span>
                    <h2 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight text-white drop-shadow-sm">
                        {{ $primarySlider->title }}
                    </h2>
                    <p class="text-base sm:text-xl text-slate-300 leading-relaxed max-w-2xl font-light">
                        {{ $primarySlider->subtitle }}
                    </p>
                    <div class="flex flex-wrap gap-4 pt-2">
                        @if($primarySlider->button_text)
                            <a href="{{ $primarySlider->button_url ?? '#berita' }}" class="px-7 py-3.5 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-bold shadow-lg shadow-blue-600/30 transition transform hover:-translate-y-0.5">
                                {{ $primarySlider->button_text }}
                            </a>
                        @endif
                        <a href="#profil" class="px-7 py-3.5 bg-white/10 hover:bg-white/20 text-white rounded-xl font-bold backdrop-blur-md border border-white/20 transition">
                            Profil Lembaga
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- Fallback jika belum ada slider diinput di CMS -->
            <div class="max-w-7xl mx-auto px-4 sm:px-8 py-24 text-center">
                <h2 class="text-4xl font-extrabold">{{ $settings['school_name'] ?? 'Sistem Informasi Sekolah' }}</h2>
                <p class="text-slate-300 mt-4 max-w-xl mx-auto">{{ $settings['school_motto'] ?? 'Selamat datang di portal informasi resmi.' }}</p>
            </div>
        @endif
    </section>

    <!-- 2. QUICK STATS BAR DINAMIS -->
    @if($statistics->isNotEmpty())
        <section class="relative z-20 -mt-10 max-w-7xl mx-auto px-4 sm:px-8">
            <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-6 sm:p-8 grid grid-cols-2 md:grid-cols-4 gap-6 text-center divide-y md:divide-y-0 md:divide-x divide-slate-100">
                @foreach($statistics as $stat)
                    <div class="pt-4 md:pt-0">
                        <p class="text-2xl sm:text-4xl font-extrabold text-blue-900 tracking-tight">{{ $stat->value }}</p>
                        <p class="text-xs sm:text-sm font-semibold text-slate-500 mt-1 uppercase tracking-wider">{{ $stat->label }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- 3. SAMBUTAN KEPALA SEKOLAH DINAMIS -->
    <section id="sambutan" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">
            <div class="bg-white rounded-3xl p-8 sm:p-12 shadow-sm border border-slate-100 grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                <div class="lg:col-span-4 text-center">
                    <div class="w-48 h-48 sm:w-56 sm:h-56 mx-auto rounded-2xl overflow-hidden shadow-lg bg-slate-100 border-4 border-white">
                        @if(!empty($settings['headmaster_photo']) && file_exists(public_path('storage/' . $settings['headmaster_photo'])))
                            <img src="{{ asset('storage/' . $settings['headmaster_photo']) }}" alt="{{ $settings['headmaster_name'] ?? 'Kepala Sekolah' }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 text-blue-900 p-4">
                                <svg class="w-16 h-16 text-blue-700/80 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <span class="text-[10px] font-extrabold text-blue-900 uppercase tracking-wider">Foto Resmi</span>
                                <span class="text-[9px] text-slate-500">Dapat diganti di CMS</span>
                            </div>
                        @endif
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mt-4">{{ $settings['headmaster_name'] ?? 'Kepala Sekolah' }}</h3>
                    <p class="text-xs text-slate-500 font-medium">NIP. {{ $settings['headmaster_nip'] ?? '-' }}</p>
                </div>

                <div class="lg:col-span-8 space-y-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-primary bg-blue-50 px-3 py-1 rounded-md">
                        Sambutan Resmi
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-snug">
                        {{ $settings['headmaster_greeting_title'] ?? 'Transformasi Digital Pendidikan Terpadu' }}
                    </h2>
                    <div class="text-slate-600 text-sm sm:text-base leading-relaxed space-y-3 whitespace-pre-line">
                        {{ $settings['headmaster_greeting'] ?? 'Selamat datang di portal informasi resmi sekolah.' }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. VISI DAN MISI DINAMIS -->
    <section id="profil" class="py-16 bg-white border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <h2 class="text-3xl font-extrabold text-slate-900">Visi & Misi Lembaga</h2>
                <p class="text-slate-500 text-sm mt-2">Fondasi arah strategis pendidikan berkualitas di Kabupaten Tangerang</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Visi Card -->
                <div class="bg-gradient-to-br from-blue-900 to-indigo-900 text-white rounded-3xl p-8 shadow-md">
                    <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center text-xl font-bold mb-6">
                        🎯
                    </div>
                    <h3 class="text-xl font-bold mb-3">Visi Sekolah</h3>
                    <p class="text-blue-100 text-sm sm:text-base leading-relaxed font-light">
                        {{ $settings['vision'] ?? 'Menjadi institusi pendidikan kejuruan berprestasi dan berkarakter.' }}
                    </p>
                </div>

                <!-- Misi Card -->
                <div class="bg-slate-50 rounded-3xl p-8 border border-slate-200">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-primary flex items-center justify-center text-xl font-bold mb-6">
                        🚀
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Misi Sekolah</h3>
                    <div class="text-slate-600 text-sm sm:text-base leading-relaxed whitespace-pre-line">
                        {{ $settings['mission'] ?? '1. Menyelenggarakan pembelajaran berkualitas.' }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. BERITA & PENGUMUMAN DINAMIS -->
    <section id="berita" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-12 gap-4">
                <div>
                    <span class="text-xs font-bold text-primary uppercase tracking-wider">Kabar Terbaru</span>
                    <h2 class="text-3xl font-extrabold text-slate-900 mt-1">Berita & Pengumuman Terkini</h2>
                </div>
                <a href="{{ route('public.announcements') }}" class="text-sm font-bold text-primary hover:text-blue-700 flex items-center gap-1 group">
                    Lihat Semua Berita
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

            @if($latestAnnouncements->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($latestAnnouncements as $item)
                        <article class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition border border-slate-100 flex flex-col">
                            <div class="h-48 bg-slate-200 relative overflow-hidden">
                                @if(!empty($item->thumbnail) && file_exists(public_path('storage/' . $item->thumbnail)))
                                    <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-700 to-indigo-800 flex items-center justify-center text-white text-3xl font-bold">
                                        📰
                                    </div>
                                @endif
                                <span class="absolute top-3 left-3 bg-white/90 backdrop-blur-md text-slate-800 text-[11px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wider">
                                    {{ $item->category }}
                                </span>
                            </div>

                            <div class="p-6 flex-grow flex flex-col justify-between">
                                <div class="space-y-2">
                                    <span class="text-xs text-slate-400 font-medium">
                                        {{ $item->published_at ? $item->published_at->format('d M Y') : $item->created_at->format('d M Y') }}
                                    </span>
                                    <h3 class="text-base font-bold text-slate-900 line-clamp-2 hover:text-primary transition">
                                        <a href="{{ route('public.announcements.show', $item->slug) }}">
                                            {{ $item->title }}
                                        </a>
                                    </h3>
                                    <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed">
                                        {{ $item->excerpt }}
                                    </p>
                                </div>

                                <div class="pt-4 border-t border-slate-100 mt-4">
                                    <a href="{{ route('public.announcements.show', $item->slug) }}" class="text-xs font-bold text-primary hover:text-blue-700">
                                        Baca Selengkapnya &rarr;
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-2xl p-8 text-center text-slate-400">
                    Belum ada berita atau pengumuman yang dipublikasikan.
                </div>
            @endif
        </div>
    </section>

    <!-- 6. GALERI FOTO DINAMIS -->
    <section id="galeri" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="text-xs font-bold text-primary uppercase tracking-wider">Dokumentasi</span>
                <h2 class="text-3xl font-extrabold text-slate-900 mt-1">Galeri Kegiatan & Fasilitas</h2>
                <p class="text-slate-500 text-sm mt-2">Aktivitas pembelajaran, sarana prasarana, dan prestasi siswa</p>
            </div>

            @if($galleries->isNotEmpty())
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($galleries as $gallery)
                        <div class="group relative rounded-2xl overflow-hidden aspect-square bg-slate-100 shadow-sm">
                            @if(file_exists(public_path('storage/' . $gallery->image_path)))
                                <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-full bg-slate-200 flex items-center justify-center text-slate-400">
                                    📷
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                                <p class="text-xs font-semibold text-white leading-snug">{{ $gallery->title }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-8 text-center text-slate-400">
                    Belum ada foto galeri yang diunggah.
                </div>
            @endif
        </div>
    </section>

@endsection

