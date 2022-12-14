<?php

namespace Domain\Subscriber\DTOs;

use Spatie\LaravelData\Data;

class NewSubscribersCountData extends Data
{
    public function __construct(
        public readonly int $total,
        public readonly int $thisMonth,
        public readonly int $thisWeek,
        public readonly int $today,
    ) {
    }
}
