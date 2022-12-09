<?php

namespace Domain\Subscriber\Actions;

use Domain\Shared\Models\User;
use Domain\Subscriber\DTOs\SubscriberData;
use Domain\Subscriber\Models\Subscriber;
use Domain\Subscriber\Models\Tag;

class ImportSubscribersAction
{
    public static function execute(
        string $path,
        User $user
    ): void {
        ReadCsvAction::execute($path)
            ->each(function (array $row) use ($user) {
                $parsed = [
                    ...$row,
                    'tags' => self::parseTags($row, $user),
                ];
                // 将命令行导入的数据转化为 DTO 对象
                $data = SubscriberData::from($parsed);
                // 订阅用户已存在则退出导入序列
                if (self::isSubscriberExist($data, $user)) {
                    return;
                }
                // 不存在则导入
                UpsertSubscriberAction::execute($data, $user);
            });
    }

    /**
     * 将 tags 字符串基于, 分割成数组后进行处理
     * @param string[] $row
     * @param User $user
     * @return Tag[]
     */
    private static function parseTags(array $row, User $user): array
    {
        $tags = collect(explode(',', $row['tags']))
            ->map(fn ($v) => trim($v))  // 去除任何字符串左右的空格再调用filter
            ->filter()
            ->toArray();
        return self::getOrCreateTags($tags, $user);
    }

    /**
     * 将 tag 字符串集合转化为Tag实例集合（已存在则返回，不存则创建）
     * @param string[] $tags
     * @param User $user
     * @return Tag[]
     */
    private static function getOrCreateTags(
        array $tags,
        User $user
    ): array {
        return collect($tags)
            ->map(fn (string $title) => Tag::firstOrCreate([
                'title' => $title,
                'user_id' => $user->id,
            ]))
            ->toArray();
    }

    /**
     * 订阅用户是否已存在
     */
    private static function isSubscriberExist(
        SubscriberData $data,
        User $user
    ): bool {
        return Subscriber::query()
            ->whereEmail($data->email)
            ->whereBelongsTo($user)
            ->exists();
    }
}
