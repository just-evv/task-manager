<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseMigrations;

    public function testViewLoginForm()
    {
        $this->get('/login')
            ->assertOk()
            ->assertViewIs('auth.login');
    }

    public function testAuthentificatedUserCannotLogIn()
    {
        $user = User::factory()->createOne();

        $this->actingAs($user)
            ->get('/login')
            ->assertRedirect('/');
    }

    public function testLogIn()
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'password'),
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ])->assertRedirect('/');

        $this->assertAuthenticatedAs($user);
    }

    public function testCannotLogin()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'invalid-password',
        ]);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
