<?php

namespace YouVision\ThinkApidoc\providers;

use YouVision\ThinkApidoc\middleware\ThinkPHPMiddleware;
use YouVision\ThinkApidoc\utils\Helper;
use think\facade\App;
use think\facade\Route;
use think\facade\Lang;
use think\facade\Db;

class ThinkPHP extends \think\Service
{
    use BaseService;

    protected static $apidocConfig = null;

    static function getApidocConfig(): array
    {
        if (static::$apidocConfig !== null) {
            return static::$apidocConfig;
        }

        $config = config('apidoc');
        if (empty($config) || !is_array($config)) {
            $config = include dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'apidoc.php';
        }

        if (empty($config['auto_url']) || empty($config['auto_url']['filter_keys'])) {
            $config['auto_url']['filter_keys'] = ['app', 'controller'];
        }

        $config['app_frame'] = 'thinkphp8';

        return static::$apidocConfig = $config;
    }

    public function register()
    {
        $this->initConfig();

        $config = static::getApidocConfig();

        $this->registerRoutes(function () use ($config) {
            self::registerApidocRoutes(function ($route) use ($config) {
                $registerRoute = Route::any($route['uri'], $route['callback']);
                $registerRoute->middleware([ThinkPHPMiddleware::class]);
                if (!empty($config['allowCrossDomain'])) {
                    $registerRoute->allowCrossDomain();
                }
            });

            self::autoRegisterRoutes(function ($routeData) {
                $appRoute = $this->app->route;
                $appName = $this->app->http->getName();
                foreach ($routeData as $controller) {
                    $routeGroup = $appRoute->getGroup();
                    if (empty($controller['methods'])) {
                        continue;
                    }
                    foreach ($controller['methods'] as $method) {
                        if (!empty($appName) && strpos($method['url'], '/' . $appName) === 0) {
                            $method['url'] = substr($method['url'], strlen('/' . $appName));
                            if ($method['url'] === '') {
                                $method['url'] = '/';
                            }
                        }
                        $apiMethods = Helper::handleApiMethod($method['method']);
                        $apiMethods = implode('|', $apiMethods);
                        $route = $routeGroup->addRule($method['url'], $method['controller'] . '@' . $method['name'], $apiMethods);
                        if (!empty($controller['middleware'])) {
                            $route->middleware($controller['middleware']);
                        }
                        if (!empty($method['middleware'])) {
                            $route->middleware($method['middleware']);
                        }
                    }
                }
            });
        });
    }

    static function registerRoute($route)
    {
        $config = static::getApidocConfig();
        $registerRoute = Route::any($route['uri'], $route['callback']);
        $registerRoute->middleware([ThinkPHPMiddleware::class]);
        if (!empty($config['allowCrossDomain'])) {
            $registerRoute->allowCrossDomain();
        }
    }

    static function databaseQuery($sql)
    {
        return Db::query($sql);
    }

    static function getTablePrefix()
    {
        $driver = config('database.default');
        return $driver ? config('database.connections.' . $driver . '.prefix') : '';
    }

    static function getRootPath(): string
    {
        return App::getRootPath();
    }

    static function getRuntimePath(): string
    {
        return App::getRuntimePath();
    }

    static function setLang($locale)
    {
        Lang::switchLangSet($locale);
    }

    static function getLang($lang)
    {
        return Lang::get($lang);
    }

    static function handleResponseJson($res)
    {
        return json($res);
    }
}