<?php

namespace app\controllers;

use app\models\Product;
use Exception;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

class ProductController extends \yii\web\Controller
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

        $filter = yii::$app->request->get();
        $conditions = [];

        if (!empty($filter['client_id'])) {

            $conditions = ['client_id' => $filter['client_id']];
        }

        $products = Product::find()->where($conditions);

        $provider = new ActiveDataProvider([
            'query' => $products,
            'pagination' => [
                'pageSize' => 1
            ]
        ]);

        $totalProducts = $provider->getTotalCount();
        $itensPorPagina = $provider->getCount();

        $allProducts = $provider->getModels();


        return $this->asJson([
            'total_de_clientes' => $totalProducts,
            'itens_por_pagina' => $itensPorPagina,
            'dados' => $allProducts
        ]);
    }

    public function actionCreate()
    {
        $request = Yii::$app->request->post();

        try {

            Product::valideInputProduct($request);

            if (!$_FILES) {
                return $this->asJson([
                    'error' => true,
                    'msg' => 'Campo photo obrigatório!'
                ]);
            }

            $base64 = base64_encode(
                file_get_contents($_FILES['photo']['tmp_name'])
            );
            $mime = 'data:' . $_FILES['photo']['type'] . ';base64,';

            $photo = $mime . $base64;

            $product = Product::createProduct($request, $photo);

            return $this->asJson([
                'error' => false,
                'msg' => 'Produto cadastrado!',
                'data' => $product,
            ]);
        } catch (Exception $error) {
            return $this->asJson([
                'error' => true,
                'msg' => $error->getMessage(),
                'line' => $error->getLine(),
                'file' => $error->getFile(),
            ]);
        }
    }
}
