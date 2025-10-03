<?php

declare(strict_types=1);

namespace App\Http\Resources\Teacher;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Enrollment
 */
final class EnrollmentResource extends JsonResource
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
            'status' => $this->status,
            'enrolled_at' => $this->enrolled_at,
            'credits' => $this->credits,
            'discount_pct' => $this->discount_pct,
            'course' => new CourseResource($this->whenLoaded('course')),
            'student' => new StudentResource($this->whenLoaded('student')),
            'payments' => PaymentResource::collection($this->whenLoaded('payments')),
        ];
    }
}
