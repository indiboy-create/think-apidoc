<?php

namespace YouVision\ThinkApidoc\middleware;

use YouVision\ThinkApidoc\utils\ConfigProvider;

class ThinkPHPMiddleware
{
    public function handle($request, \Closure $next)
    {
        $params = $request->param();
        $config =  ConfigProvider::get();
        $config['request_params'] = $params;
        ConfigProvider::set($config);
        return $next($request);
    }
}