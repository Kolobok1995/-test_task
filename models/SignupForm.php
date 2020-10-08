<?php
namespace app\models;

use yii\base\Model;
use Yii;

class SignupForm extends Model
{

    public $username;

    public $password;

    public $repeatPassword;

    public $email;

    public function rules()
    {
        return [
            [
                [
                    'username',
                    'password',
                    'repeatPassword',
                    'email'
                ],
                'required',
                'message' => 'Заполните поле'
            ],
            [
                [
                    'email'
                ],
                'email'
            ],
            ['repeatPassword', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match" ],
            
        ];
    }



    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'repeatPassword' => 'Повторить пароль'
        ];
    }

    public function signup()
    {
        $user = new User();

        $user->username = $this->username;
        $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        $user->email = $this->email;
        $user->created_at = time();
        $user->role = User::ROLE_CLIENT;
        $user->status = User::STATUS_ACTIVE;

        if ($this->validate()) {
            return $user->save();
        }
        return false;
    }
}