<?php

namespace app\controllers;

use app\models\User;
use Yii;

class LoginController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        $creds = Yii::$app->request->post();
        
        $user = User::findByUsername($creds['username']);

        if(empty($user)){
            return $this->asJson([
                'error' => true,
                'msg' => 'User not exists'
            ]);
        }

        $userPass = $user->validatePassword($creds['password']);

        if(!$userPass){
            return $this->asJson([
                'error' => true,
                'msg' => 'username and password incorrect!'
            ]);
        }

        $res = $user->generateNewToken($user->id);

        return $this->asJson([
            'error' => false,
            'msg' => 'Login realizado com sucesso!',
            'data' => [
                'username' => $res->username,
                'accessToken' => $res->accessToken
            ]
        ]);
    }

}
