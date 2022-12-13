<?php

namespace Domain\Subscriber\Models\Concerns;

use Domain\Mail\DTOs\FilterData;
use Domain\Subscriber\Enums\Filters;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;

trait HasAudience
{
    abstract public function filters(): FilterData;
    abstract protected function audienceQuery(): Builder;

    /**
     * @return Collection<Subscriber>
     */
    public function audience(): Collection
    {
        // 创建过滤器
        $filters = collect($this->filters()->toArray())
            ->map(
                fn (array $ids, string $key) =>
                Filters::from($key)->createFilter($ids)
            )
            ->values()
            ->all();

        // 基于过滤器筛选
        return app(Pipeline::class)
            ->send($this->audienceQuery())
            ->through($filters)
            ->thenReturn()
            ->get();
    }
}
