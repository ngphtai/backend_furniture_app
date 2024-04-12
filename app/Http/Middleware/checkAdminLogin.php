<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Users;
class checkAdminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {

        $check = Auth::guard('ANNTStore')->check();
        if($check) {
            return $next($request);
        } else {
            toastr()->error("Yêu cầu phải login!");
            return redirect('/');
        }

    }
}
