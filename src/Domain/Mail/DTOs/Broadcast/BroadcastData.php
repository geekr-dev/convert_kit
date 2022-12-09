<?php

namespace Domain\Mail\DTOs\Broadcast;

use Carbon\Carbon;
use Domain\Mail\DTOs\FilterData;
use Domain\Mail\Enums\Broadcast\BroadcastStatus;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\WithCast;

class BroadcastData extends Data
{
    public function __construct(
        private readonly ?int $id,
        public readonly string $subject,
        public readonly string $content,
        public readonly ?FilterData $filters,
        public readonly ?Carbon $sent_at,
        #[WithCast(EnumCast::class)]
        public readonly ?BroadcastStatus $status = BroadcastStatus::Draft,
    ) {
    }
}
