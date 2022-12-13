<?php

namespace Domain\Mail\Models\Sequence;

use Domain\Mail\DTOs\Sequence\SequenceData;
use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Concerns\HasUser;
use Domain\Subscriber\Models\Subscriber;
use Spatie\LaravelData\WithData;

class Sequence extends BaseModel
{
    use HasUser, WithData;

    protected $dataClass = SequenceData::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    public function sequenceMails()
    {
        return $this->hasMany(SequenceMail::class);
    }

    public function subscribers()
    {
        return $this->belongsToMany(Subscriber::class);
    }
}
