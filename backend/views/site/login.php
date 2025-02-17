<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
?>
<main class="d-flex w-100 h-100">
    <div class="container d-flex flex-column">
        <div class="row vh-100">
            <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">
                    <div class="mt-5 offset-lg-3 col-lg-6">

                        <div class="text-center mt-4">
							<h1 class="h2">Welcome </h1>
							<p class="lead">
								Sign in to your account to continue
							</p>
						</div>
                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-3">
                                    <h1><?= Html::encode($this->title) ?></h1>

                                    <p>Please fill out the following fields to login:</p>

                                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'form-control form-control-lg']) ?>
                                        </div>
                                        <?= $form->field($model, 'password')->passwordInput() ?>

                                        <?= $form->field($model, 'rememberMe')->checkbox() ?>

                                        <div class="form-group">
                                            <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                                        </div>

                                    <?php ActiveForm::end(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
