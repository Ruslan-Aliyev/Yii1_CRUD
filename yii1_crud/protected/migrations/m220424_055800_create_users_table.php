<?php

class m220424_055800_create_users_table extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->createTable('users', array(
            'id'       => 'pk',
            'username' => 'VARCHAR(60)',
            'password' => 'VARCHAR(21)',
        ),
        'ENGINE=InnoDB');
        // $this->addForeignKey('index_name','this_table','this_table_fk','other_table','key_in_other_table');

        $this->insert('users', array(
            'username' => 'demo',
            'password' => 'demo'//md5('demo'),
        ));
        $this->insert('users', array(
            'username' => 'admin',
            'password' => 'admin'//md5('admin'),
        ));
	}

	public function safeDown()
	{
        $this->dropTable('users');
	}
}