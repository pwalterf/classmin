<?php

declare(strict_types=1);

use App\Models\Student;

test('to array', function () {
    $student = Student::factory()->create()->refresh();

    expect(array_keys($student->toArray()))->toBe([
        'id',
        'first_name',
        'last_name',
        'email',
        'date_of_birth',
        'phone_number',
        'teacher_id',
        'created_at',
        'updated_at',
    ]);
});

test('has many enrollments', function () {
    $student = Student::factory()->hasEnrollments(3)->create();

    expect($student->enrollments)->toHaveCount(3);
});
