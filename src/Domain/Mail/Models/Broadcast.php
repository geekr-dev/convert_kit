<?php

namespace Domain\Mail\Models;

use Domain\Shared\Models\BaseModel;

class Broadcast extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'filters',
        'status',
        'sent_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'filters' => 'array',
        'sent_at' => 'timestamp',
    ];

    public function sentMails()
    {
        return $this->morphMany(SentMail::class, 'sendable');
    }
    
}
