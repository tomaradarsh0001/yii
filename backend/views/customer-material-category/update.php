<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\CustomerMaterialCategory $model */

$this->title = 'Update Customer Material Category: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Customer Material Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="customer-material-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
