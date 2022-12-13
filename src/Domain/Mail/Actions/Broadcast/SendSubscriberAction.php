<?php

namespace Domain\Mail\Actions\Broadcast;

use Domain\Mail\Exceptions\Broadcast\CannotSendBroadcast;
use Domain\Mail\Mails\EchoMail;
use Domain\Mail\Models\Broadcast\Broadcast;
use Domain\Subscriber\Actions\FilterSubscribersAction;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

class SendBroadcastAction
{
    public static function execute(Broadcast $broadcast): int
    {
        // 邮件是否可以被发送
        if (!$broadcast->status->canSend()) {
            throw CannotSendBroadcast::because(
                "Broadcast already sent at {$broadcast->sent_at}"
            );
        }

        // 筛选订阅用户，然后挨个发送邮件
        $subscribers = FilterSubscribersAction::execute($broadcast)
            ->each(
                fn (Subscriber $subscriber) =>
                Mail::to($subscriber)->queue(new EchoMail($broadcast))
            );

        // 标记为已发送
        $broadcast->markAsSent();
        // 记录所有发送记录
        return $subscribers->each(
            fn (Subscriber $subscriber) =>
            $broadcast->sentMails()->create([
                'subscriber_id' => $subscriber->id,
                'user_id' => $broadcast->user->id,
            ])
        )->count();
    }
}
