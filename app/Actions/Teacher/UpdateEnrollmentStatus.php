<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Enums\CourseStatus;
use App\Enums\EnrollmentStatus;
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;

final readonly class UpdateEnrollmentStatus
{
    /**
     * Execute the action.
     *
     * @return Enrollment $enrollment
     */
    public function handle(Enrollment $enrollment, CourseStatus $courseStatus): Enrollment
    {
        return DB::transaction(function () use ($enrollment, $courseStatus): Enrollment {
            match ($courseStatus) {
                CourseStatus::INACTIVE, CourseStatus::HOLIDAY, CourseStatus::CANCELLED, CourseStatus::PAUSED => $enrollment->status = EnrollmentStatus::INACTIVE,
                CourseStatus::COMPLETED => $enrollment->status = EnrollmentStatus::COMPLETED,
                default => $enrollment->status = EnrollmentStatus::ACTIVE,
            };

            if ($enrollment->isDirty()) {
                $enrollment->save();
            }

            return $enrollment;
        });
    }
}
