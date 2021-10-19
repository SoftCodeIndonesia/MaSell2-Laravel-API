<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;


    
    public $title = "Verify your email address";
    public $body = "Please your confirm email.";
    public $code;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->code = rand(10000,99999);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Email Verification From Masell')->view('emailVerify', [
            'title' => $this->title,
            'body' => $this->body,
            'code' => $this->code,
        ]);
    }
}