<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\PartnerWithUs */
/* @var $form yii\widgets\ActiveForm */
$flash = Yii::$app->session->getFlash('success');


?>
 <?php
    if(isset($flash) && $flash!="")
    {?>
    <div class="alert-success alert fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        <?php  echo $flash;?>
    </div>
    <?php
    
     Yii::$app->session->removeFlash('success');
    }
    ?>


<div class="partyanimals">
    <h2>Partner With Us</h2>
    <p class="text-center">Club or bar? Fill the form below and we will do the rest.</p>


    <?php $form = ActiveForm::begin(['class'=>"PAforms"]); ?>
<div class="form-group">
    
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'partner_type')->radioList([ 'Club' => 'Club', 'Bar' => 'Bar', ])->label("") ?>
        </div>
        
    </div>
          <div class="row">
              <div class="col-md-6"> 
    <?= $form->field($model, 'contact_name')->textInput(['maxlength' => true]) ?>
</div>
              
              <div class="col-md-6">        

    <?= $form->field($model, 'name_of_venue')->textInput(['maxlength' => true]) ?>
   </div>
          </div>
      <div class="row">
              <div class="col-md-6"> 
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
  </div>
              <div class="col-md-6">  
    <?= $form->field($model, 'contact_no')->textInput(['maxlength' => true]) ?>
  </div>
       </div>
      <div class="row">
            <div class="col-md-12">     
    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
    </div>
      </div>
           <div class="row">
           <div class="col-md-12">  
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
  </div>
              
      </div>
          
    <div class="row">
    		<div class="col-md-12 text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Send' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    </div>

    <?php ActiveForm::end(); ?>
    
    
    <div>
    	<p class="text-center" style="margin-top: 20px;">To know more mail us at - <a href="mailto:corporate@partyanimals.in">corporate@partyanimals.in</a> </p>
    </div>


</div>
