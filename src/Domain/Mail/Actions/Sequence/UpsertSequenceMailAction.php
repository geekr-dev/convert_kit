<?php

namespace Domain\Mail\Actions\Broadcast;

use Domain\Mail\DTOs\Sequence\SequenceData;
use Domain\Mail\DTOs\Sequence\SequenceMailData;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Shared\Models\User;

class UpsertSequenceMailAction
{
    public static function execute(SequenceMailData $data, SequenceData $sequence, User $user): SequenceMail
    {
        return SequenceMail::updateOrCreate(
            [
                'id' => $data->id,
            ],
            [
                ...$data->all(),
                'sequence_id' => $sequence->id,
                'user_id' => $user->id,
            ]
        );
    }
}
