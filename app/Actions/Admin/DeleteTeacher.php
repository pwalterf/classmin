<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use App\Models\Teacher;
use Illuminate\Support\Facades\DB;

final readonly class DeleteTeacher
{
    /**
     * DeleteTeacher constructor.
     */
    public function __construct(
        private DeleteUser $deleteUser,
    ) {}

    /**
     * Execute the action.
     */
    public function handle(Teacher $teacher): void
    {
        DB::transaction(function () use ($teacher): void {
            // TODO
            // Delete Courses
            $teacher->delete();
            $this->deleteUser->handle($teacher->user);
        });
    }
}
