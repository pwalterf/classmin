<?php

declare(strict_types=1);

use App\Enums\EnrollmentStatuses;

test('enrollment statuses', function () {
    $statuses = EnrollmentStatuses::getStatuses();

    expect($statuses)->toHaveCount(4);
    expect($statuses)->toContain(EnrollmentStatuses::Active->value);
    expect($statuses)->toContain(EnrollmentStatuses::Inactive->value);
    expect($statuses)->toContain(EnrollmentStatuses::Dropped->value);
    expect($statuses)->toContain(EnrollmentStatuses::Completed->value);
});

test('enrollment status labels', function () {
    $labels = EnrollmentStatuses::getLabels();

    expect($labels)->toHaveCount(4);
    expect($labels[EnrollmentStatuses::Active->value])->toBe('Activo');
    expect($labels[EnrollmentStatuses::Inactive->value])->toBe('Inactivo');
    expect($labels[EnrollmentStatuses::Dropped->value])->toBe('Abandonado');
    expect($labels[EnrollmentStatuses::Completed->value])->toBe('Completado');
});
