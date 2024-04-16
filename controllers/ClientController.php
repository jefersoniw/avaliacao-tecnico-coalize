<?php

namespace app\controllers;

use app\models\Client;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

class ClientController extends \yii\web\Controller
{

    public $enableCsrfValidation = false;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'authMethods' => [
                HttpBasicAuth::class,
                HttpBearerAuth::class,
                QueryParamAuth::class,
            ],
        ];
        
        return $behaviors;
    }

    public function actionIndex()
    {
        $clients = Client::find()->all();

        return $this->asJson($clients);
    }

    public function actionCreate()
    {
        $request = Yii::$app->request->post();

        var_dump($request, $_FILES);exit;
    }

}
