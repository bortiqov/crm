<?php

namespace api\models\form;

use common\models\Company;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\web\BadRequestHttpException;
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
    public $address;
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
            [['login', 'password', 'password_confirm', 'address'], 'string'],
            [['login', 'password', 'password_confirm'], 'required'],
            [['password_confirm'], 'compare', 'compareAttribute' => 'password'],
            [['email', 'website', 'company_name', 'phone', 'boss_full_name'], 'required'],
            [['phone'], 'string', 'max' => 20],
            [['boss_full_name'], 'string', 'max' => 100],
        ];
    }


    /**
     * @return User|false
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        if ($this->id) {
            $this->update();
        }

        $user = $this->create();
        if ($user) {
            return $user;
        }
        return false;

    }

    private function create()
    {
        $transaction = Yii::$app->db->beginTransaction();
        $user = new User([
            'email' => $this->login,
            'status' => User::STATUS_ACTIVE,
            'phone' => $this->phone,
            'role' => User::ROLE_COMPANY
        ]);

        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->setToken();

        if (!$user->save()) {
            $transaction->rollBack();
            $this->addErrors($user->errors);
            return false;
        }

        $company = new Company([
            'email' => $this->email,
            'phone' => $this->phone,
            'website' => $this->website,
            'boss_full_name' => $this->boss_full_name,
            'status' => $this->status,
            'address' => $this->address,
            'company_name' => $this->company_name,
            'user_id' => $user->id,

        ]);

        if (!$company->save()) {
            $transaction->rollBack();
            $this->addErrors($company->errors);
            return false;
        }

        $transaction->commit();
        return $user;


    }

    private function update()
    {
        $user = User::findOne($this->id);
        if (!$user) {
            throw new BadRequestHttpException();
        }

        $user->setAttributes([
            'email' => $this->login,
            'phone' => $this->phone,
            'role' => User::ROLE_COMPANY
        ]);

        if ($this->password) {
            $user->setPassword($this->password);
            $user->generateAuthKey();
        }
        $user->setToken();
        if (!$user->save()) {
            $this->addErrors($user->errors);
            return false;
        }
        /**
         * @var $company Company
         */

        $company = $user->company;

        if (!$company) {
            throw new BadRequestHttpException('This user not found company');
        }

        $company->setAttributes([
            'email' => $this->email,
            'phone' => $this->phone,
            'website' => $this->website,
            'boss_full_name' => $this->boss_full_name,
            'status' => $this->status,
            'address' => $this->address,
            'company_name' => $this->company_name,
        ]);

        if (!$company->save()) {
            $this->addErrors($company->errors);
            return false;
        }
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
            $this->_user = User::findOne($this->id);
        }

        return $this->_user;
    }
}
