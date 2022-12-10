<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubAccountRequest;
use App\Http\Requests\UpdateSubAccountRequest;
use App\Models\SubAccount;

class SubAccountController extends Controller
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
     * @param  \App\Http\Requests\StoreSubAccountRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubAccountRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubAccount  $subAccount
     * @return \Illuminate\Http\Response
     */
    public function show(SubAccount $subAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubAccount  $subAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(SubAccount $subAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubAccountRequest  $request
     * @param  \App\Models\SubAccount  $subAccount
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubAccountRequest $request, SubAccount $subAccount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubAccount  $subAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubAccount $subAccount)
    {
        //
    }
}
