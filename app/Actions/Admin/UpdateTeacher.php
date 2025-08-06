<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use App\Models\Teacher;
use Illuminate\Support\Facades\DB;

final readonly class UpdateTeacher
{
    /**
     * CreateUser constructor.
     */
    public function __construct(
        private UpdateUser $updateUser,
    ) {}

    /**
     * Execute the action.
     *
     * @param  array<string, mixed>  $teacherData
     * @return Teacher $teacher
     */
    public function handle(Teacher $teacher, array $teacherData): Teacher
    {
        return DB::transaction(function () use ($teacher, $teacherData): Teacher {
            $this->updateUser->handle($teacher->user, $teacherData);

            $teacher->fill($teacherData);

            if ($teacher->isDirty()) {
                $teacher->save();
            }

            return $teacher;
        });
    }
}
