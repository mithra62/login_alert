<?php

use ExpressionEngine\Service\Migration\Migration;

class CreateMemberLoginAlertTable extends Migration
{
    /**
     * Execute the migration
     * @return void
     */
    public function up()
    {
        $fields = array(
            'id' => array('type' => 'int', 'constraint' => '10', 'unsigned' => true, 'auto_increment' => true),
            'site_id' => array('type' => 'int', 'constraint' => '4', 'unsigned' => true, 'default' => 1),
            'name' => array('type' => 'varchar', 'constraint' => '50', 'null' => false),
            'log_into' => array('type' => 'ENUM("PAGE","CP")', 'null' => false),
            'log_into_what' => array('type' => 'ENUM("member","role")', 'null' => false),
            'log_into_who' => array('type' => 'varchar', 'constraint' => '255', 'null' => false),
            'notify_template' => array('type' => 'varchar', 'constraint' => '100', 'null' => false),
            'email_format' => array('type' => 'ENUM("html","text")'),
            'status' => array('type' => 'int', 'constraint' => '1', 'null' => false),
            'notify_emails' => array('type' => 'varchar', 'constraint' => '255', 'null' => true),
            'notify_member_ids' => array('type' => 'varchar', 'constraint' => '255', 'null' => true),
            'notify_subject' => array('type' => 'varchar', 'constraint' => '100', 'null' => false),
            'created_date' => array('type' => 'int', 'constraint' => '10', 'null' => false),
            'last_updated' => array('type' => 'int', 'constraint' => '10', 'null' => false),
            // 'name' => array('type' => 'varchar', 'constraint' => '50'),
            // 'yes_or_no' => array('type' => 'ENUM("Yes","No")'),
            // 'amount' => array('type' => 'double'),
            // 'last_updated' => array('type' => 'datetime', 'null' => false),
        );

        ee()->dbforge->add_field($fields);
        ee()->dbforge->add_key('id', true);
        ee()->dbforge->create_table('member_login_alerts');
    }

    /**
     * Rollback the migration
     * @return void
     */
    public function down()
    {
        ee()->dbforge->drop_table('member_login_alerts');
    }
}
