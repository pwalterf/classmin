<?php

declare(strict_types=1);

namespace App\Http\Controllers\Teacher;

use App\Actions\Teacher\CreateStudent;
use App\Actions\Teacher\DeleteStudent;
use App\Actions\Teacher\UpdateStudent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\StudentStoreRequest;
use App\Http\Requests\Teacher\StudentUpdateRequest;
use App\Http\Resources\Teacher\StudentResource;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

final class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        Gate::authorize('viewAny', Student::class);

        return Inertia::render('teacher/students/Index', [
            'students' => StudentResource::collection(Student::byCurrentTeacher()->get()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentStoreRequest $request, CreateStudent $createStudent): RedirectResponse
    {
        Gate::authorize('create', Student::class);

        $createStudent->handle($request->validated());

        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentUpdateRequest $request, Student $student, UpdateStudent $updateStudent): RedirectResponse
    {
        Gate::authorize('update', $student);

        $updateStudent->handle($student, $request->validated());

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student, DeleteStudent $deleteStudent): RedirectResponse
    {
        Gate::authorize('delete', $student);

        $deleteStudent->handle($student);

        return to_route('students.index');
    }
}
