<?php

declare(strict_types=1);

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StudentUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:100', Rule::unique('students')->where('teacher_id', $this->user()->teacher->id)->ignore($this->student->id)],
            'date_of_birth' => ['nullable', 'date', Rule::date()->beforeToday()],
            'phone_number' => ['nullable', 'string', 'max:20'],
        ];
    }
}
