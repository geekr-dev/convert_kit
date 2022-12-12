<?php

namespace Domain\Mail\Actions;

use Domain\Mail\Contracts\Sendable;
use Domain\Mail\DTOs\PerformanceData;
use Domain\Mail\Models\SentMail;

class GetPerformanceAction
{
    public static function execute(
        Sendable $sendable
    ): PerformanceData {
        $total =  SentMail::countOf($sendable);
        return new PerformanceData(
            total: $total,
            openRate: SentMail::openRate($sendable, $total),
            clickRate: SentMail::clickRate($sendable, $total),
        );
    }
}
