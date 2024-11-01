<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function a_user_can_register(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ], ['X-CSRF-Token' => csrf_token()]);

        $this->assertCount(1, User::all());
        $this->assertEquals('john@example.com', User::first()->email);
        $response->assertRedirect('/login');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_requires_a_name(): void
    {
        $response = $this->post(route('register'), [
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('name');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_requires_an_email(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_requires_a_valid_email(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'invalid-email',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_requires_a_password_confirmation(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'wrong-confirmation',
        ]);

        $response->assertSessionHasErrors('password');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_requires_unique_email(): void
    {
        User::create([
            'name' => 'Jane Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
    }
}
