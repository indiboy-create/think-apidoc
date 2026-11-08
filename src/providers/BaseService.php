<?php

namespace YouVision\ThinkApidoc\providers;

use YouVision\ThinkApidoc\utils\AutoRegisterRouts;
use YouVision\ThinkApidoc\utils\Cache;
use YouVision\ThinkApidoc\utils\ConfigProvider;
use YouVision\ThinkApidoc\utils\Helper;

trait BaseService
{
    static $routes = [
        ['rule' => 'config', 'route' => 'getConfig'],
        ['rule' => 'apiMenus', 'route' => 'getApiMenus'],
        ['rule' => 'apiDetail', 'route' => 'getApiDetail'],
        ['rule' => 'docMenus', 'route' => 'getMdMenus'],
        ['rule' => 'docDetail', 'route' => 'getMdDetail'],
        ['rule' => 'verifyAuth', 'route' => 'verifyAuth'],
        ['rule' => 'generator', 'route' => 'createGenerator'],
        ['rule' => 'cancelAllCache', 'route' => 'cancelAllCache'],
        ['rule' => 'createAllCache', 'route' => 'createAllCache'],
        ['rule' => 'renderCodeTemplate', 'route' => 'renderCodeTemplate'],
        ['rule' => 'allApiMenus', 'route' => 'getAllApiMenus'],
        ['rule' => 'addApiShare', 'route' => 'addApiShare'],
        ['rule' => 'getApiShareList', 'route' => 'getApiShareList'],
        ['rule' => 'getApiShareDetail', 'route' => 'getApiShareDetail'],
        ['rule' => 'deleteApiShare', 'route' => 'deleteApiShare'],
        ['rule' => 'handleApiShareAction', 'route' => 'handleApiShareAction'],
    ];

    abstract static function getApidocConfig();

    abstract static function registerRoute($route);

    abstract static function databaseQuery($sql);

    abstract static function getRootPath();

    abstract static function getRuntimePath();

    abstract static function setLang($locale);

    abstract static function getLang($lang);

    abstract static function handleResponseJson($res);

    abstract static function getTablePrefix();

    static public function autoRegisterRoutes($routeFun, $config = "")
    {
        if (empty($config)) {
            $config = self::getApidocConfig();
        }
        if (isset($config['auto_register_routes']) && $config['auto_register_routes'] === true) {
            $cacheKey = "apis/autoRegisterRoutes";
            if (!empty($config['cache']) && !empty($config['cache']['enable'])) {
                $cacheData = (new Cache())->get($cacheKey);
                if (!empty($cacheData)) {
                    $autoRegisterApis = $cacheData;
                } else {
                    $autoRegisterApis = (new AutoRegisterRouts($config))->getAppsApis();
                    (new Cache())->set($cacheKey, $autoRegisterApis);
                }
            } else {
                $autoRegisterApis = (new AutoRegisterRouts($config))->getAppsApis();
            }
            $routeFun($autoRegisterApis);
        }
    }

    public function initConfig()
    {
        !defined('APIDOC_ROOT_PATH') && define('APIDOC_ROOT_PATH', $this->getRootPath());
        !defined('APIDOC_STORAGE_PATH') && define('APIDOC_STORAGE_PATH', $this->getRuntimePath());

        $config = self::getApidocConfig();

        if (empty($config['database_query_function'])) {
            $config['database_query_function'] = function ($sql) {
                return self::databaseQuery($sql);
            };
        }
        if (empty($config['lang_register_function'])) {
            $config['lang_register_function'] = function ($locale) {
                return self::setLang($locale);
            };
        }
        if (empty($config['lang_get_function'])) {
            $config['lang_get_function'] = function ($lang) {
                return self::getLang($lang);
            };
        }

        $config['handle_response_json'] = function ($res) {
            return self::handleResponseJson($res);
        };

        $tablePrefix = self::getTablePrefix();
        if (empty($config['database_prefix'])) {
            $config['database_prefix'] = $tablePrefix;
            if (!empty($config['database']) && empty($config['database']['prefix'])) {
                $config['database']['prefix'] = $tablePrefix;
            } else if (empty($config['database'])) {
                $config['database'] = ['prefix' => $tablePrefix];
            }
        }

        ConfigProvider::set($config);
    }

    static public function registerApidocRoutes($routeFun = null)
    {
        $routes = static::$routes;
        $controllerNamespace = '\YouVision\ThinkApidoc\Controller@';
        $routePrefix = '/apidoc';
        $config = self::getApidocConfig();
        if (!empty($config['route_prefix'])) {
            $routePrefix = $config['route_prefix'];
        }
        foreach ($routes as $item) {
            $route = [
                'uri' => $routePrefix . '/' . $item['rule'],
                'callback' => $controllerNamespace . $item['route'],
                'route' => $item['route'],
            ];
            if (!empty($routeFun)) {
                $routeFun($route);
            } else {
                self::registerRoute($route);
            }
        }
    }
}