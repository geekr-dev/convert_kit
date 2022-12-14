<?php

namespace Domain\Mail\Models\Sequence;

use Domain\Shared\Models\BaseModel;
use Domain\Subscriber\Models\Subscriber;

class SequenceSubscriber extends BaseModel
{
    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }
}
