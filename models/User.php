<?php

namespace app\models;

use Exception;
use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $authKey
 * @property string $accessToken
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'authKey', 'accessToken'], 'required'],
            [['authKey', 'accessToken'], 'safe'],
            [['username'], 'string', 'max' => 60],
            [['password'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->authKey = Yii::$app->security->generateRandomString();
                $this->accessToken = Yii::$app->security->generateRandomString();
                $this->password = md5($this->password);
            }
            return true;
        }
        return false;
    }

    public function generateNewToken($id)
    {
        try{

            $login = $this->findOne($id);
            $login->authKey = Yii::$app->security->generateRandomString();
            $login->accessToken = Yii::$app->security->generateRandomString();
            if(!$login->save(false)){
                throw new Exception("Erro ao fazer login!");
            }

            return $login;

        }catch(Exception $error){

            return $this->$this->asJson([
                'error' => true,
                'msg' => $error->getMessage()
            ]);

        }
    }

    public static function createUser($request)
    {
        $user = new self();
        $user->username = $request['username'];
        $user->password = $request['password'];
        $user->authKey = Yii::$app->security->generateRandomString();
        $user->accessToken = Yii::$app->security->generateRandomString();
        if(!$user->save(false)){
            throw new Exception("Error insert User");
        };

        return $user;
    }
}
