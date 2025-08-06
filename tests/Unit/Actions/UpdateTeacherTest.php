<?php

declare(strict_types=1);

use App\Actions\Admin\UpdateTeacher;
use App\Enums\UserRole;
use App\Models\Teacher;
use Spatie\Permission\Models\Role;

test('update teacher data with new data', function () {
    app(Role::class)->findOrCreate(UserRole::TEACHER->value, 'web');

    $teacher = Teacher::factory()->create()->refresh();
    $teacher->user->assignRole(UserRole::TEACHER->value);

    $teacherData = [
        'first_name' => $teacher->user->first_name,
        'last_name' => $teacher->user->last_name,
        'email' => $teacher->user->email,
        'status' => $teacher->user->status,
        'bio' => 'New Bio description',
    ];

    $teacher = app(UpdateTeacher::class)->handle($teacher, $teacherData);

    expect($teacher)->toBeInstanceOf(Teacher::class);
    expect($teacher->bio)->toBe($teacherData['bio']);
});
