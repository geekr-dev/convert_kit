<?php

namespace Domain\Mail\DTOs\Sequence;

use Spatie\LaravelData\Data;

class SequenceMailScheduleAllowedDaysData extends Data
{
    public function __construct(
        public readonly bool $monday,
        public readonly bool $tuesday,
        public readonly bool $wednesday,
        public readonly bool $thursday,
        public readonly bool $friday,
        public readonly bool $saturday,
        public readonly bool $sunday,
    ) {
    }

    public static function empty(array $extra = []): array
    {
        return (new self(true, true, true, true, true, true, true))->toArray();
    }
}
