<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (isset(Auth::user()->id) && Auth::user()->role == USER_ROLE_ADMIN && Auth::user()->active_status == STATUS_SUCCESS) {
            if (Auth::user()->email_verified == STATUS_SUCCESS) {
                return $next($request);
            } else {
                Auth::logout();
                return redirect()->route('login')->with('dismiss', __('Your mail is not verified. please verify your email.'));
            }
        } else {
            Auth::logout();
            return redirect()->route('login')->with('dismiss', __('You are not authorised.'));
        }
    }
}
