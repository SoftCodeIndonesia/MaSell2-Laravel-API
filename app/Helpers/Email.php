<?php

namespace App\Helpers;

use App\Mail\EmailVerification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class Email extends Controller
{
    
    public $mailType;
    public $to;

    public const verification = 'EmailVerification';


    function __construct($data)
    {
        $this->set($data);
    }

    private function set($data){
        $data = (object) $data;

        if(isset($data)){
            if(property_exists($data, 'to'))
                $this->to = $data->to;
            if(property_exists($data, 'mailType')){
                $this->mailType = $data->mailType;
            }
        }
    }

    public function send()
    {
        $emailClass;
        
        switch ($this->mailType) {
            case Email::verification:
                $emailClass = new EmailVerification;
                break;
            
            default:
                # code...
                break;
        }

        Mail::to($this->to)->send($emailClass);
        
    }
}
    