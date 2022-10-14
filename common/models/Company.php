<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property string|null $company_name
 * @property string|null $address
 * @property string|null $email
 * @property string|null $website
 * @property string|null $phone
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $user_id
 * @property int|null $status
 * @property string|null $boss_full_name
 *
 * @property User $createdBy
 * @property Employee[] $employees
 * @property User $updatedBy
 * @property User $user
 */
class Company extends \yii\db\ActiveRecord
{

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'created_by', 'updated_by', 'user_id', 'status'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'created_by', 'updated_by', 'user_id', 'status'], 'integer'],
            [['status'], 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
            [['company_name', 'address'], 'string', 'max' => 255],
            [['email', 'website'], 'string', 'max' => 50],
            [['email'], 'email'],
            [['email', 'website', 'company_name', 'phone', 'boss_full_name'], 'required'],
            [['phone'], 'string', 'max' => 20],
            [['boss_full_name'], 'string', 'max' => 100],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_name' => 'Company Name',
            'address' => 'Address',
            'email' => 'Email',
            'website' => 'Website',
            'phone' => 'Phone',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'user_id' => 'User ID',
            'status' => 'Status',
            'boss_full_name' => 'Boss Full Name',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[Employees]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employee::class, ['company_id' => 'id']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function fields()
    {
        return [
            'id',
            'company_name',
            'boss_full_name',
            'address',
            'phone',
            'email',
            'website',
            'created_at',
            'updated_at',
            'status',
            'user_id'
        ];
    }

    public function extraFields()
    {
        return [
            'user',
        ];
    }
}
