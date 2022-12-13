<?php

namespace Domain\Mail\DTOs\Sequence;

use Domain\Mail\DTOs\FilterData;
use Domain\Mail\Enums\Sequence\SequenceMailStatus;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;

class SequenceMailData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $subject,
        public readonly string $content,
        public readonly ?FilterData $filters,
        #[WithCast(EnumCast::class)]
        public readonly SequenceMailStatus $status = SequenceMailStatus::Draft,
        public readonly array $schedule,
    ) {
    }

    public static function dummy(): self
    {
        return self::from([
            'subject' => 'My Awesome E-mail',
            'content' => 'My Awesome Content',
            'status' => SequenceMailStatus::Draft,
            'filters' => FilterData::empty(),
            'schedule' => [
                'delay' => 1,
                'unit' => 'day',
                'allowed_days' =>
                SequenceMailScheduleAllowedDaysData::empty(),
            ]
        ]);
    }
}
