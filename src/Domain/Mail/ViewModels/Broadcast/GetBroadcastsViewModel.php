<?php

namespace Domain\Mail\ViewModels\Broadcast;

use Domain\Shared\ViewModels\ViewModel;

class GetBroadcastsViewModel extends ViewModel
{
    public function __construct(
        private readonly int $currentPage,
    ) {
    }
}
