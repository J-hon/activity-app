<?php

namespace Tests\Feature\Authentication;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class LoginTest extends TestCase
{

    public function test_email_is_required_to_login()
    {
        $this->expectException(ValidationException::class);

        $response = $this->postJson("$this->baseUrl/auth/login", ['password' => 'password']);

        $response->assertStatus(422)
                ->assertJsonValidationErrors([
                    'email'
                ]);
    }

    public function test_password_is_required_to_login()
    {
        $this->expectException(ValidationException::class);

        $user = User::factory()->create();

        $response = $this->postJson("$this->baseUrl/auth/login", ['email' => $user->email]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors([
                'password'
            ]);
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create();

        $this->postJson("$this->baseUrl/auth/login", [
            'email'    => $user->email,
            'password' => $this->faker->password
        ])->assertUnauthorized();
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create();

        $response = $this->postJson("$this->baseUrl/auth/login", [
            'email'    => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'user',
                    'auth_token'
                ]
            ]);
    }

}
