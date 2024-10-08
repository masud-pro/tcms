<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware {
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/pay-via-ajax',
        '/success',
        '/cancel',
        '/fail',
        '/ipn',
        '/aamarpay-success',
        '/aamarpay-fail',
        '/subscription/success',
        '/subscription/failed',
        '/subscription/cancel',
        '/sms/success',
        '/sms/failed',
        '/sms/cancel',
        '/renew/success',
        '/renew/failed',
        '/renew/cancel',
    ];
}