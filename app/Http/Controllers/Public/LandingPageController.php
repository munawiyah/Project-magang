<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Gallery;
use App\Models\HeroSlider;
use App\Models\SchoolStatistic;
use App\Models\SiteSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingPageController extends Controller
{
    /**
     * Render the public landing page with fully dynamic database content.
     */
    public function index(): View
    {
        $settings = SiteSetting::getAllGrouped();
        $heroSliders = HeroSlider::active()->get();
        $latestAnnouncements = Announcement::active()->take(6)->get();
        $statistics = SchoolStatistic::active()->get();
        $galleries = Gallery::active()->take(8)->get();

        return view('public.landing', compact(
            'settings',
            'heroSliders',
            'latestAnnouncements',
            'statistics',
            'galleries'
        ));
    }

    /**
     * REST API endpoint for Frontend Lead (Wiwy) if building headless / fetch-based UI.
     */
    public function apiLanding(): JsonResponse
    {
        $settings = SiteSetting::getAllGrouped();
        $heroSliders = HeroSlider::active()->get();
        $latestAnnouncements = Announcement::active()->take(6)->get();
        $statistics = SchoolStatistic::active()->get();
        $galleries = Gallery::active()->take(8)->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'settings' => $settings,
                'hero_sliders' => $heroSliders,
                'announcements' => $latestAnnouncements,
                'statistics' => $statistics,
                'galleries' => $galleries,
            ]
        ]);
    }

    /**
     * Public news & announcement listing.
     */
    public function announcements(Request $request): View
    {
        $category = $request->query('category');
        $search = $request->query('q');

        $query = Announcement::active();

        if ($category) {
            $query->where('category', $category);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $announcements = $query->paginate(9)->withQueryString();
        $settings = SiteSetting::getAllGrouped();

        return view('public.announcements.index', compact('announcements', 'settings', 'category', 'search'));
    }

    /**
     * Single announcement detail.
     */
    public function announcementDetail(string $slug): View
    {
        $announcement = Announcement::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Increment view count safely
        $announcement->increment('views_count');

        $relatedAnnouncements = Announcement::active()
            ->where('id', '!=', $announcement->id)
            ->where('category', $announcement->category)
            ->take(3)
            ->get();

        $settings = SiteSetting::getAllGrouped();

        return view('public.announcements.show', compact('announcement', 'relatedAnnouncements', 'settings'));
    }

    /**
     * School profile & vision mission page.
     */
    public function profile(): View
    {
        $settings = SiteSetting::getAllGrouped();
        return view('public.profile', compact('settings'));
    }

    /**
     * Public photo gallery page.
     */
    public function gallery(Request $request): View
    {
        $category = $request->query('category');
        $query = Gallery::active();

        if ($category) {
            $query->where('category', $category);
        }

        $galleries = $query->paginate(12)->withQueryString();
        $settings = SiteSetting::getAllGrouped();

        return view('public.gallery', compact('galleries', 'settings', 'category'));
    }
}

