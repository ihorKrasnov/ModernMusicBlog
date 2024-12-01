<?php

/** @var yii\web\View $this */
/** @var app\models\Articles $model */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Topic;

$this->title = 'Create New Post';
?>
<div class="articles-create">
    <h1><?=$model->id == null ? "Create New Post" : "Update Post";?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <!-- Заголовок посту -->
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <!-- Контент посту -->
    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <!-- Зображення посту (завантаження файлу) -->
    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <!-- Тема посту (випадаючий список) -->
    <?= $form->field($model, 'topicid')->dropDownList(
        ArrayHelper::map(Topic::find()->all(), 'id', 'name'),
        ['prompt' => 'Select a Topic']  // Додає підказку в випадаючому списку
    ) ?>

    <!-- Теги посту (необов'язкове поле) -->
    <?= $form->field($model, 'tag')->textInput(['maxlength' => true]) ?>

    <!-- Кнопка відправки -->
    <div class="form-group">
        <?= Html::submitButton($model->id == null ? 'Create Post' : 'Update Post', ['class' => 'btn btn-success']) ?>
    </div>
    <?php if ($model->hasErrors()): ?>
    <div class="alert alert-danger">
        <strong>Error!</strong>
        <?php foreach ($model->errors as $error): ?>
            <p><?= implode(', ', $error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
    <?php ActiveForm::end(); ?>
</div>
