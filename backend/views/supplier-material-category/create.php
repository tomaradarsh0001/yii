<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SupplierMaterialCategory $model */

$this->title = 'Create Supplier Material Category';
$this->params['breadcrumbs'][] = ['label' => 'Supplier Material Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-material-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
