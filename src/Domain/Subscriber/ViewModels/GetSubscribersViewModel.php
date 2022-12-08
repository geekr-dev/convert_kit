<?php

namespace Domain\Subscriber\ViewModels;

use Domain\Shared\ViewModels\ViewModel;
use Domain\Subscriber\DTOs\SubscriberData;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Pagination\Paginator;
use Illuminate\Contracts\Pagination\Paginator as PaginatorContract;

class GetSubscribersViewModel extends ViewModel
{
    private const PER_PAGE = 20;

    public function __construct(
        private readonly int $currentPage
    ) {
    }

    // 返回分页数据
    public function subscribers(): PaginatorContract
    {
        $items = Subscriber::with(['form', 'tags'])
            ->orderBy('first_name')
            ->get()
            ->map(
                fn (Subscriber $subscriber) =>
                SubscriberData::from($subscriber)
            );

        $items = $items->slice(
            self::PER_PAGE * ($this->currentPage - 1)
        );

        return new Paginator(
            $items,
            self::PER_PAGE,
            $this->currentPage,
            [
                'path' => route('subscribers.index'),
            ]
        );
    }

    // 返回总数
    public function total(): int
    {
        return Subscriber::count();
    }
}
