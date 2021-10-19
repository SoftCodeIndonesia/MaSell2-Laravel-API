<?php

use App\Models\Seller;

if(!function_exists('response_ok')){
    function response_ok($data)
    {
        return Response()->json([
            'status' => true,
            'message' => is_null($data) ? 'Data is empty!' : 'Success',
            'payload' => $data,
        ],200);
    }
}
if(!function_exists('badResponse')){
    function badResponse($message)
    {
        return Response()->json([
            'status' => false,
            'message' => $message
        ],400);
    }
}

if(!function_exists('generateId')){
    function generateId()
    {
        $id = 'IDS.' . Date('d') . Date('m') . Date('Y') . '.' . time() . '-';
        $seller = Seller::orderByDesc('registerAt')->get()->first();

        if($seller == null){
            $id = $id . '00001';
        }else{
            $explode = explode('-', $seller->getAttributes()['sellerId']);

            $nextId = (int) end($explode) + 1;

            $uniqId = str_pad($nextId, 5, '0', STR_PAD_LEFT);

            $id = $id . $uniqId; 
        }
       
        return $id;
       
    }
}