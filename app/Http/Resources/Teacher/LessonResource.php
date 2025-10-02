<?php

declare(strict_types=1);

namespace App\Http\Resources\Teacher;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Lesson
 */
final class LessonResource extends JsonResource
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
            'notes' => $this->notes,
            'student_page' => $this->student_page ?? '-',
            'workbook_page' => $this->workbook_page ?? '-',
            'taught_at' => $this->taught_at,
            'course' => new CourseResource($this->whenLoaded('course')),
            'attendances' => AttendanceResource::collection($this->whenLoaded('attendances')),
        ];
    }
}
