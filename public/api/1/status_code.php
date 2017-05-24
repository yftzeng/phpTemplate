<?php

/* *
status_code rule:
  9 digits: 123456789
  1: success(0) / fail(1)
  2,3: module code
  4,5,6: function code
  7,8,9: state code
/* */


$GLOBALS['api_status_code'] = array(
    // System
    'INVALID_PARAMETER_FORMAT' => array(
        '000001',
        'Invalid value of parameter: format'
    ),
    'INVALID_HTTP_PROTOCOL_METHOD' => array(
        '000002',
        'Invalid value of HTTP protocol request method'
    ),
    'MISSING_PARAMETER_APIKEY' => array(
        '000003',
        'Missing parameter: api_key'
    ),
    'MISSING_PARAMETER_PLATFORM' => array(
        '000004',
        'Missing parameter: platform'
    ),
    'INVALID_PARAMETER_PLATFORM' => array(
        '000005',
        'Invalid value of parameter: platform'
    ),
    'MISSING_PARAMETER_URI' => array(
        '000006',
        'Missing parameter: uri'
    ),
    'INVALID_PARAMETER_URI' => array(
        '000007',
        'Invalid value of parameter: uri'
    ),
    'AUTHENTICATION_FAILED' => array(
        '000008',
        'Authentication failed, please verify your api_key is correct'
    ),

    // Custom
    // error
    'FILE_MISSING_PARAMETER_TARGET' => array(
        '0001',
        'Missing parameter: target'
    ),
    'FILE_MISSING_PARAMETER_ID' => array(
        '0002',
        'Missing parameter: id'
    ),
    'FILE_INVALID_PARAMETER_TARGET' => array(
        '0003',
        'Invalid value of parameter: target'
    ),
    'FILE_AUTHENTICATION_FAILED' => array(
        '0005',
        'Authentication failed'
    ),
    'FILE_AUTHORIZATION_FAILED' => array(
        '001006',
        'Authorization failed'
    ),
    'FILE_FILE_NOTFOUND' => array(
        '0007',
        'File not found'
    ),
);
