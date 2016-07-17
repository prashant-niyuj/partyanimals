<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\models\Club */
/* @var $form yii\widgets\ActiveForm */
$isActiveArray = array("1" => "Active", "0" => "InActive");
$weekdays=['0' => 'Sunday', '1' => 'Monday', '2' => 'Tuesday', '3' => 'Wednesday', '4' => 'Thursday', '5' => 'Friday', '6' => 'Saturday'];
$closeday=array();
//var_dump($model->club_open_days);die;
if($model->club_open_days!=""){
     
       $closeday=  explode(",",$model->club_open_days); 
 }
?>

<div class="club-form">
<div class="row">
        <div class="form-group">
          
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <div class="col-lg-6">   
    <?= $form->field($model, 'name')->textInput(['maxlength' => 100]) ?>
 </div>
            <div class="col-lg-6">
    <?= $form->field($model, 'address')->textarea(['maxlength' => 250]) ?>
 </div>
            <div class="col-lg-6">
    <?= $form->field($model, 'club_capacity')->textInput() ?>
 </div>
            <div class="col-lg-6">
    <?= $form->field($model, 'booking_capacity')->textInput() ?>
</div>        
            <div class="col-lg-6">
    <?= $form->field($model, 'area')->textInput(['maxlength' => 100]) ?>
</div>
            <div class="col-lg-6">
    <?= $form->field($model, 'city_id')->dropDownList($cityArray,['prompt'=>"Select city"]) ?>
</div>
            <div class="col-lg-6">
    <?= $form->field($model, 'priority_range')->textInput() ?>
</div>
            <div class="col-lg-6">
    <?= $form->field($model, 'booking_rate_ladies')->textInput() ?>
</div>
            <div class="col-lg-6">
    <?= $form->field($model, 'booking_rate_boy')->textInput() ?>
</div>
            <div class="col-lg-6">
    <?= $form->field($model, 'booking_rate_couple')->textInput() ?>
</div> <div class="col-lg-6">
    <label>Club Close On</label>
      <?= 
           Html::dropDownList('club_open_days', $selection = $closeday, $weekdays, [
				'class' => 'form-control',
				'style' => '',
				'id' => 'club-club_open_days',
				'multiple' => true]);
			?>            
 <!--   <?= $form->field($model, 'club_open_days[]')->dropDownList($weekdays, ['multiple'=>"multiple"]) ?>-->
</div>
            <div class="col-lg-6">
    <?= $form->field($model, 'tax_rate')->textInput() ?>
</div>
            <div class="col-lg-6">
    <?= $form->field($model, 'commission')->dropDownList(["None"=>"None","Fixed"=>"Fixed","Percentage"=>"Percentage"])?>
</div>
            <div class="col-lg-6">
    <?= $form->field($model, 'commission_for_girl')->textInput() ?>
 </div>
            <div class="col-lg-6">
    <?= $form->field($model, 'commission_for_stage')->textInput() ?>
 </div>
            <div class="col-lg-6">
    <?= $form->field($model, 'commission_for_couple')->textInput() ?>
 </div>
     
             <div class="col-lg-6">
    <?= $form->field($model, 'bank_account_holder_name')->textInput()?>
</div> 
            
            <div class="col-lg-6">
    <?= $form->field($model, 'bank_name')->textInput() ?>
 </div>
            <div class="col-lg-6">
    <?= $form->field($model, 'bank_account_number')->textInput() ?>
 </div>
            <div class="col-lg-6">
    <?= $form->field($model, 'bank_branch')->textInput() ?>
 </div>
            <div class="col-lg-6">
    <?= $form->field($model, 'ifsc_code')->textInput()->label("IFSC Code") ?>
 </div>
             <div class="col-lg-6">
    <?= $form->field($model, 'MICR')->textInput()->label("MICR") ?>
 </div>
             <div class="col-lg-6">
    <?= $form->field($model, 'swift_code')->textInput() ?>
 </div>
              <div class="col-lg-6">
    <?= $form->field($model, 'convenience_fee')->textInput() ?>
 </div>
            
  
            <div class="col-lg-6">
    <?= $form->field($model, 'is_active')->dropDownList($isActiveArray) ?>
    </div>
	    <div class="col-lg-6">
    <?= $form->field($model, 'logo')->fileInput()->label("Logo"); ?>
 </div> 
            <?php if(!$model->isNewRecord){?>
    <div class="col-lg-6">
        <image src="<?php echo Yii::$app->request->BaseUrl?>/uploads/clublogo/resize/<?php echo $model->logo;?>" alt="Club Logo">
 </div>
            <?php }?>
      </div>
</div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs('$("document").ready(function(){ '.
         ' $("#club-club_open_days").multipleSelect({ filter: true });'
        . '});');

 
?>