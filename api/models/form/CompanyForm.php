<?php

namespace api\models\form;

use common\models\User;
use Yii;
use yii\base\Model;
use yii\web\ForbiddenHttpException;

/**
 * Login form
 */
class CompanyForm extends Model
{
    public $email;
    public $password_confirm;
    public $phone;
    public $website;
    public $boss_full_name;
    public $company_name;
    public $status;
    public $id;


    public $login;
    public $password;

    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_name', 'address'], 'string', 'max' => 255],
            [['email', 'website'], 'string', 'max' => 50],
            [['email'], 'email'],
            [['status', 'id'], 'integer'],
            [['login', 'password', 'password_confirm'], 'string'],
            [['password_confirm'], 'compare', 'compareAttribute' => 'password'],
            [['email', 'website', 'company_name', 'phone', 'boss_full_name'], 'required'],
            [['phone'], 'string', 'max' => 20],
            [['boss_full_name'], 'string', 'max' => 100],
        ];
    }


    /**
     * @return User|false|null
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

    }

    private function createUser()
    {

    }

    /**
     * Finds user by [[login]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findOne($this->id);
        }

        return $this->_user;
    }
}
