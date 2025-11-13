<?php

declare(strict_types=1);

namespace App\Http\Resources\Teacher;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read \Carbon\Carbon $date
 * @property-read float $amount
 */
final class BillingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'date' => $this->date->format('F Y'),
            'amount' => $this->amount,
        ];
    }
}
