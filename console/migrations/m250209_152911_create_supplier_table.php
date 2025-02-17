<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%supplier}}`.
 */
class m250209_152911_create_supplier_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%supplier}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'contact_name' => $this->string(255)->notNull(),
            'email' => $this->string(255)->notNull()->unique(),
            'mobile_number' => $this->string(20)->notNull(),
            'telephone_number' => $this->string(20)->null(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'deleted_at' => $this->timestamp()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        //$this->dropTable('{{%supplier}}');
        echo "m250209_152911_create_supplier_table cannot be reverted.\n";
        return false;
    }
}
