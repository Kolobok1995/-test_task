<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\helpers\Url;
use app\models\User;
use app\models\SignupForm;

class SiteController extends Controller
{

    /**
     *
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout', 'signup'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup'],
                        'roles' => [],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
        
        
        /***/
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => false,
                        'roles' => [
                            '?'
                        ],
                        'denyCallback' => function ($rule, $action) {
                            return $this->redirect(Url::toRoute([
                                '/login'
                            ]));
                        }
                    ],
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => [
                            '@'
                        ],
                        'matchCallback' => function ($rule, $action) {
                            /** @var User $user */
                            $user = Yii::$app->user->getIdentity();
                            return $user->isAdmin() || $user->isManager();
                        }
                    ]
                ]
            ]
        ];
        /***/
        
        
        
    }

    /**
     *
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ]
        ];
    }

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
        if (! Yii::$app->user->isGuest) {
          // return $this->goHome();
            
            if (Yii::$app->getUser()->identity->role === User::ROLE_CLIENT) {
                return $this->redirect(Url::to('/contact'));
            } else {
                if (Yii::$app->getUser()->identity->role === User::ROLE_MANAGER) {
                    return $this->redirect(Url::to('/application'));
                }
            }
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (Yii::$app->getUser()->identity->role === User::ROLE_CLIENT) {
                return $this->redirect(Url::to('/contact'));
            } else {
                if (Yii::$app->getUser()->identity->role === User::ROLE_MANAGER) {
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

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
