<?php
include __DIR__ . '/../config/global.php';

if (isset($GLOBALS['API_VERSION'])) {
    new \Wow\Exception\WowErrorHandler(0, LOG_ROOT.'api/v'.$GLOBALS['API_VERSION'].'/');
} else {
    new \Wow\Exception\WowErrorHandler(0, LOG_ROOT.'api/cli/');
}

###########################################
### Include 3rd libraries
###########################################
include __DIR__ . '/../library/assoc_array_to_xml.php';
include __DIR__ . '/../library/api/api_return.php';
