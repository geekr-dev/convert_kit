<?php

namespace Domain\Mail\ViewModels\Sequence;

use Domain\Mail\DataTransferObjects\Sequence\SequenceProgressData;
use Domain\Mail\DTOs\PerformanceData;
use Domain\Mail\DTOs\Sequence\SequenceData;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Shared\ViewModels\ViewModel;
use Illuminate\Support\Collection;

class GetSequenceReportsViewModel extends ViewModel
{
    public function __construct(
        private readonly Sequence $sequence
    ) {
    }

    // 序列数据
    public function sequence(): SequenceData
    {
        return $this->sequence->getData();
    }

    // 序列总统计数据
    public function totalPerformance(): PerformanceData
    {
        return $this->sequence->performance();
    }

    /**
     * 序列邮件统计数据
     * @return Collection<int, TrackingData>
     */
    public function mailPerformances(): Collection
    {
        return $this->sequence->mails
            ->mapWithKeys(fn (SequenceMail $mail) => [
                $mail->id => $mail->performance()
            ]);
    }

    // 序列进度统计数据
    public function progress(): SequenceProgressData
    {
        return new SequenceProgressData(
            total: $this->sequence->activeSubscriberCount(),
            inProgress: $this->sequence->inProgressSubscriberCount(),
            completed: $this->sequence->completedSubscriberCount(),
        );
    }
}
