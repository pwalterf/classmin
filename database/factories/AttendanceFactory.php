<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\AttendanceStatus;
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
            'status' => $this->faker->randomElement(AttendanceStatus::cases()),
            'notes' => $this->faker->text(),
            'registered_at' => $this->faker->date(),
            'lesson_id' => Lesson::factory(),
            'enrollment_id' => Enrollment::factory(),
        ];
    }
}
