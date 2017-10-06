<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div>

    <b>Your balance:</b> <?= $modelUser->balance ?> <br>

</div>

<div>
    <b>Make money transfer</b>

    <?php $form = ActiveForm::begin([
        'action' => '/cabinet/user/transfer',
    ]); ?>

    <?= $form->field($transfer, 'to_user')->textInput() ?>

    <?= $form->field($transfer, 'money')->textInput() ?>

    <div class="form-group">

        <?= Html::submitButton('Transfer', ['class' => 'btn btn-success btn-primary', 'name' => 'transfer']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>

<div>
    <?php foreach ($modelTransfer as $modelT): ?>

        Username: <?= ArrayHelper::getValue(\app\models\User::find()->where(['id' => $modelT['id']])->asArray()->one(), 'username'); ?>
        Balance: <?= $modelT['money'] ?>
        <br>
    <?php endforeach; ?>
</div>