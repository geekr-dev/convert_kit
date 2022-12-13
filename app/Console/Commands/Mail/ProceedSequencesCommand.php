<?php

namespace App\Console\Commands\Mail;

use Domain\Mail\Actions\Sequence\ProceedSequenceAction;
use Domain\Mail\Enums\Sequence\SequenceStatus;
use Domain\Mail\Jobs\Sequence\ProceedSequenceJob;
use Domain\Mail\Models\Sequence\Sequence;
use Illuminate\Console\Command;

class ProceedSequencesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sequence:proceed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send the next mail in sequences';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $count = Sequence::with('mails.schedule')
            ->whereStatus(SequenceStatus::Published)
            ->get()
            ->each(
                fn (Sequence $sequence) =>
                ProceedSequenceJob::dispatch($sequence)
            )
            ->count();

        $this->info("{$count} sequences are being proceeded");

        return self::SUCCESS;
    }
}
