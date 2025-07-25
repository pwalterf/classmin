<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\AttendanceStatuses;
use App\Models\Enrollment;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
final class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => $this->faker->randomElement(AttendanceStatuses::getStatuses()),
            'notes' => $this->faker->text(),
            'registered_at' => $this->faker->date(),
            'lesson_id' => Lesson::factory(),
            'enrollment_id' => Enrollment::factory(),
        ];
    }
}
