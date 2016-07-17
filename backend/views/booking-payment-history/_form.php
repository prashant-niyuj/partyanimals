<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\BookingPaymentHistory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="booking-payment-history-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'booking_id')->textInput() ?>

    <?= $form->field($model, 'payment_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'payment_transaction_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'raw_request')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'response')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'payment_status')->dropDownList([ 'Pending' => 'Pending', 'Success' => 'Success', 'Cancelled' => 'Cancelled', 'Failed' => 'Failed', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'customer_ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
