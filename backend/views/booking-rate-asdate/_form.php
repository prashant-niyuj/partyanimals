<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


use yii\jui\DatePicker;
use yii\web\View;
use yii\widgets\Pjax;

$userinfo=  Yii::$app->user->identity;

/* @var $this yii\web\View */
/* @var $model backend\models\BookingRateAsdate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="booking-rate-asdate-form">

    <?php $form = ActiveForm::begin(); ?>

     <?= $form->field($model, 'rate_date')->widget(\yii\jui\DatePicker::classname(), [
    //'language' => 'ru',
    'dateFormat' => 'yyyy-MM-dd',
    'options'=>['readonly'=>'readonly','class'=>'form-control'],
    'clientOptions'=>['minDate'=>0,'maxDate'=>"+6D"],
 
    
])  ?>  
    <?php if($userinfo['role_id']==2) {?>
    
    <?= $form->field($model, 'club_id')->dropDownList($param['clubArray']); ?>
    <?php }else{?><?= $form->field($model, 'club_id')->dropDownList($param['clubArray'],['prompt' => '-Choose a Club-']); ?><?php }?>
    <?= $form->field($model, 'girl_rate')->textInput() ?>

    <?= $form->field($model, 'boy_rate')->textInput() ?>

    <?= $form->field($model, 'couple_rate')->textInput() ?>

     
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
