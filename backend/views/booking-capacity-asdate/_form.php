<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


use yii\jui\DatePicker;
use yii\web\View;
use yii\widgets\Pjax;

$userinfo=  Yii::$app->user->identity;

/* @var $this yii\web\View */
/* @var $model backend\models\BookingCapacityAsdate */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="booking-capacity-asdate-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
                <div class="col-lg-6">
    <?= $form->field($model, 'capacity_active_date')->widget(\yii\jui\DatePicker::classname(), [
    //'language' => 'ru',
    'dateFormat' => 'yyyy-MM-dd',
    'options'=>['readonly'=>'readonly','class'=>'form-control'],
    'clientOptions'=>['minDate'=>0,'maxDate'=>"+6D"],
 
    
])  ?>   
                </div><div class="col-lg-1"></div>


                <div class="col-lg-6">
                    <?php if($userinfo['role_id']==2){?>
    <?= $form->field($model, 'club_id')->dropDownList($param['clubArray']); ?>
                    <?php }else{?> <?= $form->field($model, 'club_id')->dropDownList($param['clubArray'],[ 'prompt' => '-Choose a Club-']); ?><?php }?>
                </div>
</div>
    <div class="row">
                <div class="col-lg-5">
    <?= $form->field($model, 'booking_capacity')->textInput() ?>
                </div>    
  <div class="col-lg-5">
    <?= $form->field($model, 'is_full')->dropDownList(["0"=>"No","1"=>"Yes"]) ?>
                </div>
        </div>      <div class="row">             <div class="col-lg-6">
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>
</div>
    <?php ActiveForm::end(); ?>

</div>
