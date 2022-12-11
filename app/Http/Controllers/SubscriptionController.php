<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;

class SubscriptionController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view( 'ms.subscription.index' );
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create() {
        return view( 'ms.subscription.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreSubscriptionRequest $request
     */
    public function store( StoreSubscriptionRequest $request ) {
        $data = $request->validated();
        Subscription::create( $data );

        return redirect()->route( 'subscription.index' );

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Subscription $subscription
     */
    public function show( Subscription $subscription ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Subscription $subscription
     */
    public function edit( Subscription $subscription ) {
        return view( 'ms.subscription.edit', compact( 'subscription' ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateSubscriptionRequest $request
     * @param \App\Models\Subscription                     $subscription
     */
    public function update( UpdateSubscriptionRequest $request, Subscription $subscription ) {
        $data = $request->validated();
        $subscription->update( $data );
        return redirect()->route( 'subscription.index' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Subscription $subscription
     */
    public function destroy( Subscription $subscription ) {
        //
    }
}