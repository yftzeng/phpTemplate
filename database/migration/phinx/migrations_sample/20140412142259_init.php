<?php

use Phinx\Migration\AbstractMigration;

class Init extends AbstractMigration
{

    protected $table_name = 'users';

    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     *
     * Uncomment this method if you would like to use it.
     *
     public function change()
     {
     }
     */

    /**
     * Migrate Up.
     */
    public function up()
    {
        $exists = $this->hasTable($this->table_name);
        if (!$exists) {
            $t = $this->table($this->table_name, array('engine' => 'InnoDB', 'charset' => 'utf8mb4', 'collation' => 'utf8mb4_unicode_ci'));
            $t
                ->addColumn('member_uuid', 'string', array('null' => false, 'limit' => 36))
                ->addColumn('username', 'string', array('null' => false, 'limit' => 80))
                ->addColumn('password', 'string', array('null' => false, 'limit' => 255))
                ->addColumn('address', 'string', array('null' => false, 'limit' => 255, 'default' => ''))
                ->addColumn('locale', 'string', array('null' => false, 'limit' => 8, 'default' => 'zh_tw'))
                ->addColumn('token', 'string', array('null' => false, 'limit' => 64, 'default' => ''))
                ->addColumn('is_showed', 'boolean', array('null' => false, 'default' => '1'))
                ->addColumn('is_locked', 'boolean', array('null' => false, 'default' => '0'))
                ->addColumn('is_authed', 'boolean', array('null' => false, 'default' => '1'))
                ->addColumn('is_verified', 'boolean', array('null' => false, 'default' => '1'))
                ->addColumn('has_epaper', 'boolean', array('null' => false, 'default' => '0'))
                ->addColumn('data_from', 'string', array('null' => false, 'limit' => 255, 'default' => ''))
                ->addColumn('data_from_uuid', 'string', array('null' => false, 'limit' => 255, 'default' => ''))
                ->addColumn('data_from_hash', 'string', array('null' => false, 'limit' => 255, 'default' => ''))
                ->addColumn('last_logined_at', 'datetime', array('null' => false, 'default' => '0000-00-00 00:00:00'))
                ->addColumn('created_at', 'datetime', array('null' => false, 'default' => '0000-00-00 00:00:00'))
                ->addColumn('created_by', 'string', array('null' => false, 'limit' => 36, 'default' => ''))
                ->addColumn('updated_at', 'datetime', array('null' => false, 'default' => '0000-00-00 00:00:00'))
                ->addColumn('updated_by', 'string', array('null' => false, 'limit' => 36, 'default' => ''))
                ->addColumn('deleted_at', 'datetime', array('null' => false, 'default' => '0000-00-00 00:00:00'))
                ->addColumn('deleted_by', 'string', array('null' => false, 'limit' => 36, 'default' => ''))
                ->addColumn('enabled_at', 'datetime', array('null' => false, 'default' => '0000-00-00 00:00:00'))
                ->addColumn('expired_at', 'datetime', array('null' => false, 'default' => '9999-12-30 23:59:59'))
                ->addColumn('checksum', 'string', array('null' => false, 'limit' => 255, 'default' => ''))
                ->addIndex(array('member_uuid', 'locale'), array('unique' => true))
                ->addIndex(array('is_showed'))
                ->save();

            $this->execute("ALTER TABLE `$this->table_name` CHANGE COLUMN `id` `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT");
        }
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable($this->table_name);
    }
}
