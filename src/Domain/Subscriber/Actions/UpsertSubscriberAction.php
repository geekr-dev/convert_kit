<?php

namespace Domain\Subscriber\Actions;

use Domain\Automation\Events\SubscribedToFormEvent;
use Domain\Shared\Models\User;
use Domain\Subscriber\DTOs\SubscriberData;
use Domain\Subscriber\Models\Subscriber;

class UpsertSubscriberAction
{
    public static function execute(SubscriberData $data, User $user): Subscriber
    {
        $subscriber = Subscriber::updateOrCreate(
            [
                'id' => $data->id,
            ],
            [
                ...$data->all(),
                'form_id' => $data->form?->id,
                'user_id' => $user->id,
            ]
        );

        $subscriber->tags()->sync(
            $data->tags->toCollection()->pluck('id')
        );

        // 只有订阅用户第一次创建时触发
        if (!$data->id && $data->form) {
            event(new SubscribedToFormEvent($subscriber, $$user));
        }

        return $subscriber->load('tags', 'form');
    }
}
