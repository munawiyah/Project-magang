<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Gallery;
use App\Models\HeroSlider;
use App\Models\SchoolStatistic;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminCmsController extends Controller
{
    /**
     * ==========================================
     * 1. SITE SETTINGS & INSTITUTION IDENTITY
     * ==========================================
     */
    public function settings(): View
    {
        $settings = SiteSetting::all()->groupBy('group');
        $sliders = HeroSlider::orderBy('order', 'asc')->get();
        $statistics = SchoolStatistic::orderBy('order', 'asc')->get();
        return view('admin.cms.settings', compact('settings', 'sliders', 'statistics'));
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'school_name' => 'required|string|max:255',
            'school_npsn' => 'nullable|string|max:50',
            'school_motto' => 'nullable|string|max:255',
            'school_address' => 'required|string',
            'school_phone' => 'nullable|string|max:30',
            'school_email' => 'nullable|email|max:100',
            'headmaster_name' => 'required|string|max:255',
            'headmaster_nip' => 'nullable|string|max:50',
            'headmaster_greeting_title' => 'nullable|string|max:255',
            'headmaster_greeting' => 'required|string',
            'vision' => 'required|string',
            'mission' => 'required|string',
            'maps_embed_url' => 'nullable|string',
            'school_logo' => 'nullable|image|mimes:jpeg,png,webp,svg|max:2048',
            'diskominfo_logo' => 'nullable|image|mimes:jpeg,png,webp,svg|max:2048',
            'headmaster_photo' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'stat_students' => 'nullable|string|max:50',
            'stat_teachers' => 'nullable|string|max:50',
            'stat_classes' => 'nullable|string|max:50',
            'stat_accreditation' => 'nullable|string|max:50',
        ]);

        // Process file uploads
        if ($request->hasFile('school_logo')) {
            $path = $request->file('school_logo')->store('cms/logos', 'public');
            SiteSetting::set('school_logo', $path, 'identity', 'image', 'Logo Sekolah');
        }

        if ($request->hasFile('diskominfo_logo')) {
            $path = $request->file('diskominfo_logo')->store('cms/logos', 'public');
            SiteSetting::set('diskominfo_logo', $path, 'identity', 'image', 'Logo Diskominfo Tangerang');
        }

        if ($request->hasFile('headmaster_photo')) {
            $path = $request->file('headmaster_photo')->store('cms/headmaster', 'public');
            SiteSetting::set('headmaster_photo', $path, 'headmaster', 'image', 'Foto Kepala Sekolah');
        }

        // Process textual settings
        $textFields = [
            'school_name' => ['identity', 'Nama Sekolah'],
            'school_npsn' => ['identity', 'NPSN'],
            'school_motto' => ['identity', 'Motto Sekolah'],
            'school_address' => ['contact', 'Alamat Sekolah'],
            'school_phone' => ['contact', 'Nomor Telepon'],
            'school_email' => ['contact', 'Email Resmi'],
            'headmaster_name' => ['headmaster', 'Nama Kepala Sekolah'],
            'headmaster_nip' => ['headmaster', 'NIP Kepala Sekolah'],
            'headmaster_greeting_title' => ['headmaster', 'Judul Sambutan'],
            'headmaster_greeting' => ['headmaster', 'Sambutan Kepala Sekolah'],
            'vision' => ['academic', 'Visi Sekolah'],
            'mission' => ['academic', 'Misi Sekolah'],
            'maps_embed_url' => ['contact', 'URL Google Maps Embed'],
        ];

        foreach ($textFields as $key => [$group, $label]) {
            if ($request->has($key)) {
                SiteSetting::set($key, $request->input($key), $group, 'text', $label);
            }
        }

        // Update statistics if present
        if ($request->filled('stat_students')) {
            SchoolStatistic::updateOrCreate(['label' => 'Total Siswa Aktif'], ['value' => $request->input('stat_students'), 'icon' => 'users', 'color' => 'blue', 'order' => 1, 'is_active' => true]);
        }
        if ($request->filled('stat_teachers')) {
            SchoolStatistic::updateOrCreate(['label' => 'Tenaga Pendidik & Tendik'], ['value' => $request->input('stat_teachers'), 'icon' => 'academic-cap', 'color' => 'emerald', 'order' => 2, 'is_active' => true]);
        }
        if ($request->filled('stat_classes')) {
            SchoolStatistic::updateOrCreate(['label' => 'Rombongan Belajar (Rombel)'], ['value' => $request->input('stat_classes'), 'icon' => 'building-library', 'color' => 'amber', 'order' => 3, 'is_active' => true]);
        }
        if ($request->filled('stat_accreditation')) {
            SchoolStatistic::updateOrCreate(['label' => 'Status Akreditasi Sekolah'], ['value' => $request->input('stat_accreditation'), 'icon' => 'award', 'color' => 'purple', 'order' => 4, 'is_active' => true]);
        }

        return redirect()->back()->with('success', 'Pengaturan situs dan profil berhasil diperbarui.');
    }

    /**
     * ==========================================
     * 2. HERO SLIDERS / BANNERS
     * ==========================================
     */
    public function sliders(): View
    {
        $sliders = HeroSlider::orderBy('order', 'asc')->get();
        return view('admin.cms.sliders.index', compact('sliders'));
    }

    public function storeSlider(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:50',
            'button_url' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,webp|max:3072',
            'order' => 'integer|min:0',
        ]);

        $imagePath = $request->file('image')->store('cms/sliders', 'public');

        HeroSlider::create([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'button_text' => $validated['button_text'] ?? null,
            'button_url' => $validated['button_url'] ?? null,
            'image_path' => $imagePath,
            'order' => $validated['order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->back()->with('success', 'Banner slider berhasil ditambahkan.');
    }

    public function destroySlider(HeroSlider $slider): RedirectResponse
    {
        if ($slider->image_path && Storage::disk('public')->exists($slider->image_path)) {
            Storage::disk('public')->delete($slider->image_path);
        }

        $slider->delete();
        return redirect()->back()->with('success', 'Banner slider berhasil dihapus.');
    }

    /**
     * ==========================================
     * 3. ANNOUNCEMENTS & NEWS
     * ==========================================
     */
    public function announcements(): View
    {
        $announcements = Announcement::with('author')->latest()->paginate(10);
        return view('admin.cms.announcements.index', compact('announcements'));
    }

    public function storeAnnouncement(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:berita,pengumuman,agenda',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'published_at' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('cms/announcements', 'public');
        }

        Announcement::create([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'content' => $validated['content'],
            'excerpt' => Str::limit(strip_tags($validated['content']), 150),
            'thumbnail' => $thumbnailPath,
            'author_id' => $request->user()->id,
            'published_at' => $validated['published_at'] ?? now(),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->back()->with('success', 'Berita/Pengumuman berhasil dipublikasikan.');
    }

    public function destroyAnnouncement(Announcement $announcement): RedirectResponse
    {
        if ($announcement->thumbnail && Storage::disk('public')->exists($announcement->thumbnail)) {
            Storage::disk('public')->delete($announcement->thumbnail);
        }

        $announcement->delete();
        return redirect()->back()->with('success', 'Berita/Pengumuman berhasil dihapus.');
    }

    /**
     * ==========================================
     * 4. GALLERIES
     * ==========================================
     */
    public function galleries(): View
    {
        $galleries = Gallery::latest()->paginate(12);
        return view('admin.cms.galleries.index', compact('galleries'));
    }

    public function storeGallery(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:50',
            'image' => 'required|image|mimes:jpeg,png,webp|max:4096',
            'description' => 'nullable|string',
        ]);

        $imagePath = $request->file('image')->store('cms/galleries', 'public');

        Gallery::create([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'description' => $validated['description'] ?? null,
            'image_path' => $imagePath,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Foto galeri berhasil ditambahkan.');
    }
}

