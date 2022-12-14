<?php

namespace Domain\Shared\ViewModels;

use Domain\Mail\DTOs\PerformanceData;
use Domain\Mail\Models\SentMail;
use Domain\Shared\Filters\DateFilter;
use Domain\Shared\VOs\Percent;
use Domain\Subscriber\DTOs\DailySubscribersData;
use Domain\Subscriber\DTOs\NewSubscribersCountData;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class GetDashboardViewModel extends ViewModel
{
    public function newSubscribersCount(): NewSubscribersCountData
    {
        return new NewSubscribersCountData(
            total: Subscriber::whereNotNull(
                'subscribed_at'
            )->count(),
            thisMonth: Subscriber::whereSubscribedBetween(
                DateFilter::thisMonth()
            )->count(),
            thisWeek: Subscriber::whereSubscribedBetween(
                DateFilter::thisWeek()
            )->count(),
            today: Subscriber::whereSubscribedBetween(
                DateFilter::today()
            )->count(),
        );
    }

    public function performance(): PerformanceData
    {
        $total = SentMail::count();

        return new PerformanceData(
            total: $total,
            openRate: $this->averageOpenRate($total),
            clickRate: $this->averageClickRate($total),
        );
    }

    private function averageOpenRate(int $total): Percent
    {
        return Percent::from(
            SentMail::whereOpened()->count(),
            $total
        );
    }
    private function averageClickRate(int $total): Percent
    {
        return Percent::from(
            SentMail::whereClicked()->count(),
            $total
        );
    }

    /**
     * @return Collection<DailySubscribersData>
     */
    public function dailySubscribers(): Collection
    {
        return DB::table('subscribers')
            ->select(
                DB::raw("count(*) count, date_format(subscribed_at, '%Y-%m-%d') day")
            )
            ->groupBy('day')
            ->orderByDesc('day')
            ->whereUserId($this->user->id)  // 不是model查询，所以需要加上user_id
            ->get()
            ->map(
                // 原生 DB 查询返回的数据对象是 stdClass，所以类型声明是 Object
                fn (object $data) => DailySubscribersData::from((array) $data)
            );
    }

    /**
     * @return Collection<SubscriberData>
     */
    public function recentSubscribers(): Collection
    {
        return Subscriber::with(['form', 'tags'])
            ->orderByDesc('subscribed_at')
            ->take(10)
            ->get()
            ->map
            ->getData();
    }
}
