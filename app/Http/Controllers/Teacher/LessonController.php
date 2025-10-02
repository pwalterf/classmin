<?php

declare(strict_types=1);

namespace App\Http\Controllers\Teacher;

use App\Actions\Teacher\CreateLesson;
use App\Actions\Teacher\DeleteLesson;
use App\Actions\Teacher\UpdateLesson;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\LessonStoreRequest;
use App\Http\Requests\Teacher\LessonUpdateRequest;
use App\Models\Lesson;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

final class LessonController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(LessonStoreRequest $request, CreateLesson $createLesson): RedirectResponse
    {
        Gate::authorize('create', Lesson::class);

        $createLesson->handle($request->validated());

        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LessonUpdateRequest $request, Lesson $lesson, UpdateLesson $updateLesson): RedirectResponse
    {
        Gate::authorize('update', $lesson);

        $updateLesson->handle($lesson, $request->validated());

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson, DeleteLesson $deleteLesson): RedirectResponse
    {
        Gate::authorize('delete', $lesson);

        $deleteLesson->handle($lesson);

        return back();
    }
}
