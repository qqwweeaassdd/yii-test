<?php

use yii\db\Schema;
use yii\db\Migration;

class m141005_075112_create_user_table extends Migration
{
    public function up()
    {
        $this->createTable('registration', [
            'email'  => Schema::TYPE_STRING . ' NOT NULL PRIMARY KEY',
            'secure' => Schema::TYPE_STRING,
            'used'   => Schema::TYPE_BOOLEAN,
        ]);

        $this->createTable('user', [
            'email'    => Schema::TYPE_STRING . ' NOT NULL PRIMARY KEY',
            'name'     => Schema::TYPE_STRING,
            'password' => Schema::TYPE_STRING,
        ]);

        $this->createIndex('email', 'registration', 'email', true);
        $this->createIndex('email', 'user', 'email', true);
    }

    public function down()
    {
        $this->dropTable('registration');
        $this->dropTable('user');
    }
}
