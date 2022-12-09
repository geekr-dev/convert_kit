<?php

namespace Domain\Mail\ViewModels\Broadcast;

use Domain\Mail\DTOs\Broadcast\BroadcastData;
use Domain\Mail\ViewModels\Concerns\HasForms;
use Domain\Mail\ViewModels\Concerns\HasTags;
use Domain\Shared\ViewModels\ViewModel;
use Domain\Mail\Models\Broadcast\Broadcast;

class UpsertSubscriberViewModel extends ViewModel
{
    use HasForms;
    use HasTags;

    public function __construct(
        public readonly ?Broadcast $broadcast = null,
    ) {
    }

    public function broadcast(): BroadcastData
    {
        if (!$this->broadcast()) {
            return null;
        }

        return $this->broadcast->getData();
    }
}
