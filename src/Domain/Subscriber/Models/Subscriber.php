<?php

namespace Domain\Subscriber\Models;

use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Concerns\HasUser;
use Domain\Subscriber\Builders\SubscriberBuilder;
use Domain\Subscriber\DTOs\SubscriberData;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Spatie\LaravelData\WithData;

class Subscriber extends BaseModel
{
    use Notifiable;
    use HasUser;
    use WithData;

    protected $dataClass = SubscriberData::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'form_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'subscribed_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class)->withDefault();
    }

    public function receivedMails(): HasMany
    {
        return $this->hasMany(SentMail::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function sequence()
    {
        return $this->belongsToMany(Sequence::class);
    }

    public function fullName(): Attribute
    {
        return new Attribute(
            get: fn () => "{$this->first_name} {$this->last_name}",
        );
    }

    // 最新收到的邮件
    public function lastReceivedMail(): HasOne
    {
        return $this->hasOne(SentMail::class)
            ->latestOfMany()
            ->withDefault();
    }

    public function tooEarlyFor(SequenceMail $mail): bool
    {
        return !$mail->enoughTimePassedSince(
            $this->lastReceivedMail
        );
    }

    public function newEloquentBuilder($query): SubscriberBuilder
    {
        return new SubscriberBuilder($query);
    }
}
