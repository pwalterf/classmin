<?php

declare(strict_types=1);

use App\Enums\AttendanceStatus;

test('attendance statuses', function () {
    $statuses = AttendanceStatus::getStatuses();

    expect($statuses)->toHaveCount(4);
    expect($statuses)->toContain(AttendanceStatus::Present->value);
    expect($statuses)->toContain(AttendanceStatus::Absent->value);
    expect($statuses)->toContain(AttendanceStatus::Late->value);
    expect($statuses)->toContain(AttendanceStatus::Excused->value);
});
