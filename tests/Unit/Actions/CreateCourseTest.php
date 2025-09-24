<?php

declare(strict_types=1);

use App\Actions\Teacher\CreateCourse;
use App\Enums\CourseStatus;
use App\Enums\UserRole;
use App\Models\Course;
use App\Models\Teacher;
use Spatie\Permission\Models\Role;

test('CreateCourse action creates a course', function () {
    // Assuming you have a teacher created and authenticated
    $teacher = Teacher::factory()->create();
    Role::create([
        'name' => UserRole::TEACHER,
    ]);
    $teacher->user->assignRole(UserRole::TEACHER);
    auth()->login($teacher->user);

    $courseData = [
        'title' => 'Sample Course',
        'description' => 'This is a sample course description.',
        'started_at' => '2024-07-01',
        'status' => CourseStatus::ACTIVE,
        'schedule' => 'Mondays and Wednesdays, 10:00 AM - 12:00 PM',
        'enrollments' => [],
        'price' => 12000,
        'currency' => 'ARS',
        'discount_pct' => 10,
        'credits' => 3,
    ];

    $course = app(CreateCourse::class)->handle($courseData);

    expect($course)->toBeInstanceOf(Course::class);
    expect($course->title)->toBe($courseData['title']);
    expect($course->description)->toBe($courseData['description']);
    expect($course->started_at->toDateString())->toBe($courseData['started_at']);
    expect($course->status)->toBe($courseData['status']);
    expect($course->schedule)->toBe($courseData['schedule']);
    expect($course->teacher_id)->toBe($teacher->id);
});
