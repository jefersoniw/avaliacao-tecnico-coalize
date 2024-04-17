<?php

use yii\db\Migration;

/**
 * Class m240415_000611_client
 */
class m240415_000611_client extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('clients', [
            'id' => $this->primaryKey(),
            'name' => $this->string(60)->notNull(),
            'cpf' => $this->string(11)->notNull(),
            'address_text' => $this->text()->notNull(),
            'photo' => 'LONGTEXT',
            'sex' => $this->char('1')->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('clients');
    }
}
