<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\AuthItem $model */

$this->title = $model->name;
/* $this->params['breadcrumbs'][] = ['label' => 'Auth Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title; */
\yii\web\YiiAsset::register($this);
?>

<div class="content"> 
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title"><?= Html::encode($this->title) ?></h5>
                    </div>
                    <div class="card-body">
                        <p>
                            <?= Html::a('Update', ['update', 'name' => $model->name], ['class' => 'btn btn-primary']) ?>
                            <?= Html::a('Delete', ['delete', 'name' => $model->name], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </p>

                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'name',
                                [
                                    'attribute' => 'type',
                                    'value' => function ($model) {
                                        return $model->type == 1 ? 'Role' : 'Permission';
                                    },
                                ],
                                'description:ntext',
                                'rule_name',
                                'data',
                                'created_at',
                                'updated_at',
                            ],
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>