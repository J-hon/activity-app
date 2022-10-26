<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title'       => $this->faker->text(20),
            'description' => $this->faker->text,
            'image'       => $this->faker->imageUrl,
            'due_date'    => $this->faker->date,
            'is_global'   => $this->faker->boolean(33)
        ];
    }
}
