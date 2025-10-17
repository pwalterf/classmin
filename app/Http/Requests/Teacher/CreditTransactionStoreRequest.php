<?php

declare(strict_types=1);

namespace App\Http\Requests\Teacher;

use App\Enums\CreditTransactionType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class CreditTransactionStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'transacted_at' => ['required', 'date'],
            'type' => ['required', Rule::enum(CreditTransactionType::class)],
            'credits' => ['required', 'numeric', 'min:-99', 'max:99'],
            'description' => ['nullable', 'string', 'max:100'],
            'enrollment_id' => ['required', 'numeric', 'exists:enrollments,id'],
        ];
    }
}
