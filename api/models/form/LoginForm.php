<?php

namespace api\models\form;

use common\models\User;
use Yii;
use yii\base\Model;
use yii\web\ForbiddenHttpException;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password'], 'required'],
            [['email', 'password'], 'string'],
            // password is validated by validatePassword()
            [['password'], 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $this->_user = $this->getUser();
            if (!$this->_user) {
                $this->addError($attribute, 'Incorrect email or password');
            }
        }
    }

    /**
     * @return User|false|null
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = $this->getUser();
        $user->updateToken();
        Yii::$app->user->login($user, 3600 * 24 * 30);
        return $user;
    }

    /**
     * Finds user by [[login]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }
}
