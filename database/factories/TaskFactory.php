<?php

namespace Database\Factories;

use App\Models\{TaskStatus, User};
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
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->text(255),
            'status_id' => TaskStatus::factory(),
            'created_by_id' => User::factory(),
            'assigned_to_id' => User::factory()
        ];
    }
}
