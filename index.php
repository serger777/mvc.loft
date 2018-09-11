<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT']. "/vendor/autoload.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/app/core/view.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/app/core/config.php";
$routes = explode('/', $_SERVER['REQUEST_URI']);

const APPLICATION_PATH = __DIR__.'/';
$controller_name = "Users";
$action_name = 'enter';

$url = parse_url($_SERVER['REQUEST_URI'])['path'];
$routes = explode('/', $url);
// получаем контроллер
if (!empty($routes[1])) {
    $controller_name = $routes[1];
}

// получаем действие
if (!empty($routes[2])) {
    $action_name = $routes[2];
}

$filename = "app/controllers/".strtolower($controller_name).".php";


try {
    if (file_exists($filename)) {
        require_once $filename;
    } else {
        throw new Exception("File not found");
    }


    $classname = 'App\\Controllers\\'.ucfirst($controller_name);

    if (class_exists($classname)) {
        $controller = new $classname();
    } else {
        throw new Exception("File found but class not found");
    }

    if (method_exists($controller, $action_name)) {
        $controller->$action_name();
    } else {
        throw new Exception("Method not found");
    }
} catch (Exception $e) {
    require "errors/404.php";
}



