<?php

declare(strict_types=1);

namespace App\Http\Requests\Teacher;

use App\Enums\AttendanceStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class LessonUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'notes' => ['required', 'string', 'max:500'],
            'student_page' => ['nullable', 'string', 'max:50'],
            'workbook_page' => ['nullable', 'string', 'max:50'],
            'taught_at' => ['required', 'date'],
            'attendances' => ['required', 'array', 'min:1'],
            'attendances.*.id' => ['required', 'integer', 'exists:attendances,id'],
            'attendances.*.status' => ['required', Rule::enum(AttendanceStatus::class)],
            'attendances.*.notes' => ['nullable', 'string', 'max:50'],
        ];
    }
}
