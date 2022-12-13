<?php

namespace Domain\Mail\Enums\Sequence;

enum SequenceStatus: string
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
