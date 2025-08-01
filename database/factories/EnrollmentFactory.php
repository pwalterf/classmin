<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\EnrollmentStatus;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enrollment>
 */
final class EnrollmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => $this->faker->randomElement(EnrollmentStatus::cases()),
            'enrolled_at' => $this->faker->date(),
            'credits' => $this->faker->numberBetween(1, 10),
            'discount_pct' => $this->faker->optional()->numberBetween(0, 50),
            'student_id' => Student::factory(),
            'course_id' => Course::factory(),
        ];
    }
}
