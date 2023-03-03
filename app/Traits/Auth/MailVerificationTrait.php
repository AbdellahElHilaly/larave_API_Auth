<?php

namespace App\Traits\Auth;
use Illuminate\Support\Facades\Mail;

Trait MailVerificationTrait
{

    public function sendMail($email , $secret){
        Mail::send('email',['activationCode'=>$this->secret], function ($message){
            $message->from('abdellah.elhilaly.96@gmail.com', 'You Code');
            $message->to($this->email , 'karmi hacking');
            $message->replyTo('abdellah.elhilaly.96@gmail.com', 'You Code');
            $message->subject('reset password');
        });
    }
}
