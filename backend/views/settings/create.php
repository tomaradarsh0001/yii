<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\AuthItem $model */

$this->title = ($model->type == 1) ? 'Create Role' : 'Create Permission'; 
$this->params['breadcrumbs'][] = ['label' => 'Auth Items', 'url' => ['index']]; 
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- <div class="card-header">
                    <h5 class="card-title"><?= ($model->type == 1) ? 'Create Role' : 'Create Permission' ?></h5> 
                </div> -->
                <div class="card-body">
                    <h5 class="card-title"><?= Html::encode($this->title) ?></h5>
                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
