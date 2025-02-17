<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%material_category_mapping}}`.
 */
class m250209_154319_create_material_category_mapping_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%material_category_mapping}}', [
            'id' => $this->primaryKey(),
            'material_id' => $this->integer()->notNull(),
            'material_category_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression ('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

         // Create foreign key for material_id
        $this->addForeignKey(
            'fk-material_category_mapping-material_id',
            '{{%material_category_mapping}}',
            'material_id',
            '{{%material}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Create foreign key for material_category_id
        $this->addForeignKey(
            'fk-material_category_mapping-material_category_id',
            '{{%material_category_mapping}}',
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
        //$this->dropTable('{{%material_category_mapping}}');
        echo "class m250209_154319_create_material_category_mapping_table extends Migration cannot be reverted.\n";
        return false;
    }
}
