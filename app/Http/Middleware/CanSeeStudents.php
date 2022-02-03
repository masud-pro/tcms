<?php

namespace App\Http\Middleware;

use App\Models\Option;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CanSeeStudents {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle( Request $request, Closure $next ) {

        if( Auth::user()->role == "Admin" ){
            return $next( $request );
        }

        if( Option::where("slug","can_student_see_friends")->first()->value ){
            return $next( $request );
        }

        abort(403);

    }
}
