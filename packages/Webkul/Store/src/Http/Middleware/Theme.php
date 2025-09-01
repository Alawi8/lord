<?php

namespace Webkul\Store\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Theme
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
        // ببساطة نمرر الطلب للتالي
        // لأن view paths محددة في StoreServiceProvider
        return $next($request);
    }
}