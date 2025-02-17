<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\CustomerMaterialCategory $model */

$this->title = 'Create Customer Material Category';
$this->params['breadcrumbs'][] = ['label' => 'Customer Material Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-material-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
