<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Models\Student;
use Illuminate\Support\Facades\DB;

final readonly class UpdateStudent
{
    /**
     * Execute the action.
     *
     * @param  array<string, mixed>  $studentData
     */
    public function handle(Student $student, array $studentData): Student
    {
        return DB::transaction(function () use ($student, $studentData): Student {
            $student->fill($studentData);

            if ($student->isDirty()) {
                $student->save();
            }

            return $student;
        });
    }
}
