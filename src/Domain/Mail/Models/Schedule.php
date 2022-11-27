<?php

namespace Domain\Mail\Models;

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
        'id' => 'integer',
        'allowed_days' => 'array',
    ];

    public function sequenceMails()
    {
        return $this->hasMany(SequenceMail::class);
    }
}
