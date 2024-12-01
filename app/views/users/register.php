<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Sign up';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-box">
    <div class="site-login">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>Please fill out the following fields to register new account:</p>

        <div class="row">
            <div class="col-lg-12">

                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'fieldConfig' => [
                        'template' => "{label}\n{input}\n{error}",
                        'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                        'inputOptions' => ['class' => 'col-lg-3 form-control'],
                        'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                    ],
                ]); ?>

                <?= $form->field($model, 'fullname')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                    <div>
                        <?= Html::submitButton('Sign up', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
                <?php if ($model->hasErrors()): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($model->errors as $error): ?>
                                <li><?= Html::encode($error[0]) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>