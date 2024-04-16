<?php

use yii\db\Migration;

/**
 * Class m240414_235858_user
 */
class m240414_235858_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'username' => $this->string(60)->notNull(),
            'password' => $this->text()->notNull(),
            'authKey' => $this->text()->notNull(),
            'accessToken' => $this->text()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
