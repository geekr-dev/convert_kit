<?php

namespace Domain\Mail\DTOs\Sequence;

use Spatie\LaravelData\Data;

class SequenceData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $title,
    ) {
    }
}
