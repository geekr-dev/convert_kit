<?php

namespace Domain\Mail\Models;

use Domain\Shared\Models\BaseModel;
use Domain\Subscriber\Models\Subscriber;

class SentMail extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sendable_id',
        'sendable_type',
        'subscriber_id',
        'sent_at',
        'opened_at',
        'clicked_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'sendable_id' => 'integer',
        'subscriber_id' => 'integer',
        'sent_at' => 'timestamp',
        'opened_at' => 'timestamp',
        'clicked_at' => 'timestamp',
    ];

    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }
}
