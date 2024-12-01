<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Post $post */

$this->title = Html::encode($post->title); // Встановлюємо заголовок сторінки
?>

<!-- Заголовок статті -->
<div class="post-header">
    <h1><?= Html::encode($post->title) ?></h1> <!-- Заголовок статті -->

    <!-- Інформація про автора і дату створення -->
    <div class="post-meta">
        <p><strong><?= Html::encode($post->author->fullname) ?></strong></p>
        <p><strong>Published:</strong> <?= Yii::$app->formatter->asDate($post->created_at, 'long') ?></p> <!-- Виводимо дату -->
    </div>
</div>

<!-- Вміст статті (по центру) -->
<div class="post-content text-center">
    <?php if (!empty($post->image)): ?>
        <img style="width: 100%" src="<?= Url::to(['articles/view-image', 'id' => $post->id]) ?>" alt="Article Image">
    <?php endif; ?>
</div>
<div class="post-content text-center">
    <?= Html::encode($post->content) ?> <!-- Виводимо контент статті -->
</div>

<div class="post-tags-links">
    <?php
    $tags = explode(' ', $post->tag);
    foreach ($tags as $tag) {
        // Перевіряємо, чи тег не починається з '#'
        if (strpos($tag, '#') !== 0) {
            $viewtag = '#' . $tag; // Додаємо '#' на початок тега, якщо його немає
        } else {
            $viewtag = $tag;
        }
        
        // Виводимо тег із посиланням
        echo Html::a(Html::encode($viewtag), Url::to(['/', 'tag' => $tag]), ['class' => 'tag-link']) . ' ';
    }
    ?>
</div>

<div style="text-align: center; margin-top: 1.5rem">
    <!-- Facebook -->
    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= Url::to(['post/view', 'id' => $post->id], true) ?>" target="_blank" class="btn btn-facebook">
        <!-- <i class="fa fa-facebook"></i> -->
        <img src="/ico/facebook-f.svg" alt="Facebook" class="social-icon" />
        <!-- Іконка Facebook -->
    </a>

    <!-- Twitter -->
    <a href="https://twitter.com/intent/tweet?url=<?= Url::to(['post/view', 'id' => $post->id], true) ?>&text=<?= urlencode($post->title) ?>" target="_blank" class="btn btn-twitter">
        <!-- <i class="fa fa-twitter"></i> Іконка Twitter -->
        <img src="/ico/twitter.svg" alt="Facebook" class="social-icon" />
    </a>

    <!-- LinkedIn -->
    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= Url::to(['post/view', 'id' => $post->id], true) ?>&title=<?= urlencode($post->title) ?>" target="_blank" class="btn btn-linkedin">
        <!-- <i class="fa fa-linkedin"></i> Іконка LinkedIn -->
        <img src="/ico/linkedin.svg" alt="Facebook" class="social-icon" />
    </a>

    <!-- WhatsApp -->
    <a href="https://api.whatsapp.com/send?text=<?= urlencode($post->title . ' ' . Url::to(['post/view', 'id' => $post->id], true)) ?>" target="_blank" class="btn btn-whatsapp">
        <!-- <i class="fa fa-whatsapp"></i> Іконка WhatsApp -->
        <img src="/ico/whatsapp.svg" alt="Facebook" class="social-icon" />
    </a>

    <!-- Telegram -->
    <a href="https://t.me/share/url?url=<?= Url::to(['post/view', 'id' => $post->id], true) ?>&text=<?= urlencode($post->title) ?>" target="_blank" class="btn btn-telegram">
        <!-- <i class="fa fa-telegram"></i> Іконка Telegram -->
        <img src="/ico/telegram.svg" alt="Facebook" class="social-icon" />
    </a>

    <!-- Gmail -->
    <a href="mailto:?subject=<?= urlencode($post->title) ?>&body=<?= urlencode($post->title . ' ' . Url::to(['post/view', 'id' => $post->id], true)) ?>" target="_blank" class="btn btn-gmail">
        <!-- <i class="fa-brands fa-google"></i>Іконка Gmail -->
        <img src="/ico/google.svg" alt="Facebook" class="social-icon" />
    </a>
</div>

<div class="comments-list">
    <h3>Comments:</h3>
    <!-- Форма для додавання нового коментаря (загальна форма для статті) -->
    <div class="comment-toggle">
        <!-- Кнопка для відкриття форми коментаря -->
        <span id="toggle-comment-form" class="comment btn-primary">
            Add Comment
        </span>
    </div>

    <div class="comment-form" id="comment-form" style="display: none;">
        <h3>Add comment</h3>
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($comment, 'author')->textInput(['maxlength' => true, 'placeholder' => 'Name'])->label('Name') ?>
        <?= $form->field($comment, 'message')->textarea(['rows' => 6, 'placeholder' => 'Text'])->label('Text') ?>

        <?= Html::submitButton('Add', ['class' => 'btn btn-primary']) ?>

        <?php ActiveForm::end(); ?>
    </div>

    <?php
    // Виведення коментарів з відступами
    foreach ($groupedComments as $parentCommentId => $commentsGroup) {
        // Перевірка, чи є батьківський коментар
        if ($parentCommentId == 0) {
            // Батьківські коментарі (позиція 0)
            foreach ($commentsGroup as $parentComment) {
    ?>
                <div class="comment-item" id="comment-<?= $parentComment->id ?>" style="margin-left: 0;">
                    <strong><?= Html::encode($parentComment->author) ?></strong><br>
                    <?= Html::encode($parentComment->message) ?><br>
                    <small><?= Yii::$app->formatter->asDatetime($parentComment->created_at) ?></small><br>

                    <!-- Виведення відповідей на батьківський коментар -->
                    <div class="replies">
                        <?php
                        // Перевірка чи є нащадки
                        if (isset($groupedComments[$parentComment->id])) {
                            foreach ($groupedComments[$parentComment->id] as $reply) {
                        ?>
                                <div class="reply-item" style="margin-left: 50px;">
                                    <strong><?= Html::encode($reply->author) ?></strong><br>
                                    <?= Html::encode($reply->message) ?><br>
                                    <small><?= Yii::$app->formatter->asDatetime($reply->created_at) ?></small><br>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <span class="comment reply-btn" style="font-size: 16px !important;" data-comment-id="<?= $parentComment->id ?>">Reply</span>
                    <div class="comment-form" id="reply-form-<?= $parentComment->id ?>" style="display: none;">
                        <h3>Add comment</h3>
                        <?php $form = ActiveForm::begin(); ?>

                        <?= Html::hiddenInput('commentid', $parentComment->id); ?>

                        <?= $form->field($comment, 'author')->textInput(['maxlength' => true, 'placeholder' => 'Name'])->label('Name') ?>
                        <?= $form->field($comment, 'message')->textarea(['rows' => 6, 'placeholder' => 'Text'])->label('Text') ?>

                        <?= Html::submitButton('Add', ['class' => 'btn btn-primary']) ?>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
    <?php
            }
        }
    }
    ?>

    <!-- JavaScript для відкриття/закриття форми для коментаря -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toggleButton = document.getElementById("toggle-comment-form");
            const commentForm = document.getElementById("comment-form");

            // Перевіряємо, чи існують елементи перед тим, як працювати з ними
            if (toggleButton && commentForm) {
                toggleButton.addEventListener("click", function() {
                    // Перемикаємо видимість форми для коментаря
                    if (commentForm.style.display === "none") {
                        commentForm.style.display = "block";
                    } else {
                        commentForm.style.display = "none";
                    }
                });
            }

            const replyBtns = document.getElementsByClassName("reply-btn");
            for (let i = 0; i < replyBtns.length; i++) {
                replyBtns[i].addEventListener("click", function() {
                    const commentId = this.getAttribute("data-comment-id");
                    const replyForm = document.getElementById("reply-form-" + commentId);

                    // Перевіряємо, чи існує форма відповіді перед тим, як змінювати її стиль
                    if (replyForm) {
                        if (replyForm.style.display === "none") {
                            replyForm.style.display = "block";
                        } else {
                            replyForm.style.display = "none";
                        }
                    }
                });
            }
        });
    </script>

</div>
