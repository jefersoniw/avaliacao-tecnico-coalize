<?php

namespace app\models;

use Exception;
use PhpParser\Node\Expr\Throw_;
use Yii;

/**
 * This is the model class for table "clients".
 *
 * @property int $id
 * @property string $name
 * @property string $cpf
 * @property string $address_text
 * @property string $photo
 * @property string $sex
 *
 * @property Product[] $products
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'cpf', 'address_text', 'sex'], 'required'],
            [['address_text'], 'string'],
            [['name'], 'string', 'max' => 60],
            [['photo'], 'string'],
            [['sex'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'cpf' => 'CPF',
            'address_text' => 'Address Text',
            'photo' => 'Photo',
            'sex' => 'Sex',
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['client_id' => 'id']);
    }

    public static function createClient($request, $photo)
    {
        $cpf = str_replace(['.', '/', '-'], '', $request['cpf']);

        $client = new Self;
        $client->name = $request['name'];
        $client->cpf = $cpf;
        $client->photo = $photo;
        $client->address_text = $request['address'];
        $client->sex = $request['sex'];
        if (!$client->save(false)) {
            throw new Exception("Erro ao salvar cliente!");
        }

        return $client;
    }

    public static function validadeInputClient($request)
    {
        if (empty($request['name'])) {
            throw new Exception('Name obrigatório!');
        }
        if (empty($request['cpf'])) {
            throw new Exception('CPF obrigatório!');
        }
        if (empty($request['address'])) {
            throw new Exception('Address obrigatório!');
        }
        if (empty($request['sex'])) {
            throw new Exception('Sex obrigatório!');
        }

        return true;
    }
}
