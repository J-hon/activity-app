<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Revision>
 */
class RevisionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'     => function () {
                return User::factory()->create(['user_type' => 'user'])->id;
            },
            'activity_id' => function () {
                return Activity::factory()->create()->id;
            },
            'title'       => $this->faker->text(20),
            'description' => $this->faker->text,
            'image'       => $this->faker->imageUrl,
        ];
    }
}
