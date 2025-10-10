<?php

declare(strict_types=1);

namespace App\Http\Resources\Teacher;

use App\Models\CreditTransaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CreditTransaction
 */
final class CreditTransactionResource extends JsonResource
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
            'transacted_at' => $this->transacted_at,
            'type' => $this->type,
            'credits' => $this->credits,
            'balance' => $this->balance,
            'description' => $this->description ?? '-',
            'enrollment' => new self($this->whenLoaded('enrollment')),
        ];
    }
}
