<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%customer_material_category}}`.
 */
class m250216_065404_add_columns_to_customer_material_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Add columns
        $this->addColumn('{{%customer_material_category}}', 'material_id', $this->integer()->notNull()->after('id'));
        $this->addColumn('{{%customer_material_category}}', 'material_category_id', $this->integer()->notNull()->after('material_id'));

        // Add foreign keys
        $this->addForeignKey(
            'material-material_id', // Foreign key name
            '{{%customer_material_category}}', // Table where the foreign key is added
            'material_id', // Column in the current table
            '{{%material}}', // Referenced table
            'id', // Referenced column
            'CASCADE', // On delete action
            'CASCADE' // On update action
        );

        $this->addForeignKey(
            'material_category-material_category', 
            '{{%customer_material_category}}', 
            'material_category_id', 
            '{{%material_category}}', 
            'id', 
            'CASCADE', 
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
