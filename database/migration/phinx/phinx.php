<?php
include __DIR__.'/../../app/config/config.php';
return array(
    'paths' => array(
        'migrations' => '%%PHINX_CONFIG_DIR%%/migrations',
    ),
    'environments' => array(
        'default_migration_table' => 'phinxlog',
        'default_database' => 'development',
        'production' => array(
            'adapter' => DB_TYPE,
            'host'    => DB_HOST,
            'name'    => DB_NAME,
            'user'    => DB_USER,
            'pass'    => DB_PASS,
            'port'    => DB_PORT,
            'charset' => 'utf8',
        ),
        'development' => array(
            'adapter' => DB_TYPE,
            'host'    => DB_HOST,
            'name'    => DB_NAME.'_dev',
            'user'    => DB_USER,
            'pass'    => DB_PASS,
            'port'    => DB_PORT,
            'charset' => 'utf8',
        ),
        'testing' => array(
            'adapter' => DB_TYPE,
            'host'    => DB_HOST,
            'name'    => DB_NAME.'_test',
            'user'    => DB_USER,
            'pass'    => DB_PASS,
            'port'    => DB_PORT,
            'charset' => 'utf8',
        ),
    )
);
