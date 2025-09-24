<?php

declare(strict_types=1);

namespace App\Http\Controllers\Teacher;

use App\Actions\Teacher\EnrollStudent;
use App\Actions\Teacher\UnenrollStudent;
use App\Actions\Teacher\UpdateEnrollment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\EnrollmentStoreRequest;
use App\Http\Requests\Teacher\EnrollmentUpdateRequest;
use App\Models\Enrollment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

final class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): void
    {
        //
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
    public function store(EnrollmentStoreRequest $request, EnrollStudent $enrollStudent): RedirectResponse
    {
        Gate::authorize('create', Enrollment::class);

        $validated = $request->validated();

        if ($validated['course_id']) {
            $enrollStudent->handle($validated);
        }

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Enrollment $enrollment): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enrollment $enrollment): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EnrollmentUpdateRequest $request, Enrollment $enrollment, UpdateEnrollment $updateEnrollment): RedirectResponse
    {
        Gate::authorize('update', $enrollment);

        $updateEnrollment->handle($request->validated(), $enrollment);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enrollment $enrollment, UnenrollStudent $unenrollStudent): RedirectResponse
    {
        Gate::authorize('delete', $enrollment);

        $unenrollStudent->handle($enrollment);

        return back();
    }
}
