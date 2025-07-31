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
