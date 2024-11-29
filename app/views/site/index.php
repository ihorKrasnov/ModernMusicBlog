<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
/** @var yii\web\View $this */

$this->title = 'Welcome to Modern Music';
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
        <?php foreach ($dataProvider->getModels() as $post): ?>
                <div class="col-lg-4 mb-3">
                    <h2><?= Html::encode($post->title) ?></h2> <!-- Assuming you have a 'title' field in your post model -->

                    <p><?= Html::encode($post->content) ?></p> <!-- Assuming you have a 'excerpt' or a short summary field -->

                    <p><a class="btn btn-outline-primary" href="<?= Url::to(['articles/index', 'id' => $post->id]) ?>">Read full text &raquo;</a></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
