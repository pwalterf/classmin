<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final readonly class ChangeUserStatus
{
    /**
     * Execute the action.
     */
    public function handle(User $user, UserStatus $status): User
    {
        return DB::transaction(function () use ($user, $status): User {
            if ($user->status !== $status->value) {
                $user->status = $status->value;
                $user->save();
            }

            return $user;
        });
    }
}
