<?php
$GLOBALS['API_VERSION'] = (int)ltrim($_SERVER['REQUEST_URI'], '/v');
$GLOBALS['API_ROUTER_PREFIX'] = '/v'.$GLOBALS['API_VERSION'];

$include_config = __DIR__ . '/'.$GLOBALS['API_VERSION'].'/config.php';
if (!file_exists($include_config)) {
    echo 'We are not support this version now.';
    exit;
}

include __DIR__ . '/../../app/apart/bootstrap.php';
$router = new Phroute\RouteCollector();
include $include_config;

$dispatcher = new Phroute\Dispatcher($router);

try {
    $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
} catch (Phroute\Exception\HttpRouteNotFoundException $e) {
    exit;
} catch (Phroute\Exception\HttpMethodNotAllowedException $e) {
    exit;
}

echo $response;
