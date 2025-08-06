<?php

declare(strict_types=1);

use App\Actions\Admin\CreateTeacher;
use App\Enums\UserRole;
use App\Models\Teacher;
use App\Models\User;
use Spatie\Permission\Contracts\Role;

test('CreateTeacher action creates a teacher with user and roles', function () {
    $teacherRole = app(Role::class)->findOrCreate(UserRole::TEACHER->value, 'web');

    $teacherData = [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@example.com',
        'password' => 'password',
        'roles' => ['teacher'],
        'bio' => 'A passionate educator.',
    ];

    $teacher = app(CreateTeacher::class)->handle($teacherData);

    expect($teacher)->toBeInstanceOf(Teacher::class);
    expect($teacher->user)->toBeInstanceOf(User::class);
    expect($teacher->user->getRoleNames()->toArray())->toEqual($teacherData['roles']);
});
