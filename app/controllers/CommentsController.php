<?php

namespace app\controllers;

use app\models\Comments;
use Exception;
use Yii;

class CommentsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionDeleteComment($commentId)
    {
        $comment = Comments::findOne($commentId);

        // Перевірка, чи існує коментар і чи користувач є автором або адміністратором
        if ($comment && (Yii::$app->user->id == $comment->authorid || Yii::$app->user->identity->is_admin)) {
            $comment->delete();

            // Повертаємо відповідь у форматі JSON
            return $this->asJson(['success' => true]);
        } else {
            // Якщо немає прав або коментар не знайдений, повертаємо помилку
            return $this->asJson(['success' => false, 'message' => 'You are not authorized to delete this comment.']);
        }
    }
}
