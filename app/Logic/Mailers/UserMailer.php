<?php namespace App\Logic\Mailers;

class UserMailer extends Mailer {

    public function verify($nip, $data)
    {
        $view       = 'nips.activate-link';
        $subject    = $data['subject'];
        $fromEmail  = 'jeremykenedy@gmail.com';

        $this->sendTo($nip, $subject, $fromEmail, $view, $data);
    }

    public function passwordReset($nip, $data)
    {
        $view       = 'nips.password-reset';
        $subject    = $data['subject'];
        $fromEmail  = 'jeremykenedy@gmail.com';

        $this->sendTo($nip, $subject, $fromEmail, $view, $data);
    }

}