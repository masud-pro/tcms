<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionUser;
use App\Http\Requests\StoreSubscriptionUserRequest;
use App\Http\Requests\UpdateSubscriptionUserRequest;

class SubscriberController extends Controller {
    /**
     * Display a listing of the resource.
     *
     */
    public function index() {
        return view( 'ms.subscriber.subscriberIndex' );
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create() {
        return view( 'ms.subscriber.subscriberCreate' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreSubscriptionUserRequest $request
     */
    public function store( StoreSubscriptionUserRequest $request ) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\SubscriptionUser $subscriptionUser
     */
    public function show( SubscriptionUser $subscriptionUser ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\SubscriptionUser $subscriptionUser
     */
    public function edit( $subscriptionUser ) {
        return view( 'ms.subscriber.subscriberEdit', compact( 'subscriptionUser' ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateSubscriptionUserRequest $request
     * @param \App\Models\SubscriptionUser                     $subscriptionUser
     */
    public function update( UpdateSubscriptionUserRequest $request, SubscriptionUser $subscriptionUser ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\SubscriptionUser $subscriptionUser
     */
    public function destroy( SubscriptionUser $subscriptionUser ) {
        //
    }

    /**
     * this method is for subscriber transaction list ..
     *
     */
    public function subscriberTransaction() {
        return view( 'ms.subscriber.subscriberTransaction' );
    }

    public function subscriberSubscriptionRenew() {
        return view( 'ms.subscriber.subscriberSubscriptionRenew' );
    }

    public function subscriberOwnTransaction() {
        return view('ms.subscriber.subscriberOwnTransaction' );
    }
}