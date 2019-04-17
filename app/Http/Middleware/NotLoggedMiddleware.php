<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 7/5/2018
 * Time: 12:57 AM
 */

namespace App\Http\Middleware;

class NotLoggedMiddleware
{
    public function handle($request, \Closure $next)
    {
        if(isset($_SESSION['user'])) {
            $redirect = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '/';
            return redirect($redirect);
        }

        return $next($request);
    }
}