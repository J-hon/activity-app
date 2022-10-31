<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Revision;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ActivityTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->authenticate(User::factory()->create(['user_type' => User::SUPER_ADMIN]));
    }

    public function test_admin_cant_create_more_than_four_activities_each_day()
    {
        $this->expectException(ValidationException::class);

        $dueDate = $this->faker->date();

        Activity::factory(4)->create(['due_date' => $dueDate]);

        $payload = [
            'title'       => $this->faker->text(20),
            'description' => $this->faker->text,
            'image'       => $this->faker->imageUrl,
            'due_date'    => $dueDate,
            'is_global'   => true
        ];

        $response = $this->postJson("$this->baseUrl/activity", $payload);
        $response->assertStatus(422)
                ->assertJsonValidationErrors([
                    'due_date'
                ]);
    }

    public function test_user_id_is_required_to_create_single_user_activity()
    {
        $this->expectException(ValidationException::class);

        $payload = [
            'title'       => $this->faker->text(20),
            'description' => $this->faker->text,
            'image'       => $this->faker->imageUrl,
            'due_date'    => $this->faker->date,
            'is_global'   => false
        ];

        $response = $this->postJson("$this->baseUrl/activity", $payload);
        $response->assertStatus(422)
                ->assertJsonValidationErrors([
                    'user_id'
                ]);
    }

    public function test_user_can_create_global_activity()
    {
        User::factory(10)->create(['user_type' => User::USER]);

        $payload = [
            'title'       => $this->faker->text(20),
            'description' => $this->faker->text,
            'image'       => $this->faker->imageUrl,
            'due_date'    => $this->faker->date,
            'is_global'   => true
        ];

        $response = $this->postJson("$this->baseUrl/activity", $payload);
        $response->assertStatus(200);

        $this->assertDatabaseHas('activities', [
            'title'     => $payload['title'],
            'is_global' => true
        ]);
    }

    public function test_user_can_create_activity_for_user()
    {
        $user = User::factory()->create(['user_type' => User::USER]);

        $payload = [
            'title'       => $this->faker->text(20),
            'description' => $this->faker->text,
            'image'       => $this->faker->imageUrl,
            'due_date'    => $this->faker->date,
            'is_global'   => false,
            'user_id'     => $user->id
        ];

        $response = $this->postJson("$this->baseUrl/activity", $payload);
        $response->assertStatus(200);

        $this->assertDatabaseHas('revisions', [
            'user_id'     => $user->id,
            'title'       => $payload['title'],
            'description' => $payload['description'],
            'image'       => $payload['image']
        ]);
    }

    public function test_user_can_update_global_activity()
    {
        $activity = Activity::factory()->create(['is_global' => true]);
        $user     = User::factory()->create(['user_type' => User::USER]);

        Revision::factory()->create([
            'user_id'     => $user->id,
            'activity_id' => $activity->id,
            'title'       => $activity->title,
            'description' => $activity->description,
            'image'       => $activity->image
        ]);

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

        $this->assertDatabaseHas('revisions', [
            'user_id'     => $user->id,
            'activity_id' => $activity->id,
            'title'       => $payload['title'],
            'description' => $payload['description'],
            'image'       => $payload['image']
        ]);
    }

    public function test_user_can_update_global_activity_for_user()
    {
        $user1    = User::factory()->create(['user_type' => User::USER]);
        $user2    = User::factory()->create(['user_type' => User::USER]);
        $activity = Activity::factory()->create(['is_global' => true]);

        Revision::factory()->createMany([
            [
                'user_id'     => $user1->id,
                'activity_id' => $activity->id,
                'title'       => $activity->title,
                'description' => $activity->description,
                'image'       => $activity->image
            ], [
                'user_id'     => $user2->id,
                'activity_id' => $activity->id,
                'title'       => $activity->title,
                'description' => $activity->description,
                'image'       => $activity->image
            ]
        ]);

        $payload = [
            'title'       => $this->faker->text(20),
            'description' => $this->faker->text,
            'image'       => $this->faker->imageUrl
        ];

        $response = $this->putJson("$this->baseUrl/user/$user1->id/activity/$activity->id", $payload);
        $response->assertStatus(200);

        $this->assertDatabaseHas('revisions', [
            'user_id'     => $user1->id,
            'activity_id' => $activity->id,
            'title'       => $payload['title'],
            'description' => $payload['description'],
            'image'       => $payload['image']
        ]);

        $this->assertDatabaseHas('revisions', [
            'user_id'     => $user2->id,
            'activity_id' => $activity->id,
            'title'       => $activity->title,
            'description' => $activity->description,
            'image'       => $activity->image
        ]);
    }

    public function test_user_can_delete_activity()
    {
        $user1    = User::factory()->create(['user_type' => User::USER]);
        $user2    = User::factory()->create(['user_type' => User::USER]);
        $activity = Activity::factory()->create(['is_global' => true]);

        Revision::factory()->createMany([
            [
                'user_id'     => $user1->id,
                'activity_id' => $activity->id,
                'title'       => $activity->title,
                'description' => $activity->description,
                'image'       => $activity->image
            ], [
                'user_id'     => $user2->id,
                'activity_id' => $activity->id,
                'title'       => $activity->title,
                'description' => $activity->description,
                'image'       => $activity->image
            ]
        ]);

        $response = $this->deleteJson("$this->baseUrl/activity/$activity->id");
        $response->assertStatus(200);

        $this->assertDatabaseMissing('activities', [
            'id' => $activity->id
        ]);

        $this->assertDatabaseMissing('revisions', [
            'user_id' => $user1->id,
            'activity_id' => $activity->id
        ]);
    }
}
