<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
/** @var yii\web\View $this */

$this->title = 'Welcome to Modern Music';

$topics = \app\models\Topic::find()->all();
$currentTopicId = Yii::$app->request->get('topic_id');
?>
 <!-- Меню тем -->
        <div class="topics-menu-container">
            <ul>
                <?php foreach ($topics as $topic): ?>
                    <li class="list-inline-item <?= $currentTopicId == $topic->id ? 'active' : '' ?>">
                        <?= Html::a(Html::encode($topic->name), ['index', 'topic_id' => $topic->id], ['class' => 'btn btn-link']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
<div class="site-index">
    <div class="body-content">
        <div class="row">
        <?php foreach ($dataProvider->getModels() as $post): ?>
                <div class="col-lg-4 mb-3">
                    <h2><?= Html::encode($post->title) ?></h2> <!-- Assuming you have a 'title' field in your post model -->

                    <?php
                        $content = Html::encode($post->content);
                        $words = explode(' ', $content); // Розбиваємо текст на слова

                        // Якщо слів більше ніж 20, обрізаємо і додаємо "..."
                        if (count($words) > 20) {
                            $words = array_slice($words, 0, 20);
                            $content = implode(' ', $words) . '...';
                        } else {
                            $content = implode(' ', $words); // Якщо слів менше або рівно 20, просто виводимо весь текст
                        }
                    ?>
                        <p><?= $content ?></p>
                    
                    <p><strong>Published:</strong> <?= Yii::$app->formatter->asDate($post->created_at, 'long') ?></p> <!-- Виводимо дату -->
                    <p><a class="btn btn-outline-primary" href="<?= Url::to(['articles/index', 'id' => $post->id]) ?>">Read full text &raquo;</a></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
