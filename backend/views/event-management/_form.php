<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\web\View;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model backend\models\EventManagement */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="event-management-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'club_id')->dropDownList($param['clubArray'],['prompt' => '-Choose a Club-']); ?>

    <?= $form->field($model, 'event_name')->textInput(['maxlength' => 250]) ?>

    <?= $form->field($model, 'event_description')->textInput(['maxlength' => 5000]) ?>

    <?= $form->field($model, 'event_date')->widget(\yii\jui\DatePicker::classname(), [
    //'language' => 'ru',
    'dateFormat' => 'yyyy-MM-dd',
    'options'=>['readonly'=>'readonly','class'=>'form-control'],
    'clientOptions'=>['minDate'=>0],
 
    
])  ?>     

   
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
