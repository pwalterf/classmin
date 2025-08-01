<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\UserPermission;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

final class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => UserRole::ADMIN]);
        $teacherRole = Role::create(['name' => UserRole::TEACHER]);
        $studentRole = Role::create(['name' => UserRole::STUDENT]);

        foreach (UserPermission::cases() as $permission) {
            Permission::create(['name' => $permission]);
        }

        $adminRole->syncPermissions(Permission::all());
        $teacherRole->syncPermissions([
            UserPermission::VIEW_STUDENTS,
            UserPermission::MANAGE_STUDENTS,
            UserPermission::VIEW_COURSES,
            UserPermission::MANAGE_COURSES,
            UserPermission::VIEW_COURSE_PRICES,
            UserPermission::MANAGE_COURSE_PRICES,
            UserPermission::VIEW_LESSONS,
            UserPermission::MANAGE_LESSONS,
            UserPermission::VIEW_ENROLLMENTS,
            UserPermission::MANAGE_ENROLLMENTS,
            UserPermission::VIEW_ATTENDANCES,
            UserPermission::MANAGE_ATTENDANCES,
            UserPermission::VIEW_PAYMENTS,
            UserPermission::MANAGE_PAYMENTS,
            UserPermission::VIEW_CREDIT_TRANSACTIONS,
            UserPermission::MANAGE_CREDIT_TRANSACTIONS,
            UserPermission::VIEW_REPORTS,
        ]);
        $studentRole->syncPermissions([
            UserPermission::VIEW_COURSES,
            UserPermission::VIEW_COURSE_PRICES,
            UserPermission::VIEW_ENROLLMENTS,
            UserPermission::VIEW_LESSONS,
            UserPermission::VIEW_ATTENDANCES,
            UserPermission::VIEW_PAYMENTS,
            UserPermission::VIEW_CREDIT_TRANSACTIONS,
            UserPermission::VIEW_REPORTS,
        ]);
    }
}
