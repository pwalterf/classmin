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
