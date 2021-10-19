<?php

namespace App\Http\Controllers\api;

use File;
use App\Models\Stores;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResources;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class StoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), Stores::rules(['name']), Stores::message());

        if($validator->fails()) return badResponse($validator->errors()->first());
        
        $stores = new Stores;
        
        $stores->set($request->all());

        if(!empty($request->file('logo'))){
            $stores->logo = $request->file('logo')->store('store/logo', 'public');
        }

        $affected = $stores->save();

        if(!$affected) return badResponse('Failed inserting data');

        return response_ok($stores->fetchComplited());

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stores  $stores
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        
        $stores = new Stores;
        
        $stores->set($request->all());
        
        return response_ok($stores->fetchComplited());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stores  $stores
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stores  $stores
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), Stores::rules(['storeId']), Stores::message());

        if($validator->fails()) return badResponse($validator->errors()->first());
        
        $stores = new Stores;
        
        $stores->storeId = $request->get('storeId');

        $stores = $stores->fetchComplited();
        
        $stores->set($request->all());
        
        $affected = $stores->save();

        if(!$affected) return badResponse('Failed updating data');

        return response_ok($stores->fetchComplited());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stores  $stores
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {  
        $validator = Validator::make($request->all(), Stores::rules(['storeId']), Stores::message());

        if($validator->fails()) return badResponse($validator->errors()->first());

        $stores = new Stores;

        $storeId = $request->get('storeId');

        foreach ($storeId as $key => $value) {
            
            $stores->storeId = $value;

            $data = $stores->fetchComplited();

            $affected = Stores::destroy($value);

            if($affected) Storage::disk('public')->delete($data->logo);
            
        }

        return response_ok([]);
    }
}