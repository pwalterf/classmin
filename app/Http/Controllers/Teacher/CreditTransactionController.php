<?php

declare(strict_types=1);

namespace App\Http\Controllers\Teacher;

use App\Actions\Teacher\CreateCreditTransaction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\CreditTransactionStoreRequest;
use App\Models\Course;
use App\Models\CreditTransaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

final class CreditTransactionController extends Controller
{
    public function store(CreditTransactionStoreRequest $request, CreateCreditTransaction $createCreditTransaction): RedirectResponse
    {
        Gate::authorize('create', Course::class);

        $createCreditTransaction->handle(new CreditTransaction($request->validated()));

        return back();
    }
}
