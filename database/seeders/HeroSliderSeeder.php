<?php

namespace Database\Seeders;

use App\Models\HeroSlider;
use Illuminate\Database\Seeder;

class HeroSliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            [
                'title' => 'Portal Informasi & Pendataan Sekolah Terpadu',
                'subtitle' => 'Kolaborasi Strategis Bersama Diskominfo Kabupaten Tangerang Menuju Smart Education 5.0',
                'button_text' => 'Jelajahi Profil',
                'button_url' => '#profil',
                'image_path' => 'cms/sliders/hero-banner-1.webp',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Integrasi Data Pendidikan Akurat & Realtime',
                'subtitle' => 'Mendukung Transparansi dan Efisiensi Manajemen Tenaga Pendidik serta Peserta Didik',
                'button_text' => 'Informasi PPDB',
                'button_url' => '#berita',
                'image_path' => 'cms/sliders/hero-banner-2.webp',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Mencetak Generasi Berdaya Saing Global',
                'subtitle' => 'Didukung Laboratorium Teknologi Terpadu dan Fasilitas Pembelajaran Berstandar Industri',
                'button_text' => 'Lihat Galeri Kampus',
                'button_url' => '#galeri',
                'image_path' => 'cms/sliders/hero-banner-3.webp',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($sliders as $slider) {
            HeroSlider::updateOrCreate(
                ['title' => $slider['title']],
                $slider
            );
        }
    }
}

