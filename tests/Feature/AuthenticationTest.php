<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Nexora Admin',
            'email' => 'admin@nexora.test',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect();

        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'name' => 'Nexora Admin',
            'email' => 'admin@nexora.test',
        ]);
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@nexora.test',
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@nexora.test',
            'password' => 'password',
        ]);

        $response->assertRedirect();

        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@nexora.test',
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@nexora.test',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();

        $this->assertGuest();
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect();

        $this->assertGuest();
    }

    public function test_user_cannot_register_with_invalid_data(): void
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'not-an-email',
            'password' => 'password',
            'password_confirmation' => 'different-password',
        ]);

        $response->assertSessionHasErrors([
            'name',
            'email',
            'password',
        ]);

        $this->assertGuest();
    }

    public function test_user_cannot_register_with_existing_email(): void
    {
        User::factory()->create([
            'email' => 'admin@nexora.test',
        ]);

        $response = $this->post('/register', [
            'name' => 'Another Admin',
            'email' => 'admin@nexora.test',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors([
            'email',
        ]);

        $this->assertGuest();
    }

}
