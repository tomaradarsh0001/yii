<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "supplier_material_category".
 *
 * @property int $id
 */
class SupplierMaterialCategory extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supplier_material_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'material_id' => 'Material ID',
            'material_category_id' => 'Material Category ID'
        ];
    }

}
