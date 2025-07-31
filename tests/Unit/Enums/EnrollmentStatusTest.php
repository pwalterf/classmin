<?php

declare(strict_types=1);

use App\Enums\EnrollmentStatus;

test('enrollment statuses', function () {
    $statuses = EnrollmentStatus::getStatuses();

    expect($statuses)->toHaveCount(4);
    expect($statuses)->toContain(EnrollmentStatus::Active->value);
    expect($statuses)->toContain(EnrollmentStatus::Inactive->value);
    expect($statuses)->toContain(EnrollmentStatus::Dropped->value);
    expect($statuses)->toContain(EnrollmentStatus::Completed->value);
});
