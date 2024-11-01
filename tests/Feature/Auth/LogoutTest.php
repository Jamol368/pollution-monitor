<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Session\Middleware\StartSession;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    #[\PHPUnit\Framework\Attributes\Test]
    public function a_user_can_logout(): void
    {
        // Enable session middleware
        $this->withMiddleware(StartSession::class);

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertRedirect('/login');

        $this->assertGuest();
    }
}
