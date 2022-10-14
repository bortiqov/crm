<?php

namespace api\modules\v1\controllers;

use api\models\form\CompanyForm;
use common\components\CrudController;

use common\models\User;
use Yii;
use yii\rest\OptionsAction;
use yii\web\NotFoundHttpException;


/**
 * User controller for the `v1` module
 */
class UserController extends CrudController
{

    public function actions()
    {
        return [
            'options' => [
                'class' => OptionsAction::class
            ]
        ];
    }

    public function actionGetMe()
    {
        return \Yii::$app->user->identity;
    }

    /**
     * @return \api\models\form\LoginForm|\common\models\User|false|null
     * @throws \yii\base\InvalidConfigException
     */
    public function actionLogin()
    {
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }

        $form = new \api\models\form\LoginForm();
        $form->setAttributes($requestParams);

        if ($user = $form->save()) {
            return $user;
        }
        return $form;

    }

    public function actionCreate()
    {
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }

        $form = new CompanyForm();
        $form->setAttributes($requestParams);
        $user = $form->save();

        if ($user instanceof User) {
            return $user;
        }
        return $form;
    }


    public function actionUpdate($id)
    {
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }

        $form = new CompanyForm(['id' => $id]);
        $form->setAttributes($requestParams);
        $user = $form->save();

        if ($user instanceof User) {
            return $user;
        }
        return $form;
    }

    public function actionDelete($id)
    {
        $user = User::findOne($id);
        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        return $user->delete();

    }


}
