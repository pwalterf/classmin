<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Enums\EnrollmentStatus;
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;

final readonly class EnrollStudent
{
    /**
     * Execute the action.
     *
     * @param  array<string, mixed>  $enrollmentData
     */
    public function handle(array $enrollmentData): Enrollment
    {
        return DB::transaction(fn () => Enrollment::create([
            'status' => $enrollmentData['status'] ?? EnrollmentStatus::ACTIVE,
            'enrolled_at' => $enrollmentData['enrolled_at'] ?? now(),
            'credits' => $enrollmentData['credits'] ?? 0,
            'discount_pct' => $enrollmentData['discount_pct'] ?? 0,
            'student_id' => $enrollmentData['student_id'],
            'course_id' => $enrollmentData['course_id'],
        ]));
    }
}
