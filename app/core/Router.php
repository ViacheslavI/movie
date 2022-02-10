<?php

namespace app\core;

class Router
{
    protected static $routes = [];
    protected static $route = [];

    public static function add($regexp, $route = [])
    {
        self::$routes[$regexp] = $route;
    }

    public static function getRoutes()
    {
        return self::$routes;
    }

    public static function getRoute()
    {
        return self::$route;
    }

    public static function matchRoute($url)
    {
        foreach (self::$routes as $key => $route) {
            if (preg_match("#$key#i", $url, $matches)) {
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $route[$key] = $value;
                    }
                }
                if (!isset($route['action'])) {
                    $route['action'] = 'index';
                }
                if (!isset($route['prefix'])) {
                    $route['prefix'] = '';
                } else {
                    $route['prefix'] .= '\\';
                }
                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    /**
     * @throws \Exception
     */
    public static function dispatch($url)
    {
        $url = self::removeQuerystring($url);
        if (self::matchRoute($url)) {
            $controller = 'app\\Controllers\\' . self::$route['prefix'] . self::$route['controller'] . 'Controller';
            if (class_exists($controller)) {
                $cObj = new $controller(self::$route);

                $action = self::lowerCamelCase(self::$route['action'] . 'Action');

                if (method_exists($cObj, $action)) {
                    $cObj->$action();
                    $cObj->getView();
                } else {
                    throw  new \Exception('page not found  controller=> action', 404);
                }
            } else {
                throw  new \Exception('page not found  controller', 404);
            }
        } else {
            throw  new \Exception('page not found', 404);
        }
    }

    protected static function upperCamelCase($data)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $data)));
    }

    protected static function lowerCamelCase($data)
    {
        return lcfirst(self::upperCamelCase($data));
    }

    protected static function removeQuerystring($url)
    {
        if ($url) {
            $params = explode('&', $url, 2);
            if (false === strpos($params[0], '=')) {
                return rtrim($params[0], '/');
            } else {
                return '';
            }
        }
    }
}
