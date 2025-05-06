<?php

namespace App\Listeners;

use App\Events\MailTestEvent;
use App\Mail\TestMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class MailTestListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MailTestEvent $event): void
    {
        Mail::to($event->user['email'])->send(new TestMail($event->user));
        echo "Mail Successful";
    }
}
