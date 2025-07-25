<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
final class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => $this->faker->randomFloat(2, 0, 1000),
            'currency' => $this->faker->currencyCode(),
            'credits_purchased' => $this->faker->numberBetween(1, 10),
            'paid_at' => $this->faker->date(),
            'comments' => $this->faker->optional()->paragraph(),
            'enrollment_id' => Enrollment::factory(),
        ];
    }
}
