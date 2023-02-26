<?php

namespace App\Http\Controllers\Traits;
use Illuminate\Support\Facades\Mail;

Trait MailVerificationTrait
{
    private $email = "lufy2024@gmail.com";
    private $msg = "test";


    public function sendMail(){
        Mail::send('email',['msg'=>$this->msg], function ($message){
            $message->from('abdellah.elhilaly.96@gmail.com', 'John Doe');
            $message->to($this->email , 'karmi hacking');
            // $message->replyTo('elaoumarikarim@gmail.com', 'John Doe');
            $message->subject('reset password');
        });
    }
}
