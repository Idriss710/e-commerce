<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth ;

class AdminMiddlesware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        if(Auth::User()->user_type == 'admin'){
            session()->flush();
            return redirect()->route('admin.index');
        }else{
            return redirect()->back();
        }
        return $next($request);
    }
}
