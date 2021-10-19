<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Seller extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'seller';
    protected $hidden = ['remember_token','deviceId','password','emailVerifyIdExpired','emailVerifyId'];
    protected $fillable = ['sellerId','username','email','emailVerify','emailVerifyId','emailVerifyIdExpired','countryCode','country','registerAt','deviceId','isActived','created_at','password','avatarUrl'
    ];
    

    public function __construct($data = [])
    {
        $this->set($data);
    }
    

    public function set($data = [])
    {
       
        $data = (object) $data;
        
        if(isset($data))
        {
            if(property_exists($data, 'sellerId'))
                $this->sellerId = $data->sellerId;
            if(property_exists($data, 'username'))
                $this->username = $data->username;
            if(property_exists($data, 'avatarUrl'))
                $this->avatarUrl = $data->avatarUrl;
            if(property_exists($data, 'email'))
                $this->email = $data->email;
            if(property_exists($data, 'emailVerify'))
                $this->emailVerify = $data->emailVerify;
            if(property_exists($data, 'emailIsVerifyAt'))
                $this->emailIsVerifyAt = $data->emailIsVerifyAt;
            if(property_exists($data, 'password'))
                $this->password = $data->password;
            if(property_exists($data, 'countryCode'))
                $this->countryCode = $data->countryCode;
            if(property_exists($data, 'isActived'))
                $this->isActived = $data->isActived;
            if(property_exists($data, 'deviceId'))
                $this->deviceId = $data->deviceId;
            if(property_exists($data, 'registerAt'))
                $this->registerAt = $data->registerAt;
            if(property_exists($data, 'avatarUrl'))
                $this->avatarUrl = $data->avatarUrl;
            
        }

    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}