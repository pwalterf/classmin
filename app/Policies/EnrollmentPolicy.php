<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserPermission;
use App\Models\Enrollment;
use App\Models\User;

final class EnrollmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(UserPermission::VIEW_ENROLLMENTS);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Enrollment $enrollment): bool
    {
        return $user->can(UserPermission::VIEW_ENROLLMENTS)
            && ($user->teacher->id === $enrollment->course->teacher->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(UserPermission::MANAGE_ENROLLMENTS);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Enrollment $enrollment): bool
    {
        return $user->can(UserPermission::MANAGE_ENROLLMENTS)
            && ($user->teacher->id === $enrollment->course->teacher->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Enrollment $enrollment): bool
    {
        return $user->can(UserPermission::MANAGE_ENROLLMENTS)
            && ($user->teacher->id === $enrollment->course->teacher->id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Enrollment $enrollment): bool
    {
        return $user->can(UserPermission::MANAGE_ENROLLMENTS)
            && ($user->teacher->id === $enrollment->course->teacher->id);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Enrollment $enrollment): bool
    {
        return $user->can(UserPermission::MANAGE_ENROLLMENTS)
            && ($user->teacher->id === $enrollment->course->teacher->id);
    }
}
