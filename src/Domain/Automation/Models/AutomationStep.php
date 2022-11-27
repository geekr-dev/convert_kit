<?php

namespace Domain\Automation\Models;

use Domain\Shared\Models\BaseModel;

class AutomationStep extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'automation_id',
        'type',
        'name',
        'value',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'automation_id' => 'integer',
        'value' => 'array',
    ];

    public function automation()
    {
        return $this->belongsTo(Automation::class);
    }
}
