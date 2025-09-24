<?php

declare(strict_types=1);

namespace App\Http\Requests\Teacher;

use App\Enums\EnrollmentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class EnrollmentUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', 'string', Rule::enum(EnrollmentStatus::class)],
            'enrolled_at' => ['required', 'date'],
            'credits' => ['required', 'integer', 'max:99', 'min:-99'],
            'discount_pct' => ['required', 'integer', 'max:100', 'min:0'],
        ];
    }
}
