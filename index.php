<?php
session_start();

include_once('config/confing.php');

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$components = explode('/', $request);
$controllerName = 'home';
if (count($components) >= 2 && $components[1] != '') {
    $controllerName = ucfirst($components[1]);
    if (! preg_match('/^[a-zA-Z0-9_]+$/', $controllerName)) {
        include_once('/views/layouts/header.php');
        include_once('/views/layouts/pageNotFound.php');
        include_once('/views/layouts/footer.php');
        die;
        die ('Invalid controller name');
    }
}

$action = 'index';
if (count($components) >= 3 && $components[2] != '') {
    $action = $components[2];
    if (! preg_match('/^[a-zA-Z0-9_]+$/', $action)) {
        include_once('/views/layouts/header.php');
        include_once('/views/layouts/pageNotFound.php');
        include_once('/views/layouts/footer.php');
        die;
    }
}

$params = array();
if (count($components) >= 4) {
    $params = array_splice($components, 3);
}

$controllerClassName = ucfirst($controllerName) . 'Controller';
if (class_exists($controllerClassName)) {
    $controller = new $controllerClassName($controllerName, $action);
    if (method_exists($controller, $action)) {
        call_user_func_array(array($controller, $action), $params);
        $controller->renderView();
    } else {
        include_once('views/layouts/header.php');
        include_once('/views/layouts/header.php');
        include_once('/views/layouts/pageNotFound.php');
        include_once('/views/layouts/footer.php');
        die;
    }
} else {
    $controllerFileName = 'controllers/' . $controllerClassName . 'register.php';
    include_once('/views/layouts/header.php');
    include_once('/views/layouts/pageNotFound.php');
    include_once('/views/layouts/footer.php');
    die;
}

function __autoload($class_name) {
    if (file_exists("controllers/$class_name.php")) {
        include "controllers/$class_name.php";
    }
    if (file_exists("models/$class_name.php")) {
        include "models/$class_name.php";
    }
}

