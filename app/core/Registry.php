<?php

namespace app\core;

use app\core\base\TSingletone;

class Registry
{
    use TSingletone;

    public static $objects = [];

    protected function __construct()
    {
        require ROOT . '/config/conf.php';
        foreach ($config['components'] as $name => $component) {
            self::$objects[$name] = new $component();
        }
    }

    public function __get($name)
    {
        if (is_object(self::$objects[$name])) {
            return self::$objects[$name];
        } else {
            $_SESSION['error'] = 'Error';
        }
    }

    public function __set($name, $object)
    {
        if (!isset(self::$objects[$name])) {
            self::$objects[$name] = new $object();
        }
    }
}
