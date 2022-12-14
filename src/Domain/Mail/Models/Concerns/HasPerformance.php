<?php

namespace Domain\Mail\Models\Concerns;

use Domain\Mail\DTOs\PerformanceData;
use Domain\Shared\VOs\Percent;
use Illuminate\Database\Eloquent\Relations\Relation;

trait HasPerformance
{
    abstract public function totalInstances(): int;

    public function performance(): PerformanceData
    {
        $total = $this->totalInstances();
        return new PerformanceData(
            total: $total,
            openRate: $this->openRate($total),
            clickRate: $this->clickRate($total),
        );
    }

    public function openRate(int $total): Percent
    {
        return Percent::from(
            $this->sentMails()->whereOpened()->count(),
            $total
        );
    }
    public function clickRate(int $total): Percent
    {
        return Percent::from(
            $this->sendMails()->whereClicked()->count(),
            $total
        );
    }
}
