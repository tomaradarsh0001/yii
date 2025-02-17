<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "material".
 *
 * @property int $id
 * @property string $name
 * @property string|null $short_code
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $deleted_at
 *
 * @property MaterialCategoryMapping[] $materialCategoryMappings
 */
class Material extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'material';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['short_code', 'deleted_at'], 'default', 'value' => null],
            [['name'], 'required'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['name', 'short_code'], 'string', 'max' => 255],
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
            'short_code' => 'Short Code',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     * Gets query for [[MaterialCategoryMappings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialCategoryMappings()
    {
        return $this->hasMany(MaterialCategoryMapping::class, ['material_id' => 'id']);
    }

}
