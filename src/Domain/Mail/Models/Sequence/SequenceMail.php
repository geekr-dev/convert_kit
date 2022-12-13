<?php

namespace Domain\Mail\Models\Sequence;

use Domain\Mail\Builders\Sequence\SequenceMailBuilder;
use Domain\Mail\Contracts\Sendable;
use Domain\Mail\DTOs\FilterData;
use Domain\Mail\DTOs\Sequence\SequenceMailData;
use Domain\Mail\Enums\Sequence\SequenceMailStatus;
use Domain\Mail\Models\Casts\FilterCast;
use Domain\Mail\Models\SentMail;
use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Concerns\HasUser;
use Spatie\LaravelData\WithData;
use Illuminate\Support\Str;

class SequenceMail extends BaseModel implements Sendable
{
    use WithData, HasUser;

    protected $dataClass = SequenceMailData::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject',
        'content',
        'filters',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'filters' => FilterCast::class,
        'status' => SequenceMailStatus::class,
    ];

    public function id(): int
    {
        return $this->id;
    }

    public function type(): string
    {
        return $this::class;
    }

    public function subject(): string
    {
        return $this->subject;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function sequence()
    {
        return $this->belongsTo(Sequence::class);
    }

    public function filters(): FilterData
    {
        return $this->filters;
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function sentMails()
    {
        return $this->morphMany(SentMail::class, 'sendable');
    }

    public function shouldSendToday(): bool
    {
        $dayName = Str::lower(now()->dayName);
        return $this->schedule->allowed_days->{$dayName};
    }

    public function enoughTimePassedSince(SentMail $mail): bool
    {
        return $this->schedule->unit
            ->timePassSince($mail->sent_at) >= $this->schedule->delay;
    }

    public function newEloquentBuilder($query): SequenceMailBuilder
    {
        return new SequenceMailBuilder($query);
    }
}
