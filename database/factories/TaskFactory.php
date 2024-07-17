<?php

namespace Database\Factories;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Uuid::uuid4(),
            'user_id' => rand(1,50),
            'title' => fake()->sentence,
            'description' => fake()->paragraph,
            'due_date' => fake()->date(),
            'status' => rand(0,1),
        ];
    }
}
