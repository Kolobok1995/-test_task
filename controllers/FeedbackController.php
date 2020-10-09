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
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => false,
                        'roles' => [
                            '?'
                        ],
                        'denyCallback' => function ($rule, $action) {
                        return $this->redirect(Url::toRoute('/login'));
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
                    return $this->redirect(Url::home());
                }
            ]
        ];
    }
    

    
    public function actionIndex()
    {
        $model = new ContactForm();
        if (Yii::$app->request->isPost) {
            
            $timeLeft = $model->lastApplicationForUser;
            
            $hour=($timeLeft/3600)%24;
            $min=($timeLeft/60)%60;
            
          //  echo ($hour . ' ' . $min );
            
            
            if($timeLeft === true){
                $model->load(Yii::$app->request->post());
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');            
                if($model->contact()){      
                    Yii::$app->session->setFlash('contactFormSubmitted');                
                }
            } else{
                Yii::$app->session->setFlash('contactFormErrorTime', "$hour час(ов) $min минут(ы)");
                
            }
            return $this->refresh();
        }
        return $this->render('index', [
            'model' => $model
        ]);
        
    }

}
