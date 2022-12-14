<?php

namespace Domain\Mail\Models\Sequence;

use Domain\Shared\Models\BaseModel;

class SequenceSubscriber extends BaseModel
{
    public function subscriber()
    {
        return $this->belongsTo(Sequence::class);
    }
}
