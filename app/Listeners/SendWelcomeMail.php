<?php

namespace App\Listeners;

use App\Mail\WelcomeMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendWelcomeMail as SendWelcomeMailJob;

class SendWelcomeMail
{
    public function handle(Registered $event)
    {
        try {
            SendWelcomeMailJob::dispatch($event->user);
        } catch (\Throwable $e) {
            \Log::error('Welcomeメール送信エラー: ' . $e->getMessage());
        }
    }
}
