<?php

namespace Domain\Mail\Models\Casts\Sequence;

use Domain\Mail\DTOs\Sequence\SequenceMailScheduleAllowedDaysData;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class SequenceMailScheduleAllowedDaysCast implements CastsAttributes
{
    public function get($model, $key, $value, array $attributes)
    {
        return SequenceMailScheduleAllowedDaysData::from(
            json_decode($value, true)
        );
    }

    public function set($model, $key, $value, array $attributes)
    {
        return [
            'allowed_days' => json_encode($value),
        ];
    }
}
