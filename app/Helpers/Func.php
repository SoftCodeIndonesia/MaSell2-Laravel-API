<?php

namespace App\Http\Helper;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\Providers\Auth;
use Illuminate\Http\JsonResponse;


if(!function_exists('responseOk')){
    function responseOk($data)
    {
        return Response()->json([
            'status' => true,
            'payload' => $data,
            'message' => 'success'
        ]);
    }
}