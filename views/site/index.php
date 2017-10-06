<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <?php foreach ($models as $model): ?>
        <b>Username: </b> <?= $model['username'] ?> <b>Balance:</b> <?= $model['balance'] ?> <br>
    <?php endforeach; ?>

</div>
