<?php

namespace app\models;

use yii\base\Model;

class TransferForm extends Model
{
    public $from_user;
    public $to_user;
    public $money;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['money', 'required'],
        ];
    }
}