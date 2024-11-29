<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\models\ArticlesSearch;
use app\models\Articles;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArticlesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Here are your articles';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'title',
        [
            'attribute' => 'topicid',
            'value' => function ($model) {
                return $model->topic->name;
            },
            'filter' => \yii\helpers\ArrayHelper::map(app\models\Topic::find()->all(), 'id', 'name')
        ],
        'created_at',
        [
            'attribute' => 'authorid',
            'value' => function ($model) {
                return $model->author->name;
            },
            // Вимкнення фільтрування за полем authorid, на цій сторінці всі пости належать поточному користувачеві
            'filter' => false
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update} {delete}', // Кнопки перегляду, редагування та видалення
            'urlCreator' => function ($action, Articles $model, $key, $index, $column) {
                // Налаштування URL для кожної кнопки
                if ($action === 'view') {
                    return Url::toRoute(['index', 'id' => $model->id]);
                }
                if ($action === 'update') {
                    return Url::toRoute(['create', 'id' => $model->id]);
                }
                if ($action === 'delete') {
                    return Url::toRoute(['delete', 'id' => $model->id]);
                }
            },
            'contentOptions' => ['class' => 'centered-action'], // Center the action buttons
        ],
    ],
]); ?>