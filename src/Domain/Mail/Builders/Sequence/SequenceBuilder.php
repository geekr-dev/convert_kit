<?php

namespace Domain\Mail\Builders\Sequence;

use Blueprint\Builder;
use Domain\Subscriber\Enums\SubscriberStatus;

class SequenceBuilder extends Builder
{
    // 统计所有订阅用户
    public function activeSubscriberCount(): int
    {
        return $this->model->subscribers()
            ->whereNotNull('status')
            ->count();
    }

    // 统计所有接收邮件中的订阅用户
    public function inProgressSubscriberCount(): int
    {
        return $this->model->subscribers()
            ->whereStatus(SubscriberStatus::InProgress)
            ->count();
    }

    // 通过所有完成接收的订阅用户
    public function completedSubscriberCount(): int
    {
        return $this->model->subscribers()
            ->whereStatus(SubscriberStatus::Completed)
            ->count();
    }
}
