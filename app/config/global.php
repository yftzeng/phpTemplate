<?php

###########################################
### Include
###########################################

include __DIR__.'/config.php';
include __DIR__.'/../vendor/autoload.php';
include __DIR__.'/../datamap/autoload.php';

###########################################
### System
###########################################

if (MODE === 'dev') {
    ini_set('display_errors'          , true);
    ini_set('display_startup_errors'  , true);
    ini_set('soap.wsdl_cache_enabled' , false);

    if (class_exists('FB')) {
        FB::setEnabled(true);
    }
    define('WOW_LOG_LEVEL' , 'DEBUG');
    define('WOW_DEBUG_LOG', true);
}
else {
    ini_set('display_errors'          , false);
    ini_set('display_startup_errors'  , false);
    ini_set('soap.wsdl_cache_enabled' , true);

    if (class_exists('FB')) {
        FB::setEnabled(false);
    }
    define('WOW_LOG_LEVEL' , 'INFO');
    define('WOW_DEBUG_LOG', false);
}
ini_set('session.gc_maxlifetime', 86400);

# Prevent session hijacking
/* *
session_start();
if (isset($_SESSION['last_ip']) === false && isset($_SERVER['REMOTE_ADDR'])) {
    $_SESSION['last_ip'] = $_SERVER['REMOTE_ADDR'];
}
if (isset($_SESSION['last_ip']) && $_SESSION['last_ip'] !== $_SERVER['REMOTE_ADDR']) {
    session_unset();
    session_destroy();
}
/* */

\Wow\Log\WowLog::init(LOG_ROOT, WOW_LOG_LEVEL);

$I = new \Wow\I18N\WowI18N(I18N_LANGFILEPATH, I18N_LANGFILECACHEPATH, I18N_FALLBACKLANG, I18N_FORCEDLANG);

\Wow\Util\WowJwt::setEncryptAlg(SECURITY_ALGORITHM);
\Wow\Util\WowJwt::setEncryptKey(SECURITY_KEY);
\Wow\Util\WowJwt::setEncryptIv(SECURITY_IV);

\Wow\Util\WowFunction::setEncryptAlg(SECURITY_ALGORITHM);
\Wow\Util\WowFunction::setEncryptKey(SECURITY_KEY);
\Wow\Util\WowFunction::setEncryptIv(SECURITY_IV);

###########################################
### Database
###########################################

#ORM::configure('error_mode', PDO::ERRMODE_WARNING);
ORM::configure('error_mode', PDO::ERRMODE_EXCEPTION);

$timezone_offset = timezone_offset_get( new DateTimeZone (date_default_timezone_get()) , new DateTime() );
$timezone_offset = sprintf( "%s%02d:%02d", ( $timezone_offset >= 0 ) ? '+' : '-', abs( $timezone_offset / 3600 ), abs( $timezone_offset % 3600 ) );

/* *
if (apc_exists('CACHE_GLOBAL_DB_HOST')) {
    $GLOBAL_DB_HOST = apc_fetch('CACHE_GLOBAL_DB_HOST');
}
else {
    apc_store('CACHE_GLOBAL_DB_HOST', $GLOBAL_DB_HOST, GLOBAL_DB_HOST_CACHE_TIME_BY_SECONDS);
}
shuffle($GLOBAL_DB_HOST);
while(count($GLOBAL_DB_HOST)) {
    list($DB_HOST, $DB_PORT) = array_shift($GLOBAL_DB_HOST);
    if ($DB_HOST === 'localhost') {
        // NOTE: `mysqladmin -uroot -p variables | grep socket`
        $db_socket = '/var/lib/mysql/mysql.sock';
        if (!file_exists($db_socket)) {
            $db_socket = '/var/run/mysqld/mysqld.sock';
        }
        define('DB_SOCKET', $db_socket);
        try {
            $db = new PDO(DB_TYPE.':host='.$DB_HOST.';dbname='.DB_NAME.';unix_socket='.DB_SOCKET, DB_USER, DB_PASS, array(
                //PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8; SET TIME_ZONE='".$timezone_offset."';",  // bugs, idiorm cannot use create() first
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET TIME_ZONE='".$timezone_offset."';",
                PDO::MYSQL_ATTR_COMPRESS     => 0,
            ));
            ORM::set_db($db);
            break;
        } catch (PDOException $e) {
            \Wow\Log\WowLog::crit('Database connection failed: ' . $DB_HOST);
        }
    }
    else {
        try {
            $db = new PDO(DB_TYPE.':host='.$DB_HOST.';port='.$DB_PORT.';dbname='.DB_NAME, DB_USER, DB_PASS, array(
                //PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8; SET TIME_ZONE='".$timezone_offset."';",  // bugs, idiorm cannot use create() first
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET TIME_ZONE='".$timezone_offset."';",
                PDO::MYSQL_ATTR_COMPRESS     => 0,
            ));
            ORM::set_db($db);
            break;
        } catch (PDOException $e) {
            \Wow\Log\WowLog::crit('Database connection failed: ' . $DB_HOST);
        }
    }
}
/* */
if ($GLOBALS['DB_HOST'] === 'localhost' && DB_TYPE === 'mysql') {
    // NOTE: `mysqladmin -uroot -p variables | grep socket`
    $db_socket = '/var/run/mysqld/mysqld.sock';
    if (!file_exists($db_socket)) {
        $db_socket = '/var/lib/mysql/mysql.sock';
    }
    define('DB_SOCKET', $db_socket);
    try {
        $db = new PDO(DB_TYPE.':host='.$GLOBALS['DB_HOST'].';dbname='.DB_NAME.';unix_socket='.DB_SOCKET, DB_USER, DB_PASS, array(
            //PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8; SET TIME_ZONE='".$timezone_offset."';",  // bugs, idiorm cannot use create() first
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET TIME_ZONE='".$timezone_offset."';",
            PDO::MYSQL_ATTR_COMPRESS     => 0,
        ));
        ORM::set_db($db);
    } catch (PDOException $e) {
        \Wow\Log\WowLog::crit('Database connection failed: ' . $GLOBALS['DB_HOST']);
    }
    ORM::configure('logging', WOW_DEBUG_LOG);
}
else {
    if (apc_exists(GLOBAL_DB_HOST_CACHE_KEY)) {
        $GLOBALS['DB_HOST'] = apc_fetch(GLOBAL_DB_HOST_CACHE_KEY);
    }

    ORM::configure(array(
        'connection_string' => DB_TYPE.':host=OOO;port=XXX;dbname='.DB_NAME,
        'username' => DB_USER,
        'password' => DB_PASS,
        /*
        'driver_options' => array(
            //PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8; SET TIME_ZONE='".$timezone_offset."';",  // bugs, idiorm cannot use create() first
            //PDO::MYSQL_ATTR_INIT_COMMAND => "SET TIME_ZONE='".$timezone_offset."';",
            PDO::MYSQL_ATTR_COMPRESS     => 0,
            //PDO::ATTR_TIMEOUT            => 1,
        ),
        */
        'db_array' => $GLOBALS['DB_HOST'],
        'db_array_cache_key' => GLOBAL_DB_HOST_CACHE_KEY,
        'db_array_cache_ttl' => GLOBAL_DB_HOST_CACHE_TIME_BY_SECONDS,
        'logging' => WOW_DEBUG_LOG,
        'caching' => false,
        'return_result_sets' => false,
        'id_column_overrides' => array(
            //'table' => 'id',
        ),
    ));

    if (DB_TYPE === 'mysql') {
        ORM::configure('driver_options', array(
            PDO::MYSQL_ATTR_COMPRESS     => 0,
        ));
    }
    if (DB_TYPE === 'pgsql') {
        ORM::configure('driver_options', array(
            PDO::ATTR_PERSISTENT => true
        ));
    }
}


