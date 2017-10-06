<?php

use yii\db\Migration;

/**
 * Handles the creation of table `money_transfer`.
 */
class m171003_144644_create_money_transfer_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('money_transfer', [
            'id' => $this->primaryKey(),
            'from_user' => $this->integer(11),
            'to_user' => $this->integer(11),
            'money' => $this->float(2),
        ]);
        $this->addForeignKey('from_user_id', 'money_transfer', 'from_user', 'user', 'id');
        $this->addForeignKey('to_user_id', 'money_transfer', 'to_user', 'user', 'id');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('money_transfer');
    }
}
