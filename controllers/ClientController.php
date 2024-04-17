<?php

namespace app\controllers;

use app\components\util\Helpers;
use app\models\Client;
use Exception;
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
        
        try {
            Client::validadeInputClient($request);

            $cpf = str_replace(['.', '/', '-'], '', $request['cpf']);

            $cpfIsValid = Helpers::validaCPF($cpf);

            if(!$cpfIsValid){
                return $this->asJson([
                    'error' => true,
                    'msg' => 'CPF inválido!'
                ]);
            }

            $clientExists = Client::find()->where(['cpf' => $cpf])->one();

            if(!empty($clientExists)){
                return $this->asJson([
                    'error' => true,
                    'msg' => 'Client já existe!'
                ]);
            }

            $base64 = base64_encode(
                file_get_contents($_FILES['photo']['tmp_name'])
            );
            $mime = 'data:' . $_FILES['photo']['type'] . ';base64,';

            $photo = $mime.$base64;

        

            $client = Client::createClient($request, $photo);

            return $this->asJson([
                'error' => false,
                'msg' => 'Client cadastrado!',
                'data' => $client,
            ]);

        }catch(Exception $error){

            return $this->asJson([
                'error' => true,
                'msg' => $error->getMessage(),
                'line' => $error->getLine(),
                'file' => $error->getFile(),
            ]);

        }
    }

}
