<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\BookingRateAsdateSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="booking-rate-asdate-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'club_id') ?>

    <?= $form->field($model, 'girl_rate') ?>

    <?= $form->field($model, 'boy_rate') ?>

    <?= $form->field($model, 'couple_rate') ?>

    <?php // echo $form->field($model, 'rate_date') ?>

    <?php // echo $form->field($model, 'create_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
