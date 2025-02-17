<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "supplier".
 *
 * @property int $id
 * @property string $name
 * @property string $contact_name
 * @property string $email
 * @property string $mobile_number
 * @property string|null $telephone_number
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $deleted_at
 */
class Supplier extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public $material;
    public $material_category; 
    public static function tableName()
    {
        return 'supplier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['telephone_number', 'deleted_at'], 'default', 'value' => null],
            [['name', 'contact_name', 'email', 'mobile_number', 'material', 'material_category'], 'required'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['name', 'contact_name', 'email'], 'string', 'max' => 255],
            [['mobile_number', 'telephone_number'], 'string', 'min' => 10],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'contact_name' => 'Contact Name',
            'email' => 'Email',
            'mobile_number' => 'Mobile Number',
            'telephone_number' => 'Telephone Number',
            'material' => 'Material',
            'material_category' => 'Material Category',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getSupplierMaterialCategories()
    {
        return $this->hasMany(SupplierMaterialCategory::class, ['supplier_id' => 'id']);
    }

    public function getMaterials()
    {
        return $this->hasMany(Material::class, ['id' => 'material_id'])
            ->via('supplierMaterialCategories');
    }

    public function getMaterialCategories()
    {
        return $this->hasMany(MaterialCategory::class, ['id' => 'material_category_id'])
            ->via('supplierMaterialCategories');
    }

}
