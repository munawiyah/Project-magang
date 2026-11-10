<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galleries = [
            [
                'title' => 'Laboratorium Komputer & Rekayasa Perangkat Lunak',
                'category' => 'sarana',
                'description' => 'Fasilitas workstation modern untuk praktikum coding, cloud architecture, dan jaringan.',
                'image_path' => 'cms/galleries/lab-komputer.webp',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Kunjungan Edukasi Diskominfo Kab. Tangerang',
                'category' => 'kegiatan',
                'description' => 'Monitoring program digitalisasi sekolah dan interaksi langsung dengan tim Smart City Tangerang.',
                'image_path' => 'cms/galleries/kunjungan-diskominfo.webp',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Pemberian Medali Juara LKS Web Technologies 2026',
                'category' => 'prestasi',
                'description' => 'Penyerahan piala dan sertifikat penghargaan juara tingkat provinsi.',
                'image_path' => 'cms/galleries/medali-lks.webp',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Perpustakaan Digital Terintegrasi',
                'category' => 'sarana',
                'description' => 'Ruang baca ramah literasi dilengkapi katalog e-book dan jurnal akademik.',
                'image_path' => 'cms/galleries/perpustakaan.webp',
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($galleries as $gallery) {
            Gallery::updateOrCreate(
                ['title' => $gallery['title']],
                $gallery
            );
        }
    }
}

