<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;

final class CourseController extends Controller
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
    public function store(StoreCourseRequest $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course): void
    {
        //
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
    public function update(UpdateCourseRequest $request, Course $course): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course): void
    {
        //
    }
}
