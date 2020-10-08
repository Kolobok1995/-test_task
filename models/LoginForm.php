<?php
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *          
 */
class LoginForm extends Model
{

    public $username;

    public $password;

    private $_user = false;

    /**
     *
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [
                [
                    'username',
                    'password'
                ],
                'required'
            ],
            [
                'password',
                'validatePassword'
            ]
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (! $this->hasErrors()) {
            $user = $this->getUser();
            
            

            if (! $user || ! $user->validatePassword($this->password)) {
                $this->addError($attribute, 'Не удаётся войти.  Пожалуйста, проверьте правильность логина и пароля! ' );
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), 3600);
        }
        return false;
    }

    /**
     * Поиск пользователя
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
