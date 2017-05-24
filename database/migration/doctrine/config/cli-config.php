<?php
include __DIR__.'/../../../../app/config/config.php';
include __DIR__.'/environment.php';

if (DB_TYPE === 'mysql') {
    $db_type = 'pdo_mysql';
}
elseif (DB_TYPE === 'pgsql') {
    $db_type = 'pdo_pgsql';
}
elseif (DB_TYPE === 'sqlite') {
    $db_type = 'pdo_sqlite';
}
elseif (DB_TYPE === 'oci') {
    $db_type = 'pdo_oci';
}
else {
    $db_type = '';
}

$db = \Doctrine\DBAL\DriverManager::getConnection(array(
    'driver'   => $db_type,
    'host'     => DB_HOST,
    'dbname'   => $db_name,
    'user'     => DB_USER,
    'password' => DB_PASS,
    'port'     => DB_PORT,
    //'unix_socket' => '',
    'charset'  => 'utf8',
    'driverOptions' => array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    )
));

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($db),
    'dialog' => new \Symfony\Component\Console\Helper\DialogHelper(),
));

$cli = new Symfony\Component\Console\Application('Doctrine Command Line Interface', \Doctrine\ORM\Version::VERSION);
$cli->setCatchExceptions(true);
$cli->setHelperSet($helperSet);
$cli->addCommands(array(
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\LatestCommand()
));

\Doctrine\ORM\Tools\Console\ConsoleRunner::addCommands($cli);

$cli->run();
