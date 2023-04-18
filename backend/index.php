<?php

include('controller\CommentController.php');
include('controller\ImageController.php');
include('database\DatabaseConnector.php');

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

$requestMethod = $_SERVER["REQUEST_METHOD"];

$dbConnection = (new DatabaseConnector())->getConnection();

if ($uri[1] == 'comments') {
    $controller = new CommentController($dbConnection, $requestMethod);
    $controller->processRequest();
} else if ($uri[1] == 'images') {
    $controller = new ImageController($dbConnection, $requestMethod);
    $controller->processRequest();
} else {
    header("HTTP/1.1 404 Not Found");
}

?>