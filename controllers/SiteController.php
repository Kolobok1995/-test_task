<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\helpers\Url;
use app\models\User;
use app\models\SignupForm;

class SiteController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            if (Yii::$app->getUser()->identity->role == User::ROLE_CLIENT) {
                return $this->redirect(Url::to('/feedback'));
            }

            if (Yii::$app->getUser()->identity->role == User::ROLE_MANAGER) {
                return $this->redirect(Url::to('/application'));
            }
        }


        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (Yii::$app->getUser()->identity->role == User::ROLE_CLIENT) {
                return $this->redirect(Url::to('/feedback'));
            } else {
                if (Yii::$app->getUser()->identity->role == User::ROLE_MANAGER) {
                    return $this->redirect(Url::to('/application'));
                }
            }
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Signup action.
     *
     * @return Response
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        $user = new User();

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            return $this->redirect(Url::to('/login'));
        }

        return $this->render('signup', [
            'model' => $model
        ]);
    }


}
