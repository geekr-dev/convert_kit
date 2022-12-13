<?php

namespace Domain\Mail\Actions\Sequence;

use Domain\Mail\Actions\Broadcast\UpsertSequenceMailAction;
use Domain\Mail\DTOs\Sequence\SequenceData;
use Domain\Mail\DTOs\Sequence\SequenceMailData;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Shared\Models\User;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Support\Facades\DB;

class CreateSequenceAction
{
    public static function execute(SequenceData $data, User $user): Sequence
    {
        return DB::transaction(function () use ($data, $user) {
            // 创建 Sequence
            $sequence = Sequence::create([
                ...$data->all(),
                'user_id' => $user->id,
            ]);

            // 创建 SequenceMail
            UpsertSequenceMailAction::execute(
                SequenceMailData::dummy(),
                $sequence,
                $user
            );

            // 插入记录到 sequence_subscribers
            $sequence->subscribers()->sync(
                Subscriber::select('id')->pluck('id')
            );

            return $sequence;
        });
    }
}
