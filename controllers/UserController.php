<?php

namespace app\controllers;

use app\models\User;
use Exception;
use Yii;

class UserController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $users = User::find()->select(['id', 'username'])->all();

        return $this->asJson($users);
    }

    public function actionCreate()
    {
        $request = Yii::$app->request->post();

        try{

            if(empty($request['username']) || empty($request['password'])){
                throw new Exception('username ou passsword vazio!');
            }

            $userExists = User::findByUsername($request['username']);

            if(!empty($userExists)){
                throw new Exception('Usuário já existe!');
            }

            $user = User::createUser($request);

            return $this->asJson([
                'error' => false,
                'msg' => 'Usuário cadastrado!',
                'data' => [
                    'name' => $user->username,
                    'accessToken' => $user->accessToken
                ],
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
