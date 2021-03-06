<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m201007_213519_create_user_table extends Migration
{

    public function up()
    {
        $tableOptions = null;

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255)->notNull()->unique(),
            'password_hash' => $this->string(255)->notNull(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'role' => $this->smallInteger()->notNull()
        ], $tableOptions);
        
        
        $this->insert('{{%user}}', [
            'id' => 1,
            'username' => 'admin',
            'password_hash' =>  Yii::$app->security->generatePasswordHash('admin'),
            'email' => 'admin@admin.admin',
            'status' => 1,
            'created_at' => time(),
            'role' => 0
        ]);
        
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
