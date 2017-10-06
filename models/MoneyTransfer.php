<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "money_transfer".
 *
 * @property integer $id
 * @property integer $from_user
 * @property integer $to_user
 * @property double $money
 */
class MoneyTransfer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'money_transfer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_user', 'to_user'], 'integer'],
            [['money'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_user' => 'From User',
            'to_user' => 'To User',
            'money' => 'Money',
        ];
    }
}
