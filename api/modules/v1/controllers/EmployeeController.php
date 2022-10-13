<?php

namespace api\modules\v1\controllers;

use common\components\CrudController;
use common\models\Company;
use common\models\Employee;
use common\models\search\CompanySearch;
use common\models\search\EmployeeSearch;

class EmployeeController extends CrudController
{
    public $modelClass = Employee::class;
    public $searchModel = EmployeeSearch::class;


    public function actionIndex()
    {
        $searchModel = new EmployeeSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $dataProvider;
    }

}