<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Models\Student;
use Illuminate\Support\Facades\DB;

final readonly class DeleteStudent
{
    /**
     * Execute the action.
     */
    public function handle(Student $student): void
    {
        DB::transaction(function () use ($student): void {
            $student->delete();
        });
    }
}
