<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\User;
use yii\helpers\Url;
use app\models\ContactForm;
use yii\web\UploadedFile;

class FeedbackController extends \yii\web\Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                // 'only' => ['index'],
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => false,
                        'roles' => [
                            '?'
                        ],
                        'denyCallback' => function ($rule, $action) {
                            return $this->redirect(Url::toRoute([
                                '/site/login'
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
                            $user = Yii::$app->getUser()->identity;
                            return $user->role == User::ROLE_CLIENT;
                        }
                    ]
                ],

                'denyCallback' => function ($rule, $action) {
                    return $this->redirect(Url::toRoute([
                        '/login'
                    ]));
                }
            ]
        ];
    }
    
   
    
    public function actionIndex()
    {
        $model = new ContactForm();
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');            
            if($model->contact()){      
                Yii::$app->session->setFlash('contactFormSubmitted');                
            }
                        
            return $this->refresh();
        }
        return $this->render('index', [
            'model' => $model
        ]);
        
    }

}
