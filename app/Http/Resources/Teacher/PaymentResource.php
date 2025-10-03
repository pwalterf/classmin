<?php

declare(strict_types=1);

namespace App\Http\Resources\Teacher;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Payment
 */
final class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'credits_purchased' => $this->credits_purchased,
            'paid_at' => $this->paid_at,
            'comments' => $this->comments,
            'enrollment' => new EnrollmentResource($this->whenLoaded('enrollment')),
        ];
    }
}
