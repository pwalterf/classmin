<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\CreditTransactionType;
use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CreditTransaction>
 */
final class CreditTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transacted_at' => $this->faker->date(),
            'type' => $this->faker->randomElement(CreditTransactionType::cases()),
            'credits' => $this->faker->numberBetween(-10, 10),
            'balance' => $this->faker->numberBetween(0, 20),
            'description' => $this->faker->optional()->sentence(),
            'enrollment_id' => Enrollment::factory(),
        ];
    }
}
