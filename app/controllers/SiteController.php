<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\ArticlesSearch;

class SiteController extends Controller
{
    // Додати фільтри для авторизації
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex($tag = null, $topic_id = null)
    {
        $searchModel = new ArticlesSearch();
        if ($tag !== null) {
            // Якщо є параметр 'tag', шукаємо статтю за тегом
            $searchModel->tag = $tag;
        }
        if ($topic_id !== null) {
            // Якщо є параметр 'topic_id', шукаємо статтю за темою
            $searchModel->topicid = $topic_id;
        }

        // Додаємо пагінацію на 9 постів на сторінку
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 9;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionPost($id)
    {
        // Отримуємо статтю за її ID
        $article = Articles::findOne($id);

        // Якщо стаття не знайдена, кидаємо 404
        if ($article === null) {
            throw new \yii\web\NotFoundHttpException('Стаття не знайдена');
        }

        return $this->render('post', [
            'article' => $article
        ]);
    }

    public function actionError()
    {
        // Помилка, що відображається, коли маршрут не знайдено
        return $this->render('error');
    }

    public function actionLogin()
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack(); // Якщо авторизація успішна, перенаправляємо назад
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout(); // Вихід
        return $this->goHome();
    }
}
