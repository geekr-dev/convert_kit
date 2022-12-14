<?php

namespace Domain\Mail\ViewModels\Broadcast;

use Domain\Mail\Actions\GetPerformanceAction;
use Domain\Mail\Models\Broadcast\Broadcast;
use Domain\Shared\ViewModels\ViewModel;
use Illuminate\Support\Collection;

class GetBroadcastsViewModel extends ViewModel
{
    /**
     * @return Collection<BroadcastData>
     */
    public function broadcasts(): Collection
    {
        // 根据时间降序获取所有广播列表
        return Broadcast::latest()->get()->map->getData();
    }

    /**
     * @return Collection<int, PerformanceData>
     */
    public function performances(): Collection
    {
        return Broadcast::all()->mapWithKeys(fn (Broadcast $broadcast) => [
            $broadcast->id => $broadcast->performance()
        ]);
    }
}
