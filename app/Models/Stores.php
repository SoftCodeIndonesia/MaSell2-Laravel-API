<?php

namespace App\Models;

use App\Models\Seller;
use App\Models\Stores;
use App\Models\Address;
use App\Models\Platforms;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Contracts\Providers\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stores extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'sellerId', 'logo', 'platformId'];
    protected $table = 'stores';
    protected $primaryKey = 'storeId';

    protected $attributes = [
        'name' => null,
        'sellerId' => null,
        'logo' => null,
        'platformId' => null,
    ];

    public static $response = [];

    public static $cond = [];

    public static $rules = [
        'name' => ['name' => 'required|string'],
        'storeId' => ['storeId' => 'required'],
        'logo' => ['logo' => 'required'],
        'platformId' => ['platformId' => 'required']
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
            $this->sellerId = auth('seller-api')->user()->sellerId;
            
            if(property_exists($data, 'name'))
                $this->name = $data->name;
            if(property_exists($data, 'storeId'))
                $this->storeId = $data->storeId;
            if(property_exists($data, 'logo'))
                $this->logo = $data->logo;
            if(property_exists($data, 'platformId'))
                $this->platformId = $data->platformId;
            
        }

    }

    public function fetchComplited(){

        if($this->storeId != null){
            return Stores::with(['platform','seller', 'address.detail'])->where('storeId', $this->storeId)->first();
        }else{
            return Stores::with(['platform','seller', 'address.detail'])->get();
        }
        
    }

    public function platform()
    {
        return $this->hasOne(Platforms::class, 'platformId', 'platformId');
    }
    
    
    public function seller()
    {
        return $this->hasOne(Seller::class, 'sellerId', 'sellerId');
    }

    public function address()
    {
        return $this->hasMany(Address::class, 'store_id', 'storeId');
    }
    

    public static function message(){
        return [
            'required' => ':attribute is required',
            'string' => ':attribute must be string'
        ];
    }

    public static function rules($data = []){
        $rules = [];

        if(empty($data)){
            foreach (self::$rules as $key => $value) {
                $rules += $value;
            };
            return $rules;
        }

        foreach ($data as $key => $value) {
            $rules += self::$rules[$value];
        };
        return $rules;
    }
    
}