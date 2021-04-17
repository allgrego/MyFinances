<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActiveSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!session()->get('activeSession')||!session()->has('activeUsername')){
            return redirect(route('loginIndex'));
        }

        // Registrar última actividad
        date_default_timezone_set("America/Caracas");
        $nowTimestamp = date("Y-m-d H:i:s");

        $username = session()->get('activeUsername');

        DB::update('update user set last_activity = ? where username = ?', [$nowTimestamp,$username]);

        return $next($request);
    }
}
