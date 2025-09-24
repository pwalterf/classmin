<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Models\Course;
use Illuminate\Support\Facades\DB;

final readonly class CreateCourse
{
    /**
     * CreateCourse constructor.
     */
    public function __construct(
        private CreateCoursePrice $createCoursePrice,
        private SyncCourseEnrollments $syncCourseEnrollments,
    ) {}

    /**
     * Execute the action.
     *
     * @param  array<string, mixed>  $courseData
     */
    public function handle(array $courseData): Course
    {
        return DB::transaction(function () use ($courseData) {
            $course = Course::create([
                'title' => $courseData['title'],
                'description' => $courseData['description'] ?? null,
                'started_at' => $courseData['started_at'],
                'status' => $courseData['status'],
                'schedule' => $courseData['schedule'] ?? null,
                'teacher_id' => auth()->user()->teacher->id,
            ]);

            $this->createCoursePrice->handle($courseData, $course);
            $this->syncCourseEnrollments->handle($courseData['enrollments'] ?? [], $course);

            return $course;
        });
    }
}
