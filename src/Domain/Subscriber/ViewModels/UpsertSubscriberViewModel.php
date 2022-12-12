<?php

namespace Domain\Subscriber\ViewModels;

use Domain\Shared\ViewModels\Concerns\HasForms;
use Domain\Shared\ViewModels\Concerns\HasTags;
use Domain\Shared\ViewModels\ViewModel;
use Domain\Subscriber\DTOs\SubscriberData;
use Domain\Subscriber\Models\Subscriber;

class UpsertSubscriberViewModel extends ViewModel
{
    use HasForms;
    use HasTags;

    public function __construct(
        public readonly ?Subscriber $subscriber = null
    ) {
    }

    public function subscriber(): ?SubscriberData
    {
        if (!$this->subscriber) {
            return null;
        }
        return SubscriberData::from(
            $this->subscriber->load('tags', 'form')
        );
    }
}
