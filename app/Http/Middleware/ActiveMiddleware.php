<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class ActiveMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        if ($this->isActive($request)) {
            return $next($request);
        }
        //abort(403);
        throw new AuthorizationException();
    }
    protected function isActive(Request $request)
    {

        return true;
    }
}
