<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthAndRoleSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);

        // Test dual role portal redirects
        $responseCms = $this->get('/login/admin-sistem');
        $responseCms->assertRedirect(route('login', ['role' => 'admin_sistem']));

        $responseData = $this->get('/login/admin-data');
        $responseData->assertRedirect(route('login', ['role' => 'admin_data']));
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::create([
            'name' => 'Operator Test',
            'email' => 'operator@tangerangkab.go.id',
            'password' => Hash::make('secret123'),
            'role' => 'admin_data',
            'is_active' => true,
        ]);

        $response = $this->post('/login', [
            'email' => 'operator@tangerangkab.go.id',
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_admin_sistem_cannot_access_school_data_operator_module(): void
    {
        $cmsAdmin = User::create([
            'name' => 'CMS Admin',
            'email' => 'cms@tangerangkab.go.id',
            'password' => Hash::make('secret123'),
            'role' => 'admin_sistem',
            'is_active' => true,
        ]);

        // Attempt accessing Admin Data module
        $response = $this->actingAs($cmsAdmin)->get('/admin/data/students');

        $response->assertStatus(403);
    }

    public function test_admin_data_cannot_access_cms_settings_module(): void
    {
        $dataAdmin = User::create([
            'name' => 'Operator Data',
            'email' => 'data@tangerangkab.go.id',
            'password' => Hash::make('secret123'),
            'role' => 'admin_data',
            'is_active' => true,
        ]);

        // Attempt accessing CMS Settings
        $response = $this->actingAs($dataAdmin)->get('/admin/cms/settings');

        $response->assertStatus(403);
    }

    public function test_superadmin_can_access_both_cms_and_data_modules(): void
    {
        $superadmin = User::create([
            'name' => 'Superadmin',
            'email' => 'super@tangerangkab.go.id',
            'password' => Hash::make('secret123'),
            'role' => 'superadmin',
            'is_active' => true,
        ]);

        // Access CMS Settings
        $this->actingAs($superadmin)->get('/admin/cms/settings')->assertStatus(200);

        // Access School Data
        $this->actingAs($superadmin)->get('/admin/data/students')->assertStatus(200);
    }
}

