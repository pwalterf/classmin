<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use App\Models\User;
use Illuminate\Support\Facades\DB;

final readonly class UpdateUser
{
    /**
     * CreateUser constructor.
     */
    public function __construct(
        private SyncUserRoles $syncUserRoles,
    ) {}

    /**
     * Execute the action.
     *
     * @param  array<string, mixed>  $userData
     */
    public function handle(User $user, array $userData): User
    {
        return DB::transaction(function () use ($user, $userData): User {
            $user->fill($userData);

            if ($user->isDirty()) {
                $user->save();
            }

            if (! $user->hasExactRoles($userData['roles'])) {
                $this->syncUserRoles->handle($user, $userData['roles']);
            }

            return $user;
        });
    }
}
