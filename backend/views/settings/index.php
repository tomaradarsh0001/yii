<?php

use common\models\AuthItem;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Roles And Permissions';
$this->params['breadcrumbs'][] = $this->title;
$type = Yii::$app->request->get('type');
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                
                <div class="card-body">
                    <h5 class="card-title"><?= Html::encode($this->title) ?></h5>
                    <p>
                        <?php if ($type == 1): ?>
                            <?= Html::a('Create Role', ['create', 'type' => 1], ['class' => 'btn btn-success']) ?>
                        <?php elseif ($type == 2): ?>
                            <?= Html::a('Create Permission', ['create', 'type' => 2], ['class' => 'btn btn-success']) ?>
                        <?php endif; ?>
                    </p>

                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <?= Html::a('Roles', ['index', 'type' => 1], ['class' => 'nav-link ' . ($type == 1 ? 'active' : '')]) ?>
                        </li>
                        <li class="nav-item">
                            <?= Html::a('Permissions', ['index', 'type' => 2], ['class' => 'nav-link ' . ($type == 2 ? 'active' : '')]) ?>
                        </li>
                    </ul>


                    <?php Pjax::begin(); ?>


                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'name',
                            [
                                'attribute' => 'type',
                                'value' => function ($model) {
                                    return $model->type == 1 ? 'Role' : 'Permission';
                                },
                            ],
                            'description:ntext',
                            /*  'rule_name',
                                'data', */
                            [
                                'class' => ActionColumn::className(),
                                'urlCreator' => function ($action, AuthItem $model, $key, $index, $column) {
                                    return Url::toRoute([$action, 'name' => $model->name]);
                                },
                            ],
                        ],
                    ]); ?>

                    <?php Pjax::end(); ?>

                </div>
            </div>
        </div>
    </div>
    <!-- <div class="auth-item-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Auth Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            /* 'type', */
            'description:ntext',
            /* 'rule_name', */
            /*  'data', */
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, AuthItem $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'name' => $model->name]);
                }
            ],
        ],
    ]); ?>


</div> -->