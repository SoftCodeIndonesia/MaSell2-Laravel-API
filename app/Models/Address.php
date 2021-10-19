<?php

namespace App\Models;

use App\Models\Stores;
use App\Models\AddressType;
use App\Models\AddressDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    protected $table = 'address';
    protected $fillable = ['name', 'store_id', 'detail_id','type'];
    

    public function detail()
    {
        return $this->hasOne(AddressDetail::class, 'detail_id', 'detail_id');
    }
    public function type()
    {
        return $this->hasOne(AddressType::class, 'id', 'type');
    }

    public static function message(){
        return [
            'required' => ':attribute is required',
            'string' => ':attribute must be string',
            'integer' => ':attribute must be integer'
        ];
    }

    public static function rules($data = []){
        $define_rules = [
            'name' => ['name' => 'required|string'],
            'store_id' => ['store_id' => 'required|integer'],
            'detail_id' => ['detail_id' => 'required|integer'],
            'type' => [
                'type' => [
                    'required',
                    rule::in([1, 2, 3])
                ]
            ],
        ];
        $rules = [];

        if(empty($data)){
            foreach ($define_rules as $key => $value) {
                $rules += $value;
            };
            return $rules;
        }

        foreach ($data as $key => $value) {
            $rules += $define_rules[$value];
        };
        return $rules;
    }


    public function set($data = [])
    {
       
        $data = (object) $data;
        
        if(isset($data))
        {
            
            if(property_exists($data, 'name'))
                $this->name = $data->name;
            if(property_exists($data, 'store_id'))
                $this->store_id = $data->store_id;
            if(property_exists($data, 'detail_id'))
                $this->detail_id = $data->detail_id;
            
        }

    }

    public function store()
    {
        return $this->belongsTo(Stores::class, 'store_id');
    }

}