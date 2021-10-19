<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressDetail extends Model
{
    use HasFactory;

    protected $table = 'address_detail';
    protected $primaryKey = 'detail_id';

    protected $fillable = ['province_id', 'province_name', 'city_id', 'city_name', 'district_id', 'district_name', 'post_code', 'detail'];

    public static $rules = [
        'province_id' => ['province_id' => 'required|integer'],
        'province_name' => ['province_name' => 'required|string'],
        'city_id' => ['city_id' => 'required|integer'],
        'city_name' => ['city_name' => 'required|string'],
        'district_id' => ['district_id' => 'required|integer'],
        'district_name' => ['district_name' => 'required|string'],
        'post_code' => ['post_code' => 'required|integer'],
        'detail' => ['detail' => 'required|string'],
    ];
    
    
    public function set($data = []){
        $data = (object) $data;

        if(isset($data)){
            if(property_exists($data, 'province_id'))
                $this->province_id = $data->province_id;
            if(property_exists($data, 'province_name'))
                $this->province_name = $data->province_name;
            if(property_exists($data, 'city_id'))
                $this->city_id = $data->city_id;
            if(property_exists($data, 'city_name'))
                $this->city_name = $data->city_name;
            if(property_exists($data, 'district_id'))
                $this->district_id = $data->district_id;
            if(property_exists($data, 'district_name'))
                $this->district_name = $data->district_name;
            if(property_exists($data, 'post_code'))
                $this->post_code = $data->post_code;
            if(property_exists($data, 'detail'))
                $this->detail = $data->detail;
        }
    }

    public static function message(){
        return [
            'required' => ':attribute is required',
            'string' => ':attribute must be string',
            'integer' => ':attribute must be integer'
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