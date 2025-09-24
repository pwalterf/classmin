<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Models\Course;
use Illuminate\Support\Facades\DB;

final readonly class UpdateCourse
{
    /**
     * Execute the action.
     *
     * @param  array<string, mixed>  $courseData
     */
    public function handle(Course $course, array $courseData): Course
    {
        return DB::transaction(function () use ($course, $courseData): Course {
            $course->fill($courseData);

            if ($course->isDirty()) {
                $course->save();
            }

            return $course;
        });
    }
}
