<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%supplier_material_category}}`.
 */
class m250209_173904_create_supplier_material_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%supplier_material_category}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%supplier_material_category}}');
    }
}
