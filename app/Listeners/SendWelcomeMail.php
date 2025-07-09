<?php

namespace App\Listeners;

use App\Mail\WelcomeMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;

class SendWelcomeMail
{
    public function handle(Registered $event)
    {
        try {
            Mail::to($event->user->email)->send(new WelcomeMail($event->user));
        } catch (\Throwable $e) {
            \Log::error('Welcomeメール送信エラー: ' . $e->getMessage());
        }
    }
}
