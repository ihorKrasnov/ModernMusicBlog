<?php

namespace app\controllers;

use Yii;
use app\models\Users;
use app\models\LoginForm;

class UsersController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionRegister()
    {
        $model = new Users();
        $model->authKey = Yii::$app->security->generateRandomString();
        Yii::info('Generated authKey: ' . $model->authKey, __METHOD__);
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            Yii::$app->session->setFlash('success', 'Registration successful!');
            Yii::$app->user->login($model);
            return $this->goHome();
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

}
