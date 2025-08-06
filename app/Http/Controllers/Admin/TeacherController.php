<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\CreateTeacher;
use App\Actions\Admin\DeleteTeacher;
use App\Actions\Admin\UpdateTeacher;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TeacherStoreRequest;
use App\Http\Requests\Admin\TeacherUpdateRequest;
use App\Http\Resources\TeacherResource;
use App\Models\Teacher;
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
        Gate::authorize('viewAny');

        return Inertia::render('admin/teachers/Index', [
            'teachers' => TeacherResource::collection(Teacher::with('user')->get()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeacherStoreRequest $request, CreateTeacher $createTeacher): RedirectResponse
    {
        Gate::authorize('create');

        $createTeacher->handle($request->validated());

        return to_route('teachers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): void
    {
        //
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
