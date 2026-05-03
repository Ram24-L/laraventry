<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    // ── Guest access ──────────────────────────────────────────────────────

    public function test_guest_is_redirected_from_dashboard_to_login(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_login_page_is_accessible_to_guests(): void
    {
        $response = $this->get(route('login'));

        $response->assertOk();
        $response->assertViewIs('auth.login');
    }

    // ── Authenticated user cannot see login page ──────────────────────────

    public function test_authenticated_user_is_redirected_away_from_login(): void
    {
        $user = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($user)->get(route('login'));

        $response->assertRedirect(route('dashboard'));
    }

    // ── Login logic ───────────────────────────────────────────────────────

    public function test_user_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create([
            'email'    => 'admin@test.com',
            'password' => bcrypt('secret123'),
            'role'     => 'admin',
        ]);

        $response = $this->post(route('login.attempt'), [
            'email'    => 'admin@test.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_wrong_password(): void
    {
        User::factory()->create([
            'email'    => 'admin@test.com',
            'password' => bcrypt('correct-password'),
            'role'     => 'admin',
        ]);

        $response = $this->post(route('login.attempt'), [
            'email'    => 'admin@test.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_cannot_login_with_nonexistent_email(): void
    {
        $response = $this->post(route('login.attempt'), [
            'email'    => 'nobody@test.com',
            'password' => 'anypassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_requires_email(): void
    {
        $response = $this->post(route('login.attempt'), [
            'email'    => '',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_login_requires_password(): void
    {
        $response = $this->post(route('login.attempt'), [
            'email'    => 'admin@test.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_login_requires_valid_email_format(): void
    {
        $response = $this->post(route('login.attempt'), [
            'email'    => 'not-an-email',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
    }

    // ── Logout ───────────────────────────────────────────────────────────

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($user)->post(route('logout'));

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_guest_cannot_access_logout(): void
    {
        // POST /logout without auth should redirect to login
        $response = $this->post(route('logout'));

        $response->assertRedirect(route('login'));
    }

    // ── Session persists when already logged in ───────────────────────────

    public function test_authenticated_user_can_access_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
    }
}
