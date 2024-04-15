<?php

use yii\db\Migration;

/**
 * Class m240415_001203_product
 */
class m240415_001203_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('products', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'price' => $this->decimal(10,2)->notNull(),
            'client_id' => $this->integer()->notNull(),
            'photo' => $this->string()->notNull()
        ]);

        $this->addForeignKey('fk_products_client', 'products', 'client_id', 'clients', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('products');
    }
}
