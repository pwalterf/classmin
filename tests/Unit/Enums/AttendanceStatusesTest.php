<?php

declare(strict_types=1);

use App\Enums\AttendanceStatuses;

test('attendance statuses', function () {
    $statuses = AttendanceStatuses::getStatuses();

    expect($statuses)->toHaveCount(4);
    expect($statuses)->toContain(AttendanceStatuses::Present->value);
    expect($statuses)->toContain(AttendanceStatuses::Absent->value);
    expect($statuses)->toContain(AttendanceStatuses::Late->value);
    expect($statuses)->toContain(AttendanceStatuses::Excused->value);
});

test('attendance status labels', function () {
    $labels = AttendanceStatuses::getLabels();

    expect($labels)->toHaveCount(4);
    expect($labels[AttendanceStatuses::Present->value])->toBe('Presente');
    expect($labels[AttendanceStatuses::Absent->value])->toBe('Ausente');
    expect($labels[AttendanceStatuses::Late->value])->toBe('Tarde');
    expect($labels[AttendanceStatuses::Excused->value])->toBe('Justificado');
});
