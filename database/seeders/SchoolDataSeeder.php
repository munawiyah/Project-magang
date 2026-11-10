<?php

namespace Database\Seeders;

use App\Models\Major;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class SchoolDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Majors
        $rpl = Major::updateOrCreate(
            ['code' => 'RPL'],
            ['name' => 'Rekayasa Perangkat Lunak', 'description' => 'Konsentrasi pemrograman web, mobile, dan database.', 'is_active' => true]
        );

        $tkj = Major::updateOrCreate(
            ['code' => 'TKJ'],
            ['name' => 'Teknik Komputer dan Jaringan', 'description' => 'Konsentrasi infrastruktur jaringan, server, dan cybersecurity.', 'is_active' => true]
        );

        $dkv = Major::updateOrCreate(
            ['code' => 'DKV'],
            ['name' => 'Desain Komunikasi Visual', 'description' => 'Konsentrasi desain grafis, animasi multimedia, dan video editing.', 'is_active' => true]
        );

        // 2. Teachers
        $teacher1 = Teacher::updateOrCreate(
            ['nip' => '19810815 200501 1 003'],
            [
                'name' => 'Budi Santoso, S.Kom., M.T.',
                'gender' => 'L',
                'email' => 'budi.santoso@sekolah.sch.id',
                'phone' => '081288991122',
                'subject_specialty' => 'Pemrograman Web & Basis Data',
                'education_level' => 'S2',
                'status' => 'PNS',
                'is_active' => true,
            ]
        );

        $teacher2 = Teacher::updateOrCreate(
            ['nip' => '19850322 200804 2 004'],
            [
                'name' => 'Siti Nurhaliza, M.Pd.',
                'gender' => 'P',
                'email' => 'siti.nurhaliza@sekolah.sch.id',
                'phone' => '081399887766',
                'subject_specialty' => 'Bahasa Indonesia & Literasi',
                'education_level' => 'S2',
                'status' => 'PNS',
                'is_active' => true,
            ]
        );

        $teacher3 = Teacher::updateOrCreate(
            ['nip' => '19920110 202012 1 005'],
            [
                'name' => 'Reza Pratama, S.Pd.',
                'gender' => 'L',
                'email' => 'reza.pratama@sekolah.sch.id',
                'phone' => '085711223344',
                'subject_specialty' => 'Matematika Terapan',
                'education_level' => 'S1',
                'status' => 'P3K',
                'is_active' => true,
            ]
        );

        // 3. Classes
        $class1 = SchoolClass::updateOrCreate(
            ['name' => 'X RPL 1'],
            [
                'grade_level' => 10,
                'major_id' => $rpl->id,
                'homeroom_teacher_id' => $teacher1->id,
                'academic_year' => '2025/2026',
                'capacity' => 36,
                'is_active' => true,
            ]
        );

        $class2 = SchoolClass::updateOrCreate(
            ['name' => 'XI TKJ 1'],
            [
                'grade_level' => 11,
                'major_id' => $tkj->id,
                'homeroom_teacher_id' => $teacher3->id,
                'academic_year' => '2025/2026',
                'capacity' => 36,
                'is_active' => true,
            ]
        );

        // 4. Students
        $students = [
            [
                'nisn' => '0061234561',
                'nis' => '20251001',
                'name' => 'Ahmad Rizky Pratama',
                'gender' => 'L',
                'birth_place' => 'Tangerang',
                'birth_date' => '2008-04-12',
                'religion' => 'Islam',
                'phone' => '081234567890',
                'address' => 'Jl. Raya Serpong No. 12, Tangerang',
                'parent_name' => 'Suparman',
                'parent_phone' => '081298765432',
                'class_id' => $class1->id,
                'status' => 'Aktif',
            ],
            [
                'nisn' => '0061234562',
                'nis' => '20251002',
                'name' => 'Anisa Rahmawati Putri',
                'gender' => 'P',
                'birth_place' => 'Tangerang',
                'birth_date' => '2008-08-20',
                'religion' => 'Islam',
                'phone' => '081234567891',
                'address' => 'Perum Tigaraksa Permai Blok B3 No. 4',
                'parent_name' => 'Hartono',
                'parent_phone' => '081387654321',
                'class_id' => $class1->id,
                'status' => 'Aktif',
            ],
            [
                'nisn' => '0059876541',
                'nis' => '20241015',
                'name' => 'Bintang Bagaskara',
                'gender' => 'L',
                'birth_place' => 'Jakarta',
                'birth_date' => '2007-02-14',
                'religion' => 'Islam',
                'phone' => '081908765432',
                'address' => 'Jl. Pemda Tigaraksa No. 88, Tangerang',
                'parent_name' => 'Gunawan',
                'parent_phone' => '081211223344',
                'class_id' => $class2->id,
                'status' => 'Aktif',
            ],
        ];

        foreach ($students as $student) {
            Student::updateOrCreate(
                ['nisn' => $student['nisn']],
                $student
            );
        }
    }
}

