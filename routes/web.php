<?php

use App\Http\Controllers\Admin\AdminCmsController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDataController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Public\LandingPageController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem Informasi & Pendataan Sekolah Terpadu
| Diskominfo Kabupaten Tangerang
|--------------------------------------------------------------------------
*/

// =========================================================================
// 1. PUBLIC ROUTES (Akses Terbuka Tanpa Login - Frontend Lead / Wiwy)
// =========================================================================
Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::get('/profil-sekolah', [LandingPageController::class, 'profile'])->name('public.profile');
Route::get('/berita', [LandingPageController::class, 'announcements'])->name('public.announcements');
Route::get('/berita/{slug}', [LandingPageController::class, 'announcementDetail'])->name('public.announcements.show');
Route::get('/galeri', [LandingPageController::class, 'gallery'])->name('public.gallery');

// =========================================================================
// 2. AUTHENTICATION ROUTES (Login Terpadu & Dual Portal)
// =========================================================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/login/admin-sistem', function () {
        return redirect()->route('login', ['role' => 'admin_sistem']);
    })->name('login.admin_sistem');
    Route::get('/login/admin-data', function () {
        return redirect()->route('login', ['role' => 'admin_data']);
    })->name('login.admin_data');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// =========================================================================
// 3. ADMIN PORTAL (Area Terproteksi Autentikasi & Multi-Role)
// =========================================================================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Unified Dashboard (Semua role yang terotentikasi)
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // ---------------------------------------------------------------------
    // A. Role: Admin Sistem (CMS & Visual Asset Manager)
    // ---------------------------------------------------------------------
    Route::middleware([CheckRole::class . ':admin_sistem,superadmin'])
        ->prefix('cms')
        ->name('cms.')
        ->group(function () {
            // Pengaturan Identitas, Sambutan, Visi-Misi, Kontak, Logo
            Route::get('/settings', [AdminCmsController::class, 'settings'])->name('settings');
            Route::post('/settings', [AdminCmsController::class, 'updateSettings'])->name('settings.update');

            // Hero Banner / Sliders
            Route::get('/sliders', [AdminCmsController::class, 'sliders'])->name('sliders.index');
            Route::post('/sliders', [AdminCmsController::class, 'storeSlider'])->name('sliders.store');
            Route::delete('/sliders/{slider}', [AdminCmsController::class, 'destroySlider'])->name('sliders.destroy');

            // Berita & Pengumuman
            Route::get('/announcements', [AdminCmsController::class, 'announcements'])->name('announcements.index');
            Route::post('/announcements', [AdminCmsController::class, 'storeAnnouncement'])->name('announcements.store');
            Route::delete('/announcements/{announcement}', [AdminCmsController::class, 'destroyAnnouncement'])->name('announcements.destroy');

            // Galeri Foto
            Route::get('/galleries', [AdminCmsController::class, 'galleries'])->name('galleries.index');
            Route::post('/galleries', [AdminCmsController::class, 'storeGallery'])->name('galleries.store');
        });

    // ---------------------------------------------------------------------
    // B. Role: Admin Data (School Data Operator)
    // ---------------------------------------------------------------------
    Route::middleware([CheckRole::class . ':admin_data,superadmin'])
        ->prefix('data')
        ->name('data.')
        ->group(function () {
            // Guru & Tenaga Pendidik
            Route::get('/teachers', [AdminDataController::class, 'teachers'])->name('teachers.index');
            Route::post('/teachers', [AdminDataController::class, 'storeTeacher'])->name('teachers.store');
            Route::delete('/teachers/{teacher}', [AdminDataController::class, 'destroyTeacher'])->name('teachers.destroy');

            // Siswa (Peserta Didik)
            Route::get('/students', [AdminDataController::class, 'students'])->name('students.index');
            Route::post('/students', [AdminDataController::class, 'storeStudent'])->name('students.store');
            Route::delete('/students/{student}', [AdminDataController::class, 'destroyStudent'])->name('students.destroy');

            // Kelas & Jurusan
            Route::get('/classes', [AdminDataController::class, 'classes'])->name('classes.index');
            Route::post('/classes', [AdminDataController::class, 'storeClass'])->name('classes.store');

            // Import & Export Data Siswa
            Route::get('/students/export', [AdminDataController::class, 'exportStudents'])->name('students.export');
            Route::get('/students/template', [AdminDataController::class, 'downloadStudentTemplate'])->name('students.template');
            Route::post('/students/import', [AdminDataController::class, 'importStudents'])->name('students.import');
        });
});

