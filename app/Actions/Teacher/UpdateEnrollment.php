<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Enums\CreditTransactionType;
use App\Models\CreditTransaction;
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;

final readonly class UpdateEnrollment
{
    /**
     * CreateAttendance constructor.
     */
    public function __construct(
        private CreateCreditTransaction $createCreditTransaction,
    ) {}

    /**
     * Execute the action.
     *
     * @param  array<string, mixed>  $enrollmentData
     */
    public function handle(array $enrollmentData, Enrollment $enrollment): Enrollment
    {
        return DB::transaction(function () use ($enrollmentData, $enrollment): Enrollment {
            $enrollment->fill($enrollmentData);

            if ($enrollment->isDirty()) {
                if ($enrollment->isDirty('credits')) {
                    $creditTransaction = new CreditTransaction([
                        'transacted_at' => now(),
                        'type' => CreditTransactionType::ADJUSTMENT,
                        'credits' => $enrollment->credits - $enrollment->getOriginal('credits'),
                        'description' => 'Credit adjusment',
                        'enrollment_id' => $enrollment->id,
                    ]);
                    $this->createCreditTransaction->handle($creditTransaction);
                }
                $enrollment->save();
            }

            return $enrollment;
        });
    }
}
