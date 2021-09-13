<?php

use yii\db\Migration;

/**
 * Class m210913_071312_add_data_users
 */
class m210913_071312_add_data_users extends Migration
{

    public $table = "{{%users}}";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert($this->table, array('username' => 'Gwen', 'auth_key' => 'bVAQ6SzioAsqZmjbSm1_eCXartFQ9E4F','password_hash' => '$2y$13$S72nfzSrR9hjio9.22lWQOjVgJOHqIsSBDkknlIkukmFNatSmD45.', 'email' => 'gwen@gwen.com', 'status' => 10, 'created_at' => time()));
        $this->insert($this->table, array('username' => 'Margo', 'auth_key' => 'bVAQ8SzioAsqZmjbSm1_eCXartFQ9E4F','password_hash' => '$2y$13$S72nfzSrR9hjio9.22lWQOjVgJOHqIsSBDkknlIkukmFNatSmD48.', 'email' => 'margo@margo.com', 'status' => 10, 'created_at' => time()));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable($this->table);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210913_071312_add_data_users cannot be reverted.\n";

        return false;
    }
    */
}
