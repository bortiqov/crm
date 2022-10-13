<?php

namespace api\controllers;

use GuzzleHttp\Client;
use yii\rest\Controller;

class SiteController extends Controller
{

    public function actionIndex()
    {
        return [
            "code" => 1,
            "success" => "Welcome to test api"
        ];
    }


}