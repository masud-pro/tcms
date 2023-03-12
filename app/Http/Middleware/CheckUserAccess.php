<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

class CheckUserAccess {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request                                      $request
     * @param  \Closure(\Illuminate\Http\Request):                           (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle( Request $request, Closure $next, $permission, $guard = null ) {

        $authGuard = app( 'auth' )->guard( $guard );

        if ( $authGuard->guest() ) {
            throw UnauthorizedException::notLoggedIn();
        }

        $user = $authGuard->user();

        // given permissions
        $permissions = is_array( $permission )
            ? $permission
            : explode( '|', $permission );

        if ( $user->hasRole( 'Teacher' ) ) {

            if ( $user->subscription === null ) {
                abort( 403, 'No Subscription' );
            }

            if ( $user->subscription->status == false ) {
                abort( 403, 'You have been blocked, please contact the software author' );
            }

            if ( Carbon::parse( $user->subscription->expiry_date )->isPast() ) {
                // abort( 403, 'Subscription Expired' );

                 session()->flash( 'renew', 'Subscription Expired, Please Renew Your Subscription..' );
                 return redirect()->route( 'subscriber.subscription.renew');
            }

            $subscriptionPermission = explode( ',', $user->subscription->subscription->selected_feature );

            foreach ( $permissions as $permission ) { // checks if the subscription has permissions
                if ( !in_array( $permission, $subscriptionPermission ) ) {
                    abort( 403, 'Upgrade Plan' );
                }
            }

            foreach ( $permissions as $permission ) { // checks if the user has permissions
                if ( $user->can( $permission ) ) {
                    return $next( $request );
                }
            }

            abort( 403, 'You are unauthorized for this action' );

        } else {
            foreach ( $permissions as $permission ) {
                if ( $user->can( $permission ) ) {
                    return $next( $request );
                }
            }
        }

        return abort( 403, 'Unauthorized Action' );
        // return $next( $request );
    }
}