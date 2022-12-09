<?php

namespace Domain\Subscriber\Models;

use Domain\Shared\Models\BaseModel;
use Domain\Subscriber\DTOs\FormData;
use Spatie\LaravelData\WithData;

class Form extends BaseModel
{
    use WithData;

    protected $dataClass = FormData::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function subscribers()
    {
        return $this->hasMany(Subscriber::class);
    }
}
