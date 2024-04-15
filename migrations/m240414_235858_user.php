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
            'name' => $this->string(60)->notNull(),
            'email' => $this->string(60)->notNull(),
            'password' => $this->string(10)->notNull(),
            'date_created' => $this->dateTime()->notNull()
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
