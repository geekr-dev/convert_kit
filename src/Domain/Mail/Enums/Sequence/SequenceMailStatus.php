<?php

namespace Domain\Mail\Enums\Sequence;

enum SequenceMailStatus: string
{
    case Draft = 'draft';
    case Published = 'published';

    public function isPublished(): bool
    {
        return match ($this) {
            self::Draft => false,
            self::Published => true,
        };
    }
}
