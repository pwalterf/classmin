<?php

declare(strict_types=1);

namespace App\Http\Controllers\Teacher;

use App\Actions\Teacher\CreateCoursePrice;
use App\Actions\Teacher\DeleteCoursePrice;
use App\Actions\Teacher\UpdateCoursePrice;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\CoursePriceStoreRequest;
use App\Http\Requests\Teacher\CoursePriceUpdateRequest;
use App\Models\Course;
use App\Models\CoursePrice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

final class CoursePriceController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(CoursePriceStoreRequest $request, CreateCoursePrice $createCoursePrice): RedirectResponse
    {
        Gate::authorize('create', CoursePrice::class);

        $createCoursePrice->handle($request->validated(), Course::find($request->safe()['course_id']));

        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CoursePriceUpdateRequest $request, CoursePrice $coursePrice, UpdateCoursePrice $updateCoursePrice): RedirectResponse
    {
        Gate::authorize('update', $coursePrice);

        $updateCoursePrice->handle($request->validated(), $coursePrice);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CoursePrice $coursePrice, DeleteCoursePrice $deleteCoursePrice): RedirectResponse
    {
        Gate::authorize('delete', $coursePrice);

        $deleteCoursePrice->handle($coursePrice);

        return back();
    }
}
