<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%material_category}}`.
 */
class m250209_154304_create_material_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%material_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'short_code' => $this->string(255)->null(),
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
        //$this->dropTable('{{%material_category}}');
        echo "class m250209_154304_create_material_category_table extends Migration cannot be reverted.\n";
        return false;
    }
}
