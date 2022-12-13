<?php

namespace Domain\Mail\Builders\Sequence;

use Blueprint\Builder;
use Domain\Mail\Enums\Sequence\SequenceMailStatus;

class SequenceMailBuilder extends Builder
{
    public function wherePublished(): self
    {
        return $this->model->whereStatus(SequenceMailStatus::Published);
    }
}
