<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "employee".
 *
 * @property int $id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $middle_name
 * @property string|null $passport_number
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $position
 * @property int|null $company_id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $status
 *
 * @property Company $company
 * @property User $createdBy
 * @property User $updatedBy
 */
class Employee extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee';
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
            [['company_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['company_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status'], 'integer'],
            [['company_id', 'first_name', 'last_name', 'middle_name', 'passport_number', 'address', 'phone', 'position'], 'required'],
            [['passport_number'], 'string', 'max' => 9, 'min' => 9],
            [['first_name', 'last_name', 'middle_name', 'address', 'phone', 'position'], 'string', 'max' => 255],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::class, 'targetAttribute' => ['company_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'middle_name' => 'Middle Name',
            'passport_number' => 'Passport Number',
            'address' => 'Address',
            'phone' => 'Phone',
            'position' => 'Position',
            'company_id' => 'Company ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Company]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
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
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    public function fields()
    {
        return [
            'id',
            'first_name',
            'last_name',
            'middle_name',
            'passport_number',
            'address',
            'phone',
            'position',
            'company_id',
            'created_at',
            'updated_at',
            'status'
        ];
    }

    public function extraFields()
    {
        return [
            'company',
        ];
    }
}