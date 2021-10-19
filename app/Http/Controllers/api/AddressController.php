<?php

namespace App\Http\Controllers\api;

use App\Models\Stores;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Models\AddressDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
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
        $address = new Address;
        $address_detail = new AddressDetail;
        $stores = new Stores;

        $validator = Validator::make($request->all(), Address::rules(['name', 'store_id']), Stores::message());

        if($validator->fails()) return badResponse($validator->errors()->first());
        
        $validator = Validator::make($request->all(), AddressDetail::rules(), AddressDetail::message());

        if($validator->fails()) return badResponse($validator->errors()->first());

        $address->set($request->all());

        $address_detail->set($request->all());

        $stores->set($request->all());

        $affected = $address_detail->save();


        if(!$affected) return badResponse('Failed inserting data detail address!');

        $address->detail_id = $address_detail->detail_id;

        $affected = $address->save();

        if(!$affected) badResponse('Failed inserting data address!');

        
        return response_ok($stores->fetchComplited());

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        //
    }
}