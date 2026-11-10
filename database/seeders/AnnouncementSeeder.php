<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $author = User::where('role', 'admin_sistem')->first() ?? User::first();

        $announcements = [
            [
                'title' => 'Pengumuman Resmi Jadwal PPDB Tahun Ajaran 2026/2027 Kabupaten Tangerang',
                'category' => 'pengumuman',
                'excerpt' => 'Dinas Pendidikan dan Diskominfo Kabupaten Tangerang resmi merilis alur dan jadwal PPDB online terintegrasi.',
                'content' => '<p>Dinas Pendidikan bersama Dinas Komunikasi dan Informatika (Diskominfo) Kabupaten Tangerang secara resmi merilis petunjuk teknis dan jadwal pelaksanaan Penerimaan Peserta Didik Baru (PPDB) Tahun Ajaran 2026/2027. Seluruh proses pendaftaran dilakukan secara transparan, akuntabel, dan bebas pungutan liar melalui sistem digital terpadu.</p><p>Jalur pendaftaran meliputi: Jalur Zonasi, Afirmasi, Perpindahan Tugas Orang Tua, serta Jalur Prestasi Akademik dan Non-Akademik.</p>',
                'thumbnail' => 'cms/announcements/ppdb-2026.webp',
                'published_at' => now()->subDays(2),
                'is_active' => true,
                'views_count' => 1420,
            ],
            [
                'title' => 'Workshop Literasi Digital & Cyber Security Bersama Diskominfo Kab. Tangerang',
                'category' => 'kegiatan',
                'excerpt' => 'Siswa jurusan Rekayasa Perangkat Lunak dan TKJ mengikuti pelatihan intensif keamanan siber.',
                'content' => '<p>Sebagai langkah konkret penguatan talenta digital daerah, Diskominfo Kabupaten Tangerang menyelenggarakan Workshop Literasi Digital dan Cyber Security Awareness. Kegiatan ini bertujuan mempersiapkan peserta didik menghadapi ancaman rekayasa sosial (social engineering), kebocoran data, dan teknik mitigasi kerentanan web modern.</p>',
                'thumbnail' => 'cms/announcements/workshop-cyber.webp',
                'published_at' => now()->subDays(5),
                'is_active' => true,
                'views_count' => 895,
            ],
            [
                'title' => 'Siswa Raih Juara 1 Lomba Keterampilan Siswa (LKS) Web Technologies Tingkat Provinsi Banten',
                'category' => 'berita',
                'excerpt' => 'Prestasi membanggakan kembali diraih kontingen sekolah dalam ajang bergengsi LKS Banten.',
                'content' => '<p>Selamat dan apresiasi setinggi-tingginya kepada ananda Muhammad Alif atas pencapaian luar biasa meraih Juara 1 pada cabang lomba Web Technologies di LKS Tingkat Provinsi Banten. Prestasi ini membuktikan dedikasi dan kualitas kurikulum berbasis industri yang diimplementasikan di sekolah.</p>',
                'thumbnail' => 'cms/announcements/juara-lks.webp',
                'published_at' => now()->subDays(10),
                'is_active' => true,
                'views_count' => 2130,
            ],
        ];

        foreach ($announcements as $item) {
            Announcement::updateOrCreate(
                ['title' => $item['title']],
                array_merge($item, [
                    'slug' => Str::slug($item['title']),
                    'author_id' => $author?->id,
                ])
            );
        }
    }
}

