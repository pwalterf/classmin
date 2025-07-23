<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CoursePrice>
 */
final class CoursePriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'price' => $this->faker->randomFloat(2, 0, 1000),
            'currency' => $this->faker->currencyCode(),
            'started_at' => $this->faker->date(),
            'ended_at' => null,
            'course_id' => Course::factory(),
        ];
    }
}
