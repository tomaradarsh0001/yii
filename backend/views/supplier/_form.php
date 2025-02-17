<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Material;
/** @var yii\web\View $this */
/** @var common\models\Supplier $model */
/** @var yii\widgets\ActiveForm $form */

$script = <<< JS
    $('#material-dropdown').on('change', function() {
        var materiallId = $(this).val();
        $.ajax({
            type: 'POST',
            url: "index.php?r=global/material-category",
            data: {material_id: materiallId},
            dataType: 'json',
            success: function(data) {
                console.log(data);
                $('#category-dropdown').empty(); // Clear previous options
                $('#category-dropdown').append('<option value="">Select</option>'); // Default option

                $.each(data, function(key, value) {
                    $('#category-dropdown').append('<option value="' + key + '">' + value + '</option>');
                });
            },
            error: function(xhr) {
                console.error("Error:", xhr.responseText);
            }
        });
    });
JS;
$this->registerJs($script);
?>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title"><?php echo $model->isNewRecord ? 'Add' : 'Update';  ?> Supplier</h5>
            <h6 class="card-subtitle text-muted">Fill the Supplier Details</h6>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6 col-sm-6">
                    <?= $form->field($model, 'contact_name')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6 col-sm-6">
                    <?= $form->field($model, 'mobile_number')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <?= $form->field($model, 'telephone_number')->textInput(['maxlength' => true]) ?>
                </div>
                
            </div>

            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <?= $form->field($model, 'material')->dropDownList(ArrayHelper::map(Material::find()->all(), 'id', 'name'), 
                            [
                                'prompt' => 'Select', 
                                'id' => 'material-dropdown'
                            ]) ?>
                </div>
                <div class="col-md-6 col-sm-6">
                    <?= $form->field($model, 'material_category')->dropDownList([],
                            ['id' => 'category-dropdown']) ?>
                </div>
            </div>

            <div class="row mt-2">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
            
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
