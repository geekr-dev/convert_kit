<?php

namespace Domain\Automation\Models;

use Domain\Automation\DTOs\AutomationData;
use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Concerns\HasUser;

class Automation extends BaseModel
{
    use HasUser;

    protected $dataClass = AutomationData::class;

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

    public function steps()
    {
        return $this->hasMany(AutomationStep::class);
    }
}
