<?php

declare(strict_types=1);

namespace App\Http\Controllers\Teacher;

use App\Actions\Teacher\UpdateAttendance;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\AttendanceUpdateRequest;
use App\Models\Attendance;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

final class AttendanceController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(AttendanceUpdateRequest $request, UpdateAttendance $updateAttendance): RedirectResponse
    {
        $validated = $request->validated();

        foreach ($validated['attendances'] as $attendanceData) {
            $attendance = Attendance::find($attendanceData['id']);
            Gate::authorize('update', $attendance);

            $updateAttendance->handle($attendance, $attendanceData);
        }

        return back();
    }
}
