<?php

declare(strict_types=1);

namespace App\Http\Resources\Teacher;

use App\Http\Resources\TeacherResource;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Student
 *
 * @property string $full_name
 */
final class StudentResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'date_of_birth' => $this->date_of_birth,
            'phone_number' => $this->phone_number ?? '-',
            'teacher' => new TeacherResource($this->whenLoaded('teacher')),
            'enrollments' => EnrollmentResource::collection($this->whenLoaded('enrollments')),
            'created_at' => $this->created_at,
        ];
    }
}
