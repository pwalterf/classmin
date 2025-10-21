<?php

declare(strict_types=1);

namespace App\Http\Controllers\Teacher;

use App\Actions\Teacher\CreateCourse;
use App\Actions\Teacher\UpdateCourse;
use App\Enums\AttendanceStatus;
use App\Enums\CourseStatus;
use App\Enums\EnrollmentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\CoursePriceStoreRequest;
use App\Http\Requests\Teacher\CourseStoreRequest;
use App\Http\Requests\Teacher\CourseUpdateRequest;
use App\Http\Resources\Teacher\CourseResource;
use App\Http\Resources\Teacher\StudentResource;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

final class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        Gate::authorize('viewAny', Course::class);

        return Inertia::render('teacher/courses/Index', [
            'courses' => fn () => CourseResource::collection(Course::query()
                ->where('teacher_id', auth()->user()->teacher->id)
                ->with(['enrollments.student', 'prices', 'lastPrice'])
                ->get()),
            'courseStatuses' => fn (): array => CourseStatus::cases(),
            'enrollmentStatuses' => fn (): array => EnrollmentStatus::cases(),
            'attendanceStatuses' => fn (): array => AttendanceStatus::cases(),
            'students' => Inertia::optional(fn () => StudentResource::collection(Student::byCurrentTeacher()->get())),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        Gate::authorize('create', Course::class);

        return Inertia::render('teacher/courses/Create', [
            'courseStatuses' => fn (): array => CourseStatus::cases(),
            'enrollmentStatuses' => fn (): array => EnrollmentStatus::cases(),
            'students' => Inertia::optional(fn () => StudentResource::collection(Student::byCurrentTeacher()->get())),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CreateCourse $createCourse): RedirectResponse
    {
        Gate::authorize('create', Course::class);

        if ($request['step'] === 1) {
            Validator::make($request->all(), app(CourseStoreRequest::class)->rules())->validate();

            return back();
        }

        if ($request['step'] === 2) {
            Validator::make($request->all(), app(CoursePriceStoreRequest::class)->rules())->validate();

            return back();
        }

        if ($request['step'] === 3) {
            $createCourse->handle($request->all());
        }

        return to_route('courses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course): Response
    {
        Gate::authorize('view', $course);

        return Inertia::render('teacher/courses/Show', [
            'course' => fn (): CourseResource => new CourseResource($course->load([
                'lastPrice',
                'enrollments' => ['student', 'payments', 'creditTransactions'],
                'prices',
                'lessons' => ['attendances.enrollment.student']])),
            'courseStatuses' => fn (): array => CourseStatus::cases(),
            'enrollmentStatuses' => fn (): array => EnrollmentStatus::cases(),
            'attendanceStatuses' => fn (): array => AttendanceStatus::cases(),
            'students' => Inertia::optional(fn () => StudentResource::collection(Student::byCurrentTeacher()->get())),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseUpdateRequest $request, Course $course, UpdateCourse $updateCourse): RedirectResponse
    {
        Gate::authorize('update', $course);

        $updateCourse->handle($course, $request->validated());

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course): void
    {
        //
    }
}
