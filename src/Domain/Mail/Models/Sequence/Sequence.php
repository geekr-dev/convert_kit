<?php

namespace Domain\Mail\Models\Sequence;

use Domain\Mail\Builders\Sequence\SequenceBuilder;
use Domain\Mail\DTOs\Sequence\SequenceData;
use Domain\Mail\Models\Concerns\HasPerformance;
use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Concerns\HasUser;
use Domain\Shared\VOs\Percent;
use Spatie\LaravelData\WithData;

class Sequence extends BaseModel
{
    use HasUser, WithData, HasPerformance;

    protected $dataClass = SequenceData::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    public function mails()
    {
        return $this->hasMany(SequenceMail::class);
    }

    public function totalInstances(): int
    {
        return $this->activeSubscriberCount();
    }

    public function openRate(int $total): Percent
    {
        $count = 0;
        $total = 0;
        foreach ($this->mails()->wherePublished()->get() as $mail) {
            $count += $mail->sentMails()->whereOpened()->count();
            $total += $mail->totalInstances();
        }
        return Percent::from($count, $total);
    }

    public function clickRate(int $total): Percent
    {
        $count = 0;
        $total = 0;
        foreach ($this->mails()->wherePublished()->get() as $mail) {
            $count += $mail->sentMails()->whereClicked()->count();
            $total += $mail->totalInstances();
        }
        return Percent::from($count, $total);
    }

    public function subscribers()
    {
        return $this->hasMany(SequenceSubscriber::class);
    }

    public function newEloquentBuilder($query): SequenceBuilder
    {
        return new SequenceBuilder($query);
    }
}
