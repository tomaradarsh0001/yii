<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\MaterialCategoryMapping $model */

$this->title = 'Update Material Category Mapping: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Material Category Mappings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="material-category-mapping-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
