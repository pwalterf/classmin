<?php

declare(strict_types=1);

namespace App\Http\Resources\Teacher;

use App\Http\Resources\TeacherResource;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Course
 */
final class CourseResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description ?? '-',
            'started_at' => $this->started_at,
            'status' => $this->status,
            'schedule' => $this->schedule ?? '-',
            'teacher' => new TeacherResource($this->whenLoaded('teacher')),
            'enrollments' => EnrollmentResource::collection($this->whenLoaded('enrollments')),
            'prices' => CoursePriceResource::collection($this->whenLoaded('prices')),
            'lastPrice' => new CoursePriceResource($this->whenLoaded('lastPrice')),
            'students' => StudentResource::collection($this->whenLoaded('students')),
        ];
    }
}
