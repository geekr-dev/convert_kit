<?php

namespace Domain\Mail\Models\Sequence;

use Domain\Mail\DTOs\Sequence\SequenceMailData;
use Domain\Mail\Enums\Sequence\SequenceMailStatus;
use Domain\Mail\Models\Casts\FilterCast;
use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Concerns\HasUser;
use Spatie\LaravelData\WithData;

class SequenceMail extends BaseModel
{
    use WithData, HasUser;

    protected $dataClass = SequenceMailData::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject',
        'content',
        'filters',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'filters' => FilterCast::class,
        'status' => SequenceMailStatus::class,
    ];

    public function sequence()
    {
        return $this->belongsTo(Sequence::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function sentMails()
    {
        return $this->morphMany(SentMail::class, 'sendable');
    }
}
