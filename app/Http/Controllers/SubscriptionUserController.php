<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscriptionUserRequest;
use App\Http\Requests\UpdateSubscriptionUserRequest;
use App\Models\SubscriptionUser;

class SubscriptionUserController extends Controller
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
     * @param  \App\Http\Requests\StoreSubscriptionUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubscriptionUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubscriptionUser  $subscriptionUser
     * @return \Illuminate\Http\Response
     */
    public function show(SubscriptionUser $subscriptionUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubscriptionUser  $subscriptionUser
     * @return \Illuminate\Http\Response
     */
    public function edit(SubscriptionUser $subscriptionUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubscriptionUserRequest  $request
     * @param  \App\Models\SubscriptionUser  $subscriptionUser
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubscriptionUserRequest $request, SubscriptionUser $subscriptionUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubscriptionUser  $subscriptionUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubscriptionUser $subscriptionUser)
    {
        //
    }
}
