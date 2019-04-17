<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 7/5/2018
 * Time: 12:57 AM
 */

namespace App\Http\Middleware;

class LoggedMiddleware
{
    public function handle($request, \Closure $next)
    {
        if(!isset($_SESSION['user'])) {
            return redirect('/login');
        }

        return $next($request);
    }
}