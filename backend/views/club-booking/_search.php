<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ClubBookingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="club-booking-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'pa_pnr') ?>

    <?= $form->field($model, 'club_id') ?>

    <?= $form->field($model, 'booked_type') ?>

    <?= $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'price_of_girl') ?>

    <?php // echo $form->field($model, 'price_of_stage') ?>

    <?php // echo $form->field($model, 'price_of_couple') ?>

    <?php // echo $form->field($model, 'booking_category') ?>

    <?php // echo $form->field($model, 'no_of_girls') ?>

    <?php // echo $form->field($model, 'no_of_boys') ?>

    <?php // echo $form->field($model, 'tax_rate') ?>

    <?php // echo $form->field($model, 'commission_rate') ?>

    <?php // echo $form->field($model, 'commission') ?>

    <?php // echo $form->field($model, 'convenience_fee') ?>

    <?php // echo $form->field($model, 'total_price') ?>

    <?php // echo $form->field($model, 'booking_date') ?>

    <?php // echo $form->field($model, 'in_confirm') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
