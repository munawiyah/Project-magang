<?php

namespace Database\Seeders;

use App\Models\SchoolStatistic;
use Illuminate\Database\Seeder;

class SchoolStatisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stats = [
            [
                'label' => 'Total Siswa Aktif',
                'value' => '1.248',
                'icon' => 'users',
                'color' => 'blue',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'label' => 'Tenaga Pendidik & Tendik',
                'value' => '86 Guru',
                'icon' => 'academic-cap',
                'color' => 'emerald',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'label' => 'Rombongan Belajar (Rombel)',
                'value' => '36 Kelas',
                'icon' => 'building-library',
                'color' => 'amber',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'label' => 'Status Akreditasi Sekolah',
                'value' => 'A (Unggul)',
                'icon' => 'award',
                'color' => 'purple',
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($stats as $stat) {
            SchoolStatistic::updateOrCreate(
                ['label' => $stat['label']],
                $stat
            );
        }
    }
}

