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
