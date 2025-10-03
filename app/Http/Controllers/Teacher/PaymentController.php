<?php

declare(strict_types=1);

namespace App\Http\Controllers\Teacher;

use App\Actions\Teacher\CreatePayment;
use App\Actions\Teacher\DeletePayment;
use App\Actions\Teacher\UpdatePayment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\PaymentStoreRequest;
use App\Http\Requests\Teacher\PaymentUpdateRequest;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

final class PaymentController extends Controller
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
    public function store(PaymentStoreRequest $request, CreatePayment $createPayment): RedirectResponse
    {
        Gate::authorize('create', Payment::class);

        $createPayment->handle($request->validated());

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaymentUpdateRequest $request, Payment $payment, UpdatePayment $updatePayment): RedirectResponse
    {
        Gate::authorize('update', $payment);

        $updatePayment->handle($payment, $request->validated());

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment, DeletePayment $deletePayment): RedirectResponse
    {
        Gate::authorize('delete', $payment);

        $deletePayment->handle($payment);

        return back();
    }
}
