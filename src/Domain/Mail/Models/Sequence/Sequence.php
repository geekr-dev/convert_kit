<?php

namespace Domain\Mail\Models\Sequence;

use Domain\Shared\Models\BaseModel;

class Sequence extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function sequenceMails()
    {
        return $this->hasMany(SequenceMail::class);
    }
}
