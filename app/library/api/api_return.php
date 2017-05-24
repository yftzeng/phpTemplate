<?php
function _return($api_status_code, $status_message, $data, $return) {
    $return['code'] = $api_status_code;
    $return['message'] = $status_message;
    $return['data'] = $data;

    if ($GLOBALS['api_config']['return_format'] === 'json') {
        header('Content-Type: application/json; charset=utf-8');

        if ($GLOBALS['api_config']['env'] === 'dev') {
            $return = json_encode($return, JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } else {
            $return = json_encode($return, JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        if (isset($_REQUEST['callback'])) {
            $return = '{' . $_REQUEST['callback'] . '}(' . $return . ')';
        }
    } else {
        header('Content-Type: text/xml; charset=utf-8');
        $return = assocArrayToXML('messages', $return);
    }

    return $return;
}

function _returnInit($returnName) {
    if ($returnName === '') {
        return array('', '');
    }
    return array($GLOBALS['api_status_code'][$returnName][0], $GLOBALS['api_status_code'][$returnName][1]);
}

function fail($returnName, $data = '') {
    return _returnFinal(1, $returnName, $data);
}

function ok($returnName, $data = '') {
    return _returnFinal(0, $returnName, $data);
}

function _returnFinal($error, $returnName, $data) {
    $return['api_version'] = $GLOBALS['API_VERSION'];
    if ($error === 0) {
        $return['error'] = 0;
    } else {
        $return['error'] = 1;
    }
    list($api_status_code, $status_message) = _returnInit($returnName);
    return _return($error.$GLOBALS['API_MODULE_CODE'].$api_status_code, $status_message, $data, $return);
}
