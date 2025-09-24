<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Models\Course;
use Illuminate\Support\Facades\DB;

final readonly class DeleteCourse
{
    /**
     * DeleteTeacher constructor.
     */
    public function __construct(
        private DeleteCoursePrice $deleteCoursePrice,
        private UnenrollStudent $unenrollStudent,
    ) {}

    /**
     * Execute the action.
     */
    public function handle(Course $course): void
    {
        DB::transaction(function () use ($course): void {
            $course->load(['prices', 'enrollments']);

            foreach ($course->prices as $price) {
                $this->deleteCoursePrice->handle($price);
            }

            foreach ($course->enrollments as $enrollment) {
                $this->unenrollStudent->handle($enrollment);
            }

            $course->delete();
        });
    }
}
