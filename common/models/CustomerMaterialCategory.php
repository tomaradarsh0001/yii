<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "customer_material_category".
 *
 * @property int $id
 */
class CustomerMaterialCategory extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer_material_category';
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
            'customer_id' => 'Customer ID',
            'material_id' => 'Material ID',
            'material_category_id' => 'Material Category ID'
        ];
    }

    public function getMaterials()
    {
        return $this->hasOne(Material::class, ['material_id' => 'id']);
    }

    public function getMaterialCategories()
    {
        return $this->hasMany(MaterialCategory::class, ['material_category_id' => 'id']);
    }

}
