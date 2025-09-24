<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;

final readonly class UpdateEnrollment
{
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
                $enrollment->save();
            }

            return $enrollment;
        });
    }
}
