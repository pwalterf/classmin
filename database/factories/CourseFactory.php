<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\CourseStatuses;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
final class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->sentence(),
            'description' => $this->faker->paragraph(),
            'started_at' => $this->faker->date(),
            'status' => $this->faker->randomElement(CourseStatuses::getStatuses()),
        ];
    }
}
