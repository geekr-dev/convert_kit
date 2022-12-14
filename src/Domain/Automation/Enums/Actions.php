<?php

namespace Domain\Automation\Actions;

enum Actions: string
{
    case AddToSequence = 'addToSequence';
    case AddTag = 'addTag';

    public function createAction()
    {
        return match ($this) {
            self::AddTag => app(AddTagAction::class),
            self::AddToSequence => app(AddToSequenceAction::class),
        };
    }
}
