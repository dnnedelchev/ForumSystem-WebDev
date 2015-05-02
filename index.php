<?php
session_start();

include_once('config/db.php');

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$components = explode('/', $request);
$controller = 'home';
if (count($components) >= 2 && $components[1] != '') {
    $controller = ucfirst($components[1]);
    if (! preg_match('/^[a-zA-Z0-9_]+$/', $controller)) {
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

var_dump($request);
var_dump($components);
var_dump($controller);
var_dump($action);
var_dump($params);


