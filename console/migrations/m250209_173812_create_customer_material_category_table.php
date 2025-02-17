<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customer_material_category}}`.
 */
class m250209_173812_create_customer_material_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customer_material_category}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%customer_material_category}}');
    }
}
