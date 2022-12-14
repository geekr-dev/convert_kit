<?php

namespace Domain\Automation\DTOs;

use Domain\Automation\Enums\AutomationStepType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Attributes\WithCast;

class AutomationStepData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $automationId,
        #[WithCast(EnumCast::class)]
        public readonly AutomationStepType $type,
        public readonly string $name,
        public readonly string $value,
    ) {
    }
}
