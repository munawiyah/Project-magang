<?php

namespace Tests\Feature;

use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SchoolDataManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $operator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->operator = User::create([
            'name' => 'Operator Data Test',
            'email' => 'operator.test@tangerangkab.go.id',
            'password' => Hash::make('secret123'),
            'role' => 'admin_data',
            'is_active' => true,
        ]);
    }

    public function test_operator_can_view_student_list(): void
    {
        $class = SchoolClass::create([
            'name' => 'X RPL 1',
            'grade_level' => 10,
            'academic_year' => '2025/2026',
            'capacity' => 36,
        ]);

        Student::create([
            'nisn' => '0098765432',
            'name' => 'Budi Santoso',
            'gender' => 'L',
            'class_id' => $class->id,
            'status' => 'Aktif',
        ]);

        $response = $this->actingAs($this->operator)->get('/admin/data/students');

        $response->assertStatus(200);
        $response->assertSee('Budi Santoso');
        $response->assertSee('0098765432');
    }

    public function test_operator_can_export_students_csv(): void
    {
        $response = $this->actingAs($this->operator)->get('/admin/data/students/export');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');
    }

    public function test_operator_can_download_student_template(): void
    {
        $response = $this->actingAs($this->operator)->get('/admin/data/students/template');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');
    }
}

