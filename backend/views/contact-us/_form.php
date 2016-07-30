<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ContactUs */
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
    <h2>Contact Us</h2>
    <p class="text-center">Your feedback and suggestions will help us make your party experience better.</p>


    <?php $form = ActiveForm::begin(["class"=>"PAforms"]); ?>
 <div class="form-group">
    
          <div class="row">
              <div class="col-md-6">
                <?= $form->field($model, 'contact_name')->textInput(['maxlength' => true]) ?>
              </div>
              <div class="col-md-6">        

                <?= $form->field($model, 'contact_email')->textInput(['maxlength' => true]) ?>
              </div>
          </div>
      <div class="row">
              <div class="col-md-6">  
                <?= $form->field($model, 'contact_no')->textInput(['maxlength' => true]) ?>
              </div>
              <div class="col-md-6">        
                    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>
            </div>
       </div>
      <div class="row">
              <div class="col-md-12"> 
    <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>
            </div>
      </div> 
    

    	<div class="row">
        <div class="col-md-12 text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
        </div>
 <div>
    	<p class="text-center" style="margin-top: 20px;">Or get in touch with us - <a href="mailto:support@partyanimals.in">support@partyanimals.in</a> </p>
    </div>
    <?php ActiveForm::end(); ?>

</div>
<?php

$this->registerJs('$("document").ready(function(){ 
 	$(".navbar-toggle").click(function(e) {
		 $("#wrapper").toggleClass("toggled");
    });
		
});');

?>