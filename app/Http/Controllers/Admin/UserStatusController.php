<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\ChangeUserStatus;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\User;

final class UserStatusController extends Controller
{
    public function changeStatus(User $user, UserStatus $status, ChangeUserStatus $changeUserStatus): User
    {
        if (auth()->user()->cannot('update', $user) || auth()->user()->id === $user->id) {
            abort(403);
        }

        return $changeUserStatus->handle($user, $status);
    }
}
