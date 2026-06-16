<?php

namespace App\Traits;

use Illuminate\Support\Facades\Mail;

trait Email{
    public function sendEmail(string $to, string $subject, string $view, array $data = []): bool {
        try {
            Mail::send($view, $data, function ($message) use ($to, $subject) {
                $message->to($to)
                    ->subject($subject);
            });

            return true;
        } catch (\Throwable $e) {
            report($e);

            return false;
        }
    }
}
