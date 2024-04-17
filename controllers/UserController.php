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
                throw new Exception('username or passsword empty!');
            }

            $userExists = User::findByUsername($request['username']);

            if(!empty($userExists)){
                throw new Exception('user already exists!');
            }

            $user = new User();
            $user->username = $request['username'];
            $user->password = $request['password'];
            $user->authKey = Yii::$app->security->generateRandomString();
            $user->accessToken = Yii::$app->security->generateRandomString();
            if(!$user->save(false)){
                throw new Exception("Error insert User");
            };

            return $this->asJson([
                'error' => false,
                'msg' => 'Created',
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
