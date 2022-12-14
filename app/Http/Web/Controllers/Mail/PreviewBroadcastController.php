<?php

namespace App\Http\Web\Controllers\Mail;

use Domain\Mail\Mails\EchoMail;
use Domain\Mail\Models\Broadcast\Broadcast;
use Domain\Mail\ViewModels\Broadcast\PreviewBroadcastViewModel;
use Inertia\Response;
use Inertia\Inertia;

class PreviewBroadcastController
{
    public function __invoke(Broadcast $broadcast): Response
    {
        return Inertia::render('Broadcast/Preview', [
            'model' => new PreviewBroadcastViewModel(new EchoMail($broadcast))
        ]);
    }
}
