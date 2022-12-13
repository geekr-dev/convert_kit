<?php

namespace Domain\Mail\DTOs;

use Domain\Shared\VOs\Percent;
use Spatie\LaravelData\Data;

class PerformanceData extends Data
{
    public function __construct(
        public readonly int $total,
        public readonly Percent $openRate,
        public readonly Percent $clickRate,
    ) {
    }
}
