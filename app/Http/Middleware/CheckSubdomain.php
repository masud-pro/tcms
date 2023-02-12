<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSubdomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if($user->hasRole('Teacher')){
            $domainToBe = getToBeSubdomain(getUsername());
            if( request()->root() !== $domainToBe ){
                auth('web')->logout();
                return redirect('/login');
            }
        }elseif( $user->teacher_id ){
            // dd($user->teacher);
            $domainToBe = getToBeSubdomain(getUsername());
            if( request()->root() !== $domainToBe ){
                auth('web')->logout();
                return redirect('/login');
            }
        }

        return $next($request);
    }
}
