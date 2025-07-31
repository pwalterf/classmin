<?php

declare(strict_types=1);

use App\Enums\CourseStatus;

test('course statuses', function () {
    $statuses = CourseStatus::getStatuses();

    expect($statuses)->toHaveCount(6);
    expect($statuses)->toContain(CourseStatus::Active->value);
    expect($statuses)->toContain(CourseStatus::Inactive->value);
    expect($statuses)->toContain(CourseStatus::Completed->value);
    expect($statuses)->toContain(CourseStatus::Cancelled->value);
    expect($statuses)->toContain(CourseStatus::Paused->value);
    expect($statuses)->toContain(CourseStatus::Holiday->value);
});
