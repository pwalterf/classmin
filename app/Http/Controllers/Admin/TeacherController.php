<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\CreateTeacher;
use App\Actions\Admin\DeleteTeacher;
use App\Actions\Admin\UpdateTeacher;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TeacherStoreRequest;
use App\Http\Requests\Admin\TeacherUpdateRequest;
use App\Http\Resources\TeacherResource;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

final class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        Gate::authorize('viewAny', User::class);

        return Inertia::render('admin/teachers/Index', [
            'teachers' => TeacherResource::collection(Teacher::with('user')->get()),
            'statuses' => UserStatus::cases(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeacherStoreRequest $request, CreateTeacher $createTeacher): RedirectResponse
    {
        Gate::authorize('create', Teacher::class);

        $createTeacher->handle($request->validated());

        return to_route('teachers.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TeacherUpdateRequest $request, Teacher $teacher, UpdateTeacher $updateTeacher): RedirectResponse
    {
        Gate::authorize('update', $teacher);

        $updateTeacher->handle($teacher, $request->validated());

        return to_route('teachers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher, DeleteTeacher $deleteTeacher): RedirectResponse
    {
        Gate::authorize('delete');

        $deleteTeacher->handle($teacher);

        return to_route('teachers.index');
    }
}
