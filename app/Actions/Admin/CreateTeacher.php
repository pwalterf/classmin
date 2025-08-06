<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use App\Models\Teacher;
use Illuminate\Support\Facades\DB;

final readonly class CreateTeacher
{
    /**
     * CreateTeacher constructor.
     */
    public function __construct(
        private CreateUserWithRoles $createUser,
    ) {}

    /**
     * Execute the action.
     *
     * @param  array<string, mixed>  $teacherData
     */
    public function handle(array $teacherData): Teacher
    {
        return DB::transaction(function () use ($teacherData) {
            $user = $this->createUser->handle($teacherData);

            return Teacher::create([
                'bio' => $teacherData['bio'] ?? null,
                'user_id' => $user->id,
            ]);
        });
    }
}
