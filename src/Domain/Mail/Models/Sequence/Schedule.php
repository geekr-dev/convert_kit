<?php

namespace Domain\Mail\Models\Sequence;

use Domain\Mail\Models\Casts\Sequence\SequenceMailScheduleAllowedDaysCast;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Shared\Models\BaseModel;

class Schedule extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'delay',
        'unit',
        'allowed_days',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'allowed_days' => SequenceMailScheduleAllowedDaysCast::class,
    ];

    public function sequenceMails()
    {
        return $this->hasMany(SequenceMail::class);
    }
}
