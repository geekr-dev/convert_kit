<?php

namespace Domain\Mail\DTOs;

use Domain\Shared\VOs\Percent;
use Spatie\LaravelData\Data;

class PerformanceData extends Data
{
    public function __construct(
        private readonly int $total,
        private readonly Percent $openRate,
        private readonly Percent $clickRate,
    ) {
    }
}
