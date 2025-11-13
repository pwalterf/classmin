<?php

declare(strict_types=1);

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Resources\Teacher\ARCAReportResource;
use App\Http\Resources\Teacher\BillingResource;
use App\Http\Resources\Teacher\PaymentResource;
use App\Models\Enrollment;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

final class BillingController extends Controller
{
    public function index(): Response
    {
        $totalPayments = Payment::query()
            ->whereRelation('enrollment.course', 'teacher_id', Auth::user()->teacher->id)
            ->orderBy('paid_at', 'desc')
            ->get();

        $billingMonths = $totalPayments
            ->groupBy(fn (Payment $payment) => $payment->paid_at->format('Y-m'))->map(
                fn (Collection $payments, string $key) => (object) ([
                    'date' => Carbon::parse($key),
                    'amount' => $payments->sum('amount'),
                ])
            )->values();

        return Inertia::render('teacher/billing/Index', [
            'billingMonths' => BillingResource::collection($billingMonths),
        ]);
    }

    public function arcaReport(string $date): Response
    {
        $enrollmentPayments = Enrollment::query()
            ->whereRelation('course', 'teacher_id', Auth::user()->teacher->id)
            ->withWhereHas('payments', function ($query) use ($date): void {
                $query->whereDate('paid_at', '>=', Carbon::parse($date)->startOfMonth())
                    ->whereDate('paid_at', '<=', Carbon::parse($date)->endOfMonth());
            })
            ->with('student', 'course')
            ->withSum('payments', 'amount')
            ->withSum('payments', 'credits_purchased')
            ->get()
            ->sortBy('student.full_name');

        return Inertia::render('teacher/billing/ARCAReport', [
            'enrollment_payments' => ARCAReportResource::collection($enrollmentPayments),
            'date' => Carbon::parse($date)->format('F Y'),
        ]);
    }

    public function monthlyPayments(string $date): JsonResource
    {
        $payments = Payment::query()
            ->whereRelation('enrollment.course', 'teacher_id', Auth::user()->teacher->id)
            ->whereDate('paid_at', '>=', Carbon::parse($date)->startOfMonth())
            ->whereDate('paid_at', '<=', Carbon::parse($date)->endOfMonth())
            ->with(['enrollment' => ['student', 'course']])
            ->orderBy('paid_at', 'desc')
            ->get();

        return PaymentResource::collection($payments);
    }
}
