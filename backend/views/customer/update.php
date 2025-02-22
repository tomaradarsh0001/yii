<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Customer $model */

$this->title = 'Update Customer: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="customer-update">

    <!-- <h1><?//= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
