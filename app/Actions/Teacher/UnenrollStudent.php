<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;

final readonly class UnenrollStudent
{
    /**
     * Execute the action.
     */
    public function handle(Enrollment $enrollment): void
    {
        DB::transaction(function () use ($enrollment): void {
            $enrollment->delete();
        });
    }
}
