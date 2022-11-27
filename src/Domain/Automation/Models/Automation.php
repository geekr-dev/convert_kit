<?php

namespace Domain\Automation\Models;

use Domain\Shared\Models\BaseModel;

class Automation extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function automationSteps()
    {
        return $this->hasMany(AutomationStep::class);
    }
}
