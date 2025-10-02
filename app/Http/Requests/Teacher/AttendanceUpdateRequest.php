<?php

declare(strict_types=1);

namespace App\Http\Requests\Teacher;

use App\Enums\AttendanceStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class AttendanceUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'attendances' => ['required', 'array'],
            'attendances.*.id' => ['required', 'numeric', 'exists:attendances,id'],
            'attendances.*.status' => ['required', Rule::enum(AttendanceStatus::class)],
            'attendances.*.notes' => ['nullable', 'string'],
        ];
    }
}
