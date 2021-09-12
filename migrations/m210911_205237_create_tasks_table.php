<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tasks}}`.
 */
class m210911_205237_create_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tasks}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'title' => $this->text()->notNull(),
            'main_photo_id' => $this->integer(),
            'created_at'  => $this->integer()->null(),
            'updated_at'  =>$this->integer()->null(),
        ]);

        $this->createIndex('{{%idx-tasks-user_id}}', '{{%tasks}}', 'user_id');
        $this->createIndex('{{%idx-tasks-main_photo_id}}', '{{%tasks}}', 'main_photo_id');
        $this->addForeignKey('{{%fk-tasks-user_id}}', '{{%tasks}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tasks}}');
    }
}
