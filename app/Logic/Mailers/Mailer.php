<?php namespace App\Logic\Mailers;

abstract class Mailer {

    public function sendTo($nip, $subject, $fromEmail, $view, $data = [])
    {
        \Mail::queue($view, $data, function($message) use($nip, $subject, $fromEmail)
        {

            $message->from($fromEmail, env('MAIL_USERNAME'));

            $message->to($nip)->subject($subject);
        });
    }
}