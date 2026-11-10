<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPortalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        SiteSetting::set('school_name', 'SMK Negeri 1 Kabupaten Tangerang');
    }

    public function test_landing_page_renders_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('SMK Negeri 1 Kabupaten Tangerang');
    }

    public function test_public_api_landing_content_returns_valid_json(): void
    {
        $response = $this->getJson('/api/v1/landing-content');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'settings',
                    'hero_sliders',
                    'announcements',
                    'statistics',
                    'galleries',
                ]
            ]);
    }

    public function test_public_announcements_page_is_accessible(): void
    {
        $response = $this->get('/berita');
        $response->assertStatus(200);
    }
}

