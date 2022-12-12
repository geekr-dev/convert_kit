<?php

namespace Domain\Mail\Models\Broadcast;

use Domain\Mail\DTOs\Broadcast\BroadcastData;
use Domain\Mail\DTOs\FilterData;
use Domain\Mail\Enums\Broadcast\BroadcastStatus;
use Domain\Mail\Models\Casts\FilterCast;
use Domain\Mail\Models\SentMail;
use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Concerns\HasUser;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\LaravelData\WithData;

class Broadcast extends BaseModel
{
    use WithData;
    use HasUser;

    protected $dataClass = BroadcastData::class;

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
        'filters' => FilterCast::class,
        'status' => BroadcastStatus::class,
    ];

    protected $attributes = [
        'status' => BroadcastStatus::Draft,  // 默认值
    ];

    public function sentMails()
    {
        return $this->morphMany(SentMail::class, 'sendable');
    }

    /*public function filters(): Attribute
    {
        return new Attribute(
            get: fn (string $value) => FilterData::from(json_decode($value, true)),
            set: fn (FilterData $value) => json_encode($value),
        );
    }*/
}
