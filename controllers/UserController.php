<?php

namespace app\controllers;

use yii\filters\auth\HttpBearerAuth;
use yii\web\Controller;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'bearerAuth' => [
                'class' => HttpBearerAuth::class,
            ]
        ];
    }

    public function actionIndex()
    {
        var_dump('im here');exit;
    }

}
