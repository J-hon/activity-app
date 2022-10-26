<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\User;
use Tests\TestCase;

class ActivityTest extends TestCase
{

    public function test_user_can_create_global_activity()
    {
        User::factory(10)->create(['user_type' => 'user']);

        $payload = [
            'title'       => $this->faker->text(20),
            'description' => $this->faker->text,
            'image'       => $this->faker->imageUrl,
            'is_global'   => true
        ];

        $response = $this->postJson("$this->baseUrl/activity", $payload);
        $response->assertStatus(200);

        $this->assertDatabaseCount('activity_user', 10);
    }

    public function test_user_can_create_activity_for_user()
    {
        $user = User::factory()->create(['user_type' => 'user']);

        $payload = [
            'title'       => $this->faker->text(20),
            'description' => $this->faker->text,
            'image'       => $this->faker->imageUrl,
            'is_global'   => false
        ];

        $response = $this->postJson("$this->baseUrl/user/$user->id/activity", $payload);
        $response->assertStatus(200);

        $this->assertDatabaseHas('activities', [
            'title'       => $payload['title'],
            'description' => $payload['description'],
            'image'       => $payload['image']
        ]);

        $this->assertDatabaseHas('activity_user', ['user_id' => $user->id]);
    }

    public function test_user_can_update_global_activity()
    {
        $activity = Activity::factory()->create();

        $payload = [
            'title'       => $this->faker->text(20),
            'description' => $this->faker->text,
            'image'       => $this->faker->imageUrl
        ];

        $response = $this->putJson("$this->baseUrl/activity/$activity->id", $payload);
        $response->assertStatus(200);

        $this->assertDatabaseHas('activities', [
            'id'          => $activity->id,
            'title'       => $payload['title'],
            'description' => $payload['description'],
            'image'       => $payload['image']
        ]);
    }

    public function test_user_can_update_global_activity_for_user()
    {
        $user     = User::factory()->create(['user_type' => 'user']);
        $activity = Activity::factory()->create(['is_global' => true]);

        $user->activities()->attach($activity->id);

        $payload = [
            'title'       => $this->faker->text(20),
            'description' => $this->faker->text,
            'image'       => $this->faker->imageUrl
        ];

        $response = $this->putJson("$this->baseUrl/user/$user->id/activity/$activity->id", $payload);
        $response->assertStatus(200);

        $this->assertDatabaseHas('revisions', [
            'user_id'     => $user->id,
            'activity_id' => $activity->id,
            'title'       => $payload['title'],
            'description' => $payload['description'],
            'image'       => $payload['image']
        ]);

        $this->assertDatabaseHas('activity_user', [
            'user_id'     => $user->id,
            'activity_id' => $activity->id
        ]);
    }
}
