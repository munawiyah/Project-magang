<?php

use App\Http\Controllers\Public\LandingPageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - RESTful Endpoints
| Digunakan Frontend Lead (Wiwy) untuk integrasi asynchronous/SPA jika diperlukan
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    // Public landing payload: all sliders, settings, statistics, announcements, galleries
    Route::get('/landing-content', [LandingPageController::class, 'apiLanding'])->name('api.v1.landing');
});

