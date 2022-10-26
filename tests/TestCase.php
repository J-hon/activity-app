<?php

namespace Tests;

use App\Models\User;
use Faker\Factory as Faker;
use Faker\Generator;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{

    use CreatesApplication;

    protected string $baseUrl = 'api/v1';

    protected Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Faker::create();

        Artisan::call('migrate --seed');

        $this->withoutExceptionHandling();
    }

    public function authenticate(User $user): User
    {
        Sanctum::actingAs($user);
        return $user;
    }
}
