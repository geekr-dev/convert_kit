<?php

namespace Domain\Shared\ViewModels;

use Domain\Shared\Filters\DateFilter;
use Domain\Subscriber\DTOs\NewSubscribersCountData;
use Domain\Subscriber\Models\Subscriber;

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
}
