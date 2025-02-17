<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\AuthItem $model */

$this->title = 'Update Auth Item: ' . $model->name;
/* $this->params['breadcrumbs'][] = ['label' => 'Auth Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'name' => $model->name]];
$this->params['breadcrumbs'][] = 'Update'; */
?>

<div class="container-fluid">
    <h1 class="h3 mb-3">Update <?= ($model->type == 1) ? 'Role' : 'Permission' ?>: <?= Html::encode($model->name) ?></h5></h1> 
        <div class="row">
            <div class="col-12">
                <div class="card">
                    
                    <div class="card-body">

   

                        <?= $this->render('_form', [
                            'model' => $model,
                        ]) ?>
                    </div>
            </div>
        </div>
    </div>
</div>

