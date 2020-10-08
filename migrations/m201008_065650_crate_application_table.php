<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%application}}`.
 */
class m201008_065650_crate_application_table extends Migration
{
    
    public function up()
    {
        $tableOptions = null;
        
        $this->createTable('{{%application}}', [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer()->notNull(),
            'subject' => $this->string(255)->notNull(),
            'message' => $this->text()->notNull(),
            'file' => $this->string(255)->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull()
        ], $tableOptions);
    }
    
    public function down()
    {
        $this->dropTable('{{%application}}');
    }
}
