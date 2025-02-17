<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "material_category_mapping".
 *
 * @property int $id
 * @property int $material_id
 * @property int $material_category_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Material $material
 * @property MaterialCategory $materialCategory
 */
class MaterialCategoryMapping extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'material_category_mapping';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['material_id', 'material_category_id'], 'required'],
            [['material_id', 'material_category_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['material_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => MaterialCategory::class, 'targetAttribute' => ['material_category_id' => 'id']],
            [['material_id'], 'exist', 'skipOnError' => true, 'targetClass' => Material::class, 'targetAttribute' => ['material_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'material_id' => 'Material ID',
            'material_category_id' => 'Material Category ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Material]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMaterial()
    {
        return $this->hasOne(Material::class, ['id' => 'material_id']);
    }

    /**
     * Gets query for [[MaterialCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialCategory()
    {
        return $this->hasOne(MaterialCategory::class, ['id' => 'material_category_id']);
    }

}
