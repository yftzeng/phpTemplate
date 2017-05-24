<?php
function validate_debug() {
    if (isset($_REQUEST['debug'])) {
        if ((int)$_REQUEST['debug'] === 1) {
            $GLOBALS['api_config']['env'] = 'dev';
        }
    }
}

function validate_format() {
    $GLOBALS['API_MODULE_CODE'] = '01';
    if (isset($_REQUEST['format'])) {
        $GLOBALS['api_config']['return_format'] = $_REQUEST['format'];
        if (!in_array($GLOBALS['api_config']['return_format'], $GLOBALS['api_config']['allowed_return_format'], true)) {
            $GLOBALS['api_config']['return_format'] = $GLOBALS['api_config']['default_return_format'];
            echo fail('INVALID_PARAMETER_FORMAT');
            exit;
        }
    } else {
        $GLOBALS['api_config']['return_format'] = $GLOBALS['api_config']['default_return_format'];
    }
}

function validate_api_auth() {
    $GLOBALS['API_MODULE_CODE'] = '02';

    $api_auth_type = $GLOBALS['api_config']['allowed_return_platform']['web'];

    if ($api_auth_type === 0) {
        return;
    } elseif ($api_auth_type === 1) {
        if (!isset($_REQUEST['api_key'])) {
            echo fail('MISSING_PARAMETER_APIKEY');
            exit;
        }
        $api_key = filter_var($_REQUEST['api_key'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);

        $rs = ORM::for_table('api')
            ->select_many('member_uuid')
            ->where('apikey', $api_key)
            ->where('is_locked', 0)
            ->where('is_authed', 1)
            ->where('is_verified', 1)
            ->find_array();

        if ($rs === array()) {
            echo fail('AUTHENTICATION_FAILED');
            exit;
        }
    }
}

function validate_platform() {
    $GLOBALS['API_MODULE_CODE'] = '03';
    if (!isset($_REQUEST['platform'])) {
        echo fail('MISSING_PARAMETER_PLATFORM');
        exit;
    }
    $GLOBALS['api_config']['return_platform'] = $_REQUEST['platform'];
    if (!in_array($GLOBALS['api_config']['return_platform'], $GLOBALS['api_config']['allowed_return_platform'], true)) {
        echo fail('INVALID_PARAMETER_PLATFORM');
    }
}

function validate_uri() {
    $GLOBALS['API_MODULE_CODE'] = '04';
    if (!isset($_REQUEST['uri'])) {
        echo fail('MISSING_PARAMETER_URI');
        exit;
    }
    $GLOBALS['api_config']['return_uri'] = $_REQUEST['uri'];
    if (!array_key_exists($GLOBALS['api_config']['return_uri'], $GLOBALS['api_platform_config'][$GLOBALS['api_config']['return_platform']])) {
        echo fail('INVALID_PARAMETER_URI');
        exit;
    }
}

$router->filter('validateInit', function() {
    validate_debug();
    validate_format();
    validate_platform();
    validate_uri();
    validate_api_auth();
});

