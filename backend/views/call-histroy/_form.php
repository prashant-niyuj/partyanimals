<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CallHistroy */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="call-histroy-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'self')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'incoming')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
