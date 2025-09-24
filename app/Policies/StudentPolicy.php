<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserPermission;
use App\Models\Student;
use App\Models\User;

final class StudentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(UserPermission::VIEW_STUDENTS);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Student $student): bool
    {
        return $user->can(UserPermission::VIEW_STUDENTS)
            && ($user->teacher->id === $student->teacher->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(UserPermission::MANAGE_STUDENTS);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Student $student): bool
    {
        return $user->can(UserPermission::MANAGE_STUDENTS)
            && ($user->teacher->id === $student->teacher->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Student $student): bool
    {
        return $user->can(UserPermission::MANAGE_STUDENTS)
            && ($user->teacher->id === $student->teacher->id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Student $student): bool
    {
        return $user->can(UserPermission::MANAGE_STUDENTS)
            && ($user->teacher->id === $student->teacher->id);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Student $student): bool
    {
        return $user->can(UserPermission::MANAGE_STUDENTS)
            && ($user->teacher->id === $student->teacher->id);
    }
}
