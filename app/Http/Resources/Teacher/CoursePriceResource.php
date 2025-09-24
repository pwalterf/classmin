<?php

declare(strict_types=1);

namespace App\Http\Resources\Teacher;

use App\Models\CoursePrice;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CoursePrice
 */
final class CoursePriceResource extends JsonResource
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
            'price' => $this->price,
            'currency' => $this->currency,
            'started_at' => $this->started_at,
            'ended_at' => $this->ended_at,
            'course' => new CourseResource($this->whenLoaded('course')),
        ];
    }
}
