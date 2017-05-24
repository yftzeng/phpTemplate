<?php

$router->any($GLOBALS['API_ROUTER_PREFIX'], function() {
    $GLOBALS['API_MODULE_CODE'] = '01';
    include __DIR__ . '/function/' .
        $GLOBALS['api_config']['return_platform'] .
        '/' .
        $GLOBALS['api_platform_config'][$GLOBALS['api_config']['return_platform']][$GLOBALS['api_config']['return_uri']] . '.php';
}, array('before' => 'validateInit'));

$router->any($GLOBALS['API_ROUTER_PREFIX'].'/a', function() {
    $GLOBALS['API_MODULE_CODE'] = '01';
    if ($GLOBALS['api_config']['return_platform'] === 'web') {
        return 'web';
    }
}, array('before' => 'validateInit'));

