<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Models\Teacher;
use Spatie\Permission\Models\Role;

test('guests are redirected to the login page', function () {
    $response = $this->get('/teacher/dashboard');
    $response->assertRedirect('/login');
});

test('authenticated users can visit the dashboard', function () {
    $teacher = Teacher::factory()->create();
    Role::create([
        'name' => UserRole::TEACHER,
    ]);
    $teacher->user->assignRole(UserRole::TEACHER);
    $this->actingAs($teacher->user);

    $response = $this->get('/teacher/dashboard');
    $response->assertStatus(200);
});
