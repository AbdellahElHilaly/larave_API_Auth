<?php

namespace App\Traits\Auth;
use Illuminate\Support\Facades\Mail;

Trait MailVerificationTrait
{
    private $email = "lufy2024@gmail.com";
    private $msg = "test";


    public function sendMail(){
        Mail::send('email',['msg'=>$this->msg], function ($message){
            $message->from('abdellah.elhilaly.96@gmail.com', 'Stack Masters');
            $message->to($this->email , 'karmi hacking');
            $message->replyTo('abdellah.elhilaly.96@gmail.com', 'Stack Masters');
            $message->subject('reset password');
        });
    }
}
