<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Enums\CreditTransactionType;
use App\Enums\EnrollmentStatus;
use App\Models\CreditTransaction;
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;

final readonly class EnrollStudent
{
    /**
     * EnrollStudent constructor.
     */
    public function __construct(
        private CreateCreditTransaction $createCreditTransaction,
    ) {}

    /**
     * Execute the action.
     *
     * @param  array<string, mixed>  $enrollmentData
     */
    public function handle(array $enrollmentData): Enrollment
    {
        return DB::transaction(function () use ($enrollmentData) {
            $enrollment = Enrollment::create([
                'status' => $enrollmentData['status'] ?? EnrollmentStatus::ACTIVE,
                'enrolled_at' => $enrollmentData['enrolled_at'] ?? now(),
                'credits' => $enrollmentData['credits'] ?? 0,
                'discount_pct' => $enrollmentData['discount_pct'] ?? 0,
                'student_id' => $enrollmentData['student_id'],
                'course_id' => $enrollmentData['course_id'],
            ]);

            if ($enrollment->credits !== 0) {
                $creditTransaction = new CreditTransaction([
                    'transacted_at' => $enrollment->enrolled_at,
                    'type' => CreditTransactionType::ADJUSTMENT,
                    'credits' => $enrollment->credits,
                    'description' => 'Initial adjustment',
                    'enrollment_id' => $enrollment->id,
                ]);
                $this->createCreditTransaction->handle($creditTransaction);
            }

            return $enrollment;
        });
    }
}
