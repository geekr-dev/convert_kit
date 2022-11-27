<?php

namespace App\Models;

use Domain\Shared\Models\BaseModel;

class SequenceMail extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject',
        'status',
        'content',
        'filters',
        'sequence_id',
        'schedule_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'filters' => 'array',
        'sequence_id' => 'integer',
        'schedule_id' => 'integer',
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