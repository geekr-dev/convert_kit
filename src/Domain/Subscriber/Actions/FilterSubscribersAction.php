<?php

namespace Domain\Subscriber\Actions;

use Domain\Mail\Contracts\Sendable;
use Domain\Subscriber\Enums\Filters;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Database\Eloquent\Collection;

class FilterSubscribersAction
{
    /**
     * @return Collection<Subscriber>
     */
    public static function execute(Sendable $mail): Collection
    {
        return app(Pipeline::class)
            ->send(Subscriber::query())
            ->through(self::filters($mail))
            ->thenReturn()
            ->get();
    }
    /**
     * @return array<Filter>
     */
    public static function filters(Sendable $mail): array
    {
        return collect($mail->filters->toArray())
            ->map(
                fn (array $ids, string $key) =>
                Filters::from($key)->createFilter($ids)
            )
            ->values()
            ->all();
    }
}
