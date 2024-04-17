<?php

namespace app\models;

use Exception;
use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property int $client_id
 * @property string $photo
 *
 * @property Client $client
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price', 'client_id', 'photo'], 'required'],
            [['price'], 'number'],
            [['client_id'], 'integer'],
            [['name', 'photo'], 'string', 'max' => 255],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
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
            'price' => 'Price',
            'client_id' => 'Client ID',
            'photo' => 'Photo',
        ];
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }

    public static function valideInputProduct($request)
    {
        if (empty($request['name'])) {
            throw new Exception('Name obrigatório!');
        }
        if (empty($request['price'])) {
            throw new Exception('Price obrigatório!');
        }
        if (empty($request['client'])) {
            throw new Exception('Client obrigatório!');
        }

        return true;
    }

    public static function createProduct($request, $photo)
    {
        $price = str_replace(['.', ','], ['', '.'], $request['price']);

        $product = new Self;
        $product->name = $request['name'];
        $product->price = number_format($price, 2, '.', '');
        $product->photo = $photo;
        $product->client_id = $request['client'];
        if (!$product->save(false)) {
            throw new Exception("Erro ao salvar produto!");
        }

        return $product;
    }
}
