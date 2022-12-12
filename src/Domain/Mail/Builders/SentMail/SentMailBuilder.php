<?php

namespace Domain\Mail\Builders\SentMail;

use Domain\Mail\Contracts\Sendable;
use Domain\Shared\VOs\Percent;
use Illuminate\Database\Eloquent\Builder;

class SentMailBuilder extends Builder
{
    // 总发送量
    public function countOf(Sendable $sendable): int
    {
        return $this->whereSendable($sendable)->count();
    }

    // 打开率
    public function openRate(Sendable $sendable, int $total): Percent
    {
        $openedCount = $this->whereSendable($sendable)->whereOpened()->count();
        return Percent::from($openedCount, $total);
    }

    // 点击率
    public function clickRate(Sendable $sendable, int $total): Percent
    {
        $clickedCount = $this->whereSendable($sendable)->whereClicked()->count();
        return Percent::from($clickedCount, $total);
    }

    public function whereSendable(Sendable $sendable): self
    {
        return $this->where('sendable_id', $sendable->id())
            ->where('sendable_type', $sendable->type());
    }

    public function whereOpened(): self
    {
        return $this->whereNotNull('opened_at');
    }

    public function whereClicked(): self
    {
        return $this->whereNotNull('clicked_at');
    }
}
