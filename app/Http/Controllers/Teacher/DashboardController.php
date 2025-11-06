<?php

declare(strict_types=1);

namespace App\Http\Controllers\Teacher;

use App\Enums\AttendanceStatus;
use App\Enums\EnrollmentStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Teacher\EnrollmentResource;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

final class DashboardController extends Controller
{
    public function index(): Response
    {
        // Cantidad de alumnos y cursos por mes (Barras) --->
        // Lecciones impartidas en el tiempo, particionado por el status de lesson (Barras) --->
        // Ingresos por mes (Barras o Lineas) --->
        // Lecciones cobradas y pendientes de pago (Cards) --->
        // Precios de los cursos (Minimo, Maximo y Promedio) (Card) --->
        // Alumnos deudores (Tabla) --->
        $teacher = Auth::user()->teacher;
        $teacher->load(['activeCourses' => function ($query): void {
            $query->with(['lastPrice', 'activeEnrollments'])
                ->withCount('activeEnrollments');
        }])->loadCount('activeCourses');
        $activeEnrollments = $teacher->activeCourses->pluck('activeEnrollments')->flatten();

        $yearPayments = Payment::whereRelation('enrollment.course.teacher', 'teacher_id', $teacher->id)
            ->whereDate('paid_at', '>=', now()->subMonths(12)->startOfMonth())
            ->get()
            ->groupBy(fn (Payment $payment) => $payment->paid_at->format('Y-m'))->map(fn (Collection $payments) => $payments->sum('amount')
            );

        $months = collect();
        $lessonsCount = collect();
        $studentCount = collect();
        $courseCount = collect();
        $lessonsPerMonth = Lesson::whereRelation('course.teacher', 'teacher_id', $teacher->id)
            ->whereDate('taught_at', '>=', now()->subMonths(12)->startOfMonth())
            ->with('attendances')
            ->orderBy('taught_at')
            ->get()
            ->groupBy(fn (Lesson $lesson) => $lesson->taught_at->format('Y-m'))
            ->map(function (Collection $lessons, string $month) use ($months, $lessonsCount, $studentCount, $courseCount) {
                $months->push($month);
                $lessonsCount->push($lessons->count());
                $studentCount->push($lessons->pluck('attendances')->flatten()->where('status', 'present')->unique('enrollment_id')->count());
                $courseCount->push($lessons->unique('course_id')->count());

                return collect(AttendanceStatus::cases())
                    ->map(fn ($status): array => [
                        'type' => $status->label(),
                        'count' => $lessons->flatMap->attendances->where('status', $status->value)->count(),
                    ]
                    );
            }
            );

        $lessonsAndStatus = [
            'months' => $months,
            'series' => collect($lessonsPerMonth->flatten(1)->groupBy('type')
                ->map(fn ($item, $type): array => [$type, $item->pluck('count')])->push(['Lecciones', $lessonsCount])
            )->values(),
        ];

        $studentsAndCourses = [
            'months' => $months,
            'series' => [['Courses', $courseCount], ['Students', $studentCount]],
        ];

        $cards = [
            'active_courses_count' => $teacher->active_courses_count,
            'active_students_count' => $teacher->activeCourses->sum('active_enrollments_count'),
            'monthly_lessons_count' => $lessonsCount->last(),
            'income' => $yearPayments->get(now()->format('Y-m')) ?? 0,
        ];

        $coursePrices = [
            'min' => $teacher->activeCourses->min('lastPrice.price'),
            'max' => $teacher->activeCourses->max('lastPrice.price'),
            'avg' => $teacher->activeCourses->avg('lastPrice.price'),
        ];

        $countPrices = [
            'min' => $teacher->activeCourses->where('lastPrice.price', $coursePrices['min'])->count(),
            'max' => $teacher->activeCourses->where('lastPrice.price', $coursePrices['max'])->count(),
            'above_avg' => $teacher->activeCourses->where('lastPrice.price', '>=', $coursePrices['avg'])->count(),
            'below_avg' => $teacher->activeCourses->where('lastPrice.price', '<', $coursePrices['avg'])->count(),
        ];
        $coursePrices['count_prices'] = $countPrices;

        $enrollmentsCards = [
            'negative' => $activeEnrollments->where('credits', '<', 0)->sum('credits') * -1,
            'positive' => $activeEnrollments->where('credits', '>', 0)->sum('credits'),
            'zero' => $activeEnrollments->where('credits', 0)->count(),
        ];

        $debts = Enrollment::whereIn('course_id', $teacher->activeCourses->pluck('id'))
            ->where('status', EnrollmentStatus::ACTIVE)
            ->where('credits', '<', 0)
            ->with(['course', 'student'])
            ->orderBy('credits')
            ->get();

        return Inertia::render('teacher/Dashboard', [
            'cards' => $cards,
            'course_prices' => $coursePrices,
            'lessons_month' => $lessonsAndStatus,
            'students_courses' => $studentsAndCourses,
            'debts' => EnrollmentResource::collection($debts),
            'year_payments' => $yearPayments,
            'enrollments_cards' => $enrollmentsCards,
        ]);
    }
}
