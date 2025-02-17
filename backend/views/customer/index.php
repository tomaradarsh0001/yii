<?php

use common\models\Customer;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
/** @var yii\web\View $this */
/** @var common\models\search\Customer $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Customers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-12">
    <div class="card">
        <!-- <h1><?//= Html::encode($this->title) ?></h1> -->
        <div class="card-header">
            <h5 class="card-title">Customer Details</h5>
            <!-- <h6 class="card-subtitle text-muted">Fill the Customer Details</h6> -->
        </div>
        <div class="card-body">
            <p>
                <?= Html::a('Add Customer', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    //'id',
                    'name',
                    'contact_name',
                    'email:email',
                    'mobile_number',
                    //'telephone_number',
                    [
                        'attribute' => 'material',
                        'label' => 'Material',
                        'value' => function($model){
                            return implode(', ', ArrayHelper::getColumn($model->materials, 'name'));
                        }
                    ],
                    //'created_at',
                    //'updated_at',
                    //'deleted_at',
                    [
                        'class' => ActionColumn::class,
                        'urlCreator' => function ($action, Customer $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
