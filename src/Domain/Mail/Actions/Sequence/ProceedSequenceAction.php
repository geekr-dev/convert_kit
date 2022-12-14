<?php

namespace Domain\Mail\Actions\Sequence;

use Domain\Mail\Mails\EchoMail;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Mail\Models\Sequence\SequenceSubscriber;
use Domain\Subscriber\Enums\SubscriberStatus;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class ProceedSequenceAction
{
    /**
     * @var array<int, array<int>>
     */
    private static array $mailsBySubscribers = [];

    // 该入口函数每分钟会被调度命令调度一次，所以处理序列邮件是个持续的过程，不是一次性调用！！！
    // 所以从结果上我们也要看最终一致性，而不是以一次结果为评判标准
    public static function execute(Sequence $sequence): void
    {
        foreach ($sequence->mails()->wherePublished()->get() as $mail) {
            // 返回序列所有订阅用户和当前邮件筛选后的目标用户
            [$audience, $schedulableAudience] = self::audience($mail);

            // 发送邮件给此次筛选后的目标受众
            self::sendMails($schedulableAudience, $mail, $sequence);

            // 维护序列邮件目标受众及对应邮件列表
            self::addMailToAudience($audience, $mail);

            // 更新此次发送邮件用户的邮件接收状态为处理中
            self::markAsInProgress($sequence, $schedulableAudience);
        }

        // 将已经收到所有邮件的用户邮件接收状态调整为已完成
        // 备注：可能经过多次调度才会达到最终全部完成
        self::markAsCompleted($sequence);
    }

    /**
     * @return array<Collection<Subscriber"4
     */
    private static function audience(SequenceMail $mail): array
    {
        $audience = $mail->audience();

        if (!$mail->shouldSendToday()) {
            return [$audience, collect([])];
        }

        $schedulableAudience = $audience
            ->reject->alreadyReceived($mail)
            ->reject->tooEarlyFor($mail);

        return [$audience, $schedulableAudience];
    }

    private static function sendMails(Collection $schedulableAudience, SequenceMail $mail, Sequence $sequence): void
    {
        foreach ($schedulableAudience as $subscriber) {
            // 异步发送邮件
            Mail::to($subscriber)->queue(new EchoMail($mail));
            // 将发送记录存储到 sent_mails 表
            $mail->sent_mails()->create([
                'subscriber_id' => $subscriber->id,
                'user_id' => $sequence->user->id,
            ]);
        }
    }

    /**
     * @param Collection<Subscriber> $audience
     */
    private static function addMailToAudience(Collection $audience, SequenceMail $mail): void
    {
        // 维护序列邮件所有目标受众，以及对应的邮件ID列表（可用于统计用户应该收到的邮件总数）
        // 注意这里需要以序列的所有订阅用户为准
        foreach ($audience as $subscriber) {
            if (!Arr::get(self::$mailsBySubscribers, $subscriber->id)) {
                self::$mailsBySubscribers[$subscriber->id] = [];
            }
            self::$mailsBySubscribers[$subscriber->id][] = $mail->id;
        }
    }

    /**
     * @param Sequence $sequence
     * @param Collection<Subscriber> $subscribers
     */
    public static function markAsInProgress(Sequence $sequence, Collection $schedulableAudience): void
    {
        SequenceSubscriber::query()
            ->whereBelongsTo($sequence)
            ->whereIn(
                'subscriber_id',
                $schedulableAudience->pluck('id')
            )
            ->update([
                'status' => SubscriberStatus::InProgress,
            ]);
    }

    public static function markAsCompleted(Sequence $sequence): void
    {
        // 所有订阅用户，包含已收到邮件数的统计
        // 最后使用 mapWithKeys 封装 $subscribers 是为了降低后面根据 $subscriberId 获取 $subscriber 的成本
        $subscribers =
            Subscriber::withCount([
                'receivedMails' =>
                fn (Builder $receivedMails) => $receivedMails->whereSequence($sequence)
            ])
            ->find(array_keys(self::$mailsBySubscribers))
            ->mapWithKeys(fn (Subscriber $subscriber) => [
                $subscriber->id => $subscriber,
            ]);

        // 统计已经收到所有邮件的订阅用户
        $completedSubscriberIds = [];
        foreach (self::$mailsBySubscribers as $subscriberId => $mailIds) {
            $subscriber = $subscribers[$subscriberId];
            if ($subscriber->receivedMails_count === count($mailIds)) {
                $completedSubscriberIds[] = $subscriber->id;
            }
        }

        // 将这部分用户的邮件接收状态更新为已完成
        SequenceSubscriber::query()
            ->whereBelongsTo($sequence)
            ->whereIn('subscriber_id', $completedSubscriberIds)
            ->update([
                'status' => SubscriberStatus::Completed,
            ]);
    }
}
