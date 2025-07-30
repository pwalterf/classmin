<?php

declare(strict_types=1);

use App\Enums\CourseStatuses;

test('course statuses', function () {
    $statuses = CourseStatuses::getStatuses();

    expect($statuses)->toHaveCount(6);
    expect($statuses)->toContain(CourseStatuses::Active->value);
    expect($statuses)->toContain(CourseStatuses::Inactive->value);
    expect($statuses)->toContain(CourseStatuses::Completed->value);
    expect($statuses)->toContain(CourseStatuses::Cancelled->value);
    expect($statuses)->toContain(CourseStatuses::Paused->value);
    expect($statuses)->toContain(CourseStatuses::Holiday->value);
});

test('course status labels', function () {
    $labels = CourseStatuses::getLabels();

    expect($labels)->toHaveCount(6);
    expect($labels[CourseStatuses::Active->value])->toBe('Activo');
    expect($labels[CourseStatuses::Inactive->value])->toBe('Inactivo');
    expect($labels[CourseStatuses::Completed->value])->toBe('Completado');
    expect($labels[CourseStatuses::Cancelled->value])->toBe('Cancelado');
    expect($labels[CourseStatuses::Paused->value])->toBe('Pausado');
    expect($labels[CourseStatuses::Holiday->value])->toBe('Vacaciones');
});
