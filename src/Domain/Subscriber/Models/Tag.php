<?php

namespace Domain\Subscriber\Models;

use Domain\Shared\Models\BaseModel;
use Domain\Subscriber\DTOs\TagData;
use Spatie\LaravelData\WithData;

class Tag extends BaseModel
{
    use WithData;

    protected $dataClass = TagData::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
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
        return $this->belongsToMany(Subscriber::class);
    }
}
