<?php

namespace App\Console\Commands\Subscriber;

use Domain\Shared\Models\User;
use Domain\Subscriber\Jobs\ImportSubscribersJob;
use Illuminate\Console\Command;

class ImportSubscribersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriber:import {user? : The ID of the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import subscribers from csv';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userId = $this->argument('user') ?? $this->ask('User ID');

        ImportSubscribersJob::dispatch(
            storage_path('subscribers/subcribers.csv'),
            User::findOrFail($userId),
        );

        $this->info("Subscribers are being imported...");

        return self::SUCCESS;
    }
}
