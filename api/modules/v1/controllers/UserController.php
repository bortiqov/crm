<?php

namespace api\modules\v1\controllers;

use common\components\CrudController;

use Yii;
use yii\rest\OptionsAction;


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


    public function actionUpdate()
    {
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }

        $form = new UpdateForm();
        $form->setAttributes($requestParams);
        $user = $form->save();

        if (!$user) {
            return $form;
        }

        return $user;
    }


}
