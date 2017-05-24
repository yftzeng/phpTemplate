<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140506180251 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $table = $schema->createTable('member');
        $table->addOption('type', 'INNODB');
        $table->addOption('charset', 'utf8mb4');
        $table->addOption('collate', 'utf8mb4_unicode_ci');

        $table->addColumn('id', 'bigint', array(
            'length' => 20,
            'unsigned' => 1,
            'notnull' => true,
            'autoincrement' => true,
        ));

        $table->addColumn('member_uuid', 'string', array(
            'length' => 36,
            'unsigned' => 1,
            'notnull' => true,
            'fixed' => true,
            'default' => '',
        ));

        $table->addColumn('username', 'string', array(
            'length' => 80,
            'unsigned' => 1,
            'notnull' => true,
            'fixed' => true,
            'default' => '',
        ));

        $table->addColumn('password', 'string', array(
            'length' => 255,
            'unsigned' => 1,
            'notnull' => true,
            'fixed' => true,
            'default' => '',
        ));

        $table->addColumn('desc', 'text', array(
            'unsigned' => 1,
            'notnull' => true,
            'default' => '',
        ));

        $table->addColumn('is_showed', 'boolean', array(
            'unsigned' => 1,
            'notnull' => true,
            'default' => 1,
        ));

        $table->addColumn('created_at', 'datetime', array(
            'unsigned' => 1,
            'notnull' => true,
            'default' => '0000-00-00 00:00:00',
        ));

        $table->addColumn('created_by', 'string', array(
            'length' => 36,
            'unsigned' => 1,
            'notnull' => true,
            'fixed' => true,
            'default' => '',
        ));

        $table->addColumn('expired_at', 'datetime', array(
            'unsigned' => 1,
            'notnull' => true,
            'default' => '9999-12-30 23:59:59',
        ));

        $table->setPrimaryKey(array('id'));
        $table->addUniqueIndex(array('member_uuid'));
        $table->addIndex(array('is_showed'));
    }

    public function down(Schema $schema)
    {
        $schema->dropTable('member');
    }
}
