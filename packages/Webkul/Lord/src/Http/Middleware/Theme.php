<?php

namespace Webkul\Lord\Http\Middleware;

use Closure;

class Theme
{
    public function handle($request, Closure $next)
    {
        $themes = themes();
        $channel = core()->getCurrentChannel();

        if ($channel && $channelThemeCode = $channel->theme) {
            $themes->exists($channelThemeCode)
                ? $themes->set($channelThemeCode)
                : $themes->set(config('themes.shop-default'));  // ✅ مفتاح صحيح
        } else {
            $themes->set(config('themes.shop-default'));  // ✅ مفتاح صحيح
        }

        return $next($request);
    }
}