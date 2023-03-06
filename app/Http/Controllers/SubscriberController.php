<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionUser;

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
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\SubscriptionUser $subscriptionUser
     */
    public function edit( $subscriptionUser ) {
        return view( 'ms.subscriber.subscriberEdit', compact( 'subscriptionUser' ) );
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
        return view( 'ms.subscriber.subscriberOwnTransaction' );
    }
}
