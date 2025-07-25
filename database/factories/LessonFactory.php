<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
final class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'notes' => $this->faker->text(),
            'student_page' => $this->faker->optional()->word(),
            'workbook_page' => $this->faker->optional()->word(),
            'taught_at' => $this->faker->date(),
            'course_id' => Course::factory(),
        ];
    }
}
