<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Models\Teacher;
use App\Models\User;

final class TeacherPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(UserPermission::VIEW_TEACHERS);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Teacher $teacher): bool
    {
        return $user->can(UserPermission::VIEW_TEACHERS)
            && ($user->hasRole(UserRole::ADMIN) || $user->teacher->id === $teacher->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(UserPermission::MANAGE_TEACHERS);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Teacher $teacher): bool
    {
        return $user->can(UserPermission::MANAGE_TEACHERS)
            && ($user->hasRole(UserRole::ADMIN) || $user->teacher->id === $teacher->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->can(UserPermission::MANAGE_TEACHERS)
            && $user->hasRole(UserRole::ADMIN);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return $user->can(UserPermission::MANAGE_TEACHERS)
            && $user->hasRole(UserRole::ADMIN);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        return $user->can(UserPermission::MANAGE_TEACHERS)
            && $user->hasRole(UserRole::ADMIN);
    }
}
