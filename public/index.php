<?php

use app\core\Router;

ini_set('error_reporting', E_ALL);
$query = rtrim($_SERVER['QUERY_STRING'], '/');

define('WWW', __DIR__);
define('CORE', dirname(__DIR__) . '/vendor/core');
define('ROOT', dirname(__DIR__));
define('APP', dirname(__DIR__) . '/app');
define('LAYOUT', 'default');
define('USER', 'http://gallery.local');

require '../app/core/Router.php';
require '../app/libs/functions.php';

spl_autoload_register(function ($class) {
    $file = ROOT . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_file($file)) {
        require_once $file;
    }
});

new \app\core\App();
Router::add('^pages/?(?P<action>[a-z-]+)/(?P<alias>[a-z-]+)$', ['controller' => 'Main']); // полный адрес строки
Router::add('^pages/(?P<alias>[0-9a-z-]+)$', ['controller' => 'Main', 'action' => 'index']);  // адрес с параметром (сокращенный)

Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');
Router::dispatch($query);
