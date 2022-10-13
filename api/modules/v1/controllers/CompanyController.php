<?php

namespace api\modules\v1\controllers;

use common\components\CrudController;
use common\models\Company;
use common\models\search\CompanySearch;

class CompanyController extends CrudController
{
    public $modelClass = Company::class;
    public $searchModel = CompanySearch::class;


    public function actionIndex()
    {
        $searchModel = new CompanySearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $dataProvider;
    }

}