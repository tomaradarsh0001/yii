<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\MaterialCategoryMapping $model */

$this->title = 'Create Material Category Mapping';
$this->params['breadcrumbs'][] = ['label' => 'Material Category Mappings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="material-category-mapping-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
