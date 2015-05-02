<?php
session_start();

include_once('config/db.php');

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$components = explode('/', $request);
$controllerName = 'home';
if (count($components) >= 2 && $components[1] != '') {
    $controllerName = ucfirst($components[1]);
    if (! preg_match('/^[a-zA-Z0-9_]+$/', $controllerName)) {
        die ('Invalid controller name');
    }
}

$action = 'index';
if (count($components) >= 3 && $components[2] != '') {
    $action = $components[2];
    if (! preg_match('/^[a-zA-Z0-9_]+$/', $action)) {
        die ('Invalid action name');
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
        die ('Error: cannot find action.');
    }
} else {
    $controllerFileName = 'controllers/' . $controllerClassName . '.php';
    die ('Error: cannot find controller: ' . $controllerFileName);
}

function __autoload($class_name) {
    if (file_exists("controllers/$class_name.php")) {
        include "controllers/$class_name.php";
    }
    if (file_exists("models/$class_name.php")) {
        include "models/$class_name.php";
    }
}

