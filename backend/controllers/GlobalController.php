<?php

namespace backend\controllers;

use Yii;
use common\models\MaterialCategory;
use common\models\MaterialCategoryMapping;
use yii\helpers\ArrayHelper;


class GlobalController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionMaterialCategory(){

       $data = Yii::$app->request->post();
       $material_categories = ArrayHelper::map(MaterialCategoryMapping::find()->where(['material_id' => $data['material_id']])->all(), 'id', 'materialCategory.name');
       return json_encode($material_categories) ?? NULL;
    }

}
