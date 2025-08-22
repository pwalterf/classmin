<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\ChangeUserStatus;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

final class UserStatusController extends Controller
{
    public function changeStatus(Request $request, User $user, ChangeUserStatus $changeUserStatus): void
    {
        if (auth()->user()->cannot('update', $user) || auth()->user()->id === $user->id) {
            abort(403);
        }

        $changeUserStatus->handle($user, $request->status);
    }
}
