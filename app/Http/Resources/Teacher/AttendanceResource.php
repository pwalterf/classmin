<?php

declare(strict_types=1);

namespace App\Http\Resources\Teacher;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Attendance
 */
final class AttendanceResource extends JsonResource
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
            'notes' => $this->notes,
            'lesson' => new LessonResource($this->whenLoaded('lesson')),
            'enrollment' => new EnrollmentResource($this->whenLoaded('enrollment')),
        ];
    }
}
