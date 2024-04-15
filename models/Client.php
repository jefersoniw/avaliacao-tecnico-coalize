<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients".
 *
 * @property int $id
 * @property string $name
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
            [['name', 'address_text', 'photo', 'sex'], 'required'],
            [['address_text'], 'string'],
            [['name'], 'string', 'max' => 60],
            [['photo'], 'string', 'max' => 255],
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
}
