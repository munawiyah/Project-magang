<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\HeroSlider;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Unified Dashboard View.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $metrics = [
            'total_students' => Student::where('status', 'Aktif')->count(),
            'total_teachers' => Teacher::where('is_active', true)->count(),
            'total_classes' => SchoolClass::where('is_active', true)->count(),
            'total_announcements' => Announcement::count(),
            'active_sliders' => HeroSlider::where('is_active', true)->count(),
            'recent_students' => Student::with('schoolClass')->latest()->take(5)->get(),
            'recent_announcements' => Announcement::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('user', 'metrics'));
    }
}

