<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;

final readonly class UpdateEnrollmentCredits
{
    /**
     * Execute the action.
     */
    public function handle(Enrollment $enrollment, int $credits): Enrollment
    {
        return DB::transaction(fn () => tap($enrollment)->update([
            'credits' => $enrollment->credits + $credits,
        ]));
    }
}
