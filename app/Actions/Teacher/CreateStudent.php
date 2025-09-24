<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Models\Student;
use Illuminate\Support\Facades\DB;

final readonly class CreateStudent
{
    /**
     * Execute the action.
     *
     * @param  array<string, mixed>  $studentData
     */
    public function handle(array $studentData): Student
    {
        return DB::transaction(fn () => Student::create([
            'first_name' => $studentData['first_name'],
            'last_name' => $studentData['last_name'],
            'email' => $studentData['email'],
            'date_of_birth' => $studentData['date_of_birth'] ?? null,
            'phone_number' => $studentData['phone_number'] ?? null,
            'teacher_id' => auth()->user()->teacher->id,
        ]));
    }
}
