<?php
$GLOBALS['api_config'] = array(
    'env' => 'dev',                                            // MODE: prod, dev, test
    'allowed_return_format'   => array('json','xml'),
    'default_return_format'   => 'json',                       // 'json','xml'
    'allowed_return_platform' => array(                        // 0: do not need auth, 1: apikey
        'web'     => 0,
        'mobile'  => 0,
        'pad'     => 0,
    ),
);

$GLOBALS['api_platform_config'] = array(
    'web' => array(
        '/' => 'root',
    ),
);

include __DIR__ . '/router.php';
include __DIR__ . '/status_code.php';
include __DIR__ . '/../library/api/api_init_check.php';
