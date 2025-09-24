<?php

declare(strict_types=1);

namespace App\Http\Requests\Teacher;

use App\Enums\CourseStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class CourseStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', Rule::unique('courses')->where('teacher_id', $this->user()->teacher->id)],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string', Rule::enum(CourseStatus::class)],
            'schedule' => ['nullable', 'string'],
            'price' => ['required', 'decimal:0.00,99999.99'],
            'currency' => ['required', 'string', 'size:3'],
            'started_at' => ['required', 'date'],
            'students' => ['nullable', 'array'],
            'students.*' => ['integer', 'exists:students,id'],
        ];
    }
}
