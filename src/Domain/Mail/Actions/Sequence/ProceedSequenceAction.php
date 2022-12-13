<?php

namespace Domain\Mail\Actions\Sequence;

use Domain\Mail\Mails\EchoMail;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class ProceedSequenceAction
{
    public static function execute(Sequence $sequence): int
    {
        $sentMailCount = 0;
        foreach ($sequence->mails()->wherePublished()->get() as $mail) {
            $subscribers = self::subscribers($mail);

            // 将序列邮件发送给筛选过的订阅用户
            foreach ($subscribers as $subscriber) {
                // 通过异步队列发送邮件
                Mail::to($subscriber)->queue(new EchoMail($mail));
                // 然后将发送记录插入sent_mails表
                $mail->sentMails()->create([
                    'subscriber_id' => $subscriber->id,
                    'user_id' => $sequence->user_id,
                ]);
            }

            // 统计邮件发送数量
            $sentMailCount += $subscribers->count();
        }
        return $sentMailCount;
    }

    public static function subscribers(SequenceMail $mail): Collection
    {
        // 如果今天不是发送日，退出
        if (!$mail->shouldSendToday()) {
            return;
        }

        return $mail->audience()
            ->reject->alreadyReceived($mail)  // 过滤掉其中已收到邮件的订阅用户
            ->reject->tooEarlyFor($mail);     // 过滤掉其中还没到时间的订阅用户
    }
}
