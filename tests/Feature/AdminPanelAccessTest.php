<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Force production environment for these tests
        config(['app.env' => 'production']);
    }

    public function test_admin_user_can_access_admin_panel_in_production(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'is_admin' => true,
        ]);

        $response = $this->actingAs($admin)->get('/admin');

        // Should redirect to dashboard or return 200
        $this->assertTrue(
            in_array($response->status(), [200, 302]),
            "Expected 200 or 302, got {$response->status()}"
        );

        // If redirected, follow to ensure we can access the panel
        if ($response->status() === 302) {
            $response = $this->actingAs($admin)->get($response->headers->get('Location'));
            $response->assertStatus(200);
        }
    }

    public function test_royalwaymedia_email_user_can_access_admin_panel(): void
    {
        $user = User::factory()->create([
            'email' => 'staff@royalwaymedia.com',
            'is_admin' => false,
        ]);

        $response = $this->actingAs($user)->get('/admin');

        // Should redirect to dashboard or return 200
        $this->assertTrue(
            in_array($response->status(), [200, 302]),
            "Expected 200 or 302, got {$response->status()}"
        );
    }

    public function test_non_admin_user_cannot_access_admin_panel_in_production(): void
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'is_admin' => false,
        ]);

        $response = $this->actingAs($user)->get('/admin');

        // Should get 403 Forbidden
        $response->assertStatus(403);
    }

    public function test_guest_cannot_access_admin_panel(): void
    {
        $response = $this->get('/admin');

        // Should redirect to login
        $response->assertRedirect('/admin/login');
    }
}
