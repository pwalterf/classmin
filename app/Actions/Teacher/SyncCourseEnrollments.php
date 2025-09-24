<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Models\Course;
use Illuminate\Support\Facades\DB;

final readonly class SyncCourseEnrollments
{
    /**
     * SyncCourseEnrollments constructor.
     */
    public function __construct(
        private EnrollStudent $enrollStudent,
    ) {}

    /**
     * Execute the action.
     *
     * @param  array<string, mixed>  $enrollments
     */
    public function handle(array $enrollments, Course $course): void
    {
        DB::transaction(function () use ($enrollments, $course): void {
            foreach ($enrollments as $enrollment) {
                $enrollment['course_id'] = $course->id;
                $enrollment['student_id'] = $enrollment['student']['id'];
                $this->enrollStudent->handle($enrollment);
            }
        });
    }
}
