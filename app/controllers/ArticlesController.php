<?php

namespace app\controllers;

use app\models\Articles;
use app\models\ArticlesSearch;
use app\models\Comments;
use Yii;

class ArticlesController extends \yii\web\Controller
{
    public function actionIndex($id = null)
    {
        if ($id !== null) {
            // Якщо є параметр 'id', шукаємо статтю
            $searchModel = new ArticlesSearch();
            $searchModel->id = $id;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $post = $dataProvider->getModels()[0];
            $comments = Comments::find()
            ->where(['articleid' => $post->id]) // Фільтруємо по ID статті // Сортуємо по даті створення від новіших до старіших
            ->all();
            $groupedComments = [];
            foreach ($comments as $comment) {
                $groupedComments[$comment->commentid ?? 0][] = $comment;
                $groupedComments[0] = array_reverse($groupedComments[0]);
            }
            
            // Якщо статтю не знайдено, генеруємо помилку 404
            if (!$post) {
                throw new NotFoundHttpException('Стаття не знайдена.');
            }
    
            $comment = new Comments(); // Створення нової моделі коментарів
    
            $comment->articleid = $post->id; // Встановлення статті для коментарів
            if (!Yii::$app->user->isGuest) {
                $comment->authorid = Yii::$app->user->id; // Встановлення автора коментарів
                $comment->author = Yii::$app->user->identity->fullname; // Встановлення імені автора коментарів
            } else {
                $comment->authorid = -1; // Якщо користувач гість
            }
    
            // Перевірка, чи форма коментарів була надіслана
            if ($comment->load(Yii::$app->request->post()) && $comment->save()) {
                $parentId = Yii::$app->request->post('commentid') ?? null; // Отримання ID батьківського коментаря
                if ($parentId) {
                    $comment->commentid = $parentId; // Встановлення батьківського коментаря
                    $comment->save(); // Перезаписуємо коментар з parentId
                }
                
                return $this->refresh(); 
            }
    
            // Якщо стаття знайдена, відображаємо її
            return $this->render('index', [
                'post' => $post,
                'comment' => $comment, // Передача моделі коментарів в представлення
                'groupedComments' => $groupedComments,// Список всіх коментарів до статті
            ]);
        }
    }
    

    public function actionCreate($id = null)
    {
        $model = null;
        if ($id == null) {
            // Створення нової моделі
            $model = new Articles();
            $model->authorid = Yii::$app->user->id; // Встановлення автора статті

            // Перевірка, чи форма була надіслана
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                // Якщо збереження успішне, відображаємо повідомлення та перенаправляємо на список статей (або іншу сторінку)
                Yii::$app->session->setFlash('success', 'Article created successfully!');
                return $this->redirect(['my-articles']); // або ви можете перенаправити на іншу сторінку
            }
        } else {
            // Завантаження статті для редагування
            $model = Articles::findOne($id);

            // Перевірка, чи користувач є автором статті
            if ($model->authorid !== Yii::$app->user->id) {
                throw new ForbiddenHttpException('You are not allowed to edit this article.');
            }

            // Перевірка, чи форма була надіслана
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                // Якщо збереження успішне, відображаємо повідомлення та перенаправляємо на список статей (або іншу сторінку)
                Yii::$app->session->setFlash('success', 'Article updated successfully!');
                return $this->redirect(['my-articles']); // або ви можете перенаправити на іншу сторінку
            }
        }

        // Повернення представлення з передачею моделі
        return $this->render('create', [
            'model' => $model, // Передача моделі в представлення
        ]);
    }

    public function actionMyArticles()
    {
        $searchModel = new ArticlesSearch();
        $searchModel->authorid = Yii::$app->user->id; // Фільтр для відображення тільки статей поточного користувача
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('my-articles', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDelete($id){
        $model = Articles::findOne($id);
        if ($model->authorid !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('You are not allowed to delete this article.');
        }
        $model->delete();
        Yii::$app->session->setFlash('success', 'Article deleted successfully!');
        return $this->redirect(['my-articles']);
    }

}
