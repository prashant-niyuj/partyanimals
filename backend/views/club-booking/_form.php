<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\ClubBooking */
/* @var $form yii\widgets\ActiveForm */

$getrate= \Yii::$app->urlManager->createUrl(['club-booking/getratebydate']);

if($model->isNewRecord)
{
    $model->booking_date=date("d-m-Y");
}
?>

<div class="club-booking-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-6">
            <?=
            $form->field($model, 'booking_date')->widget(DatePicker::classname(), [
                // 'type' => DatePicker::TYPE_COMPONENT_APPEND,
                "dateFormat" => 'dd-MM-yyyy'
            ])
            ?>
        </div><div class="col-lg-6">
<?= $form->field($model, 'booking_category')->dropDownList([ 'Girl' => 'Girl', 'Boy' => 'Boy', 'Couple' => 'Couple', 'Group' => 'Group',], ['prompt' => '','onChange'=>"getGroups(this.value)"]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'price_of_girl')->textInput(['readonly' => "readonly"]) ?>
        </div><div class="col-lg-4">
            <?= $form->field($model, 'price_of_stage')->textInput(['readonly' => "readonly"]) ?>
        </div><div class="col-lg-4">
<?= $form->field($model, 'price_of_couple')->textInput(['readonly' => "readonly"]) ?>
        </div>
    </div>    
    
    <div class="row" id="noofgirlsboys"> <div class="col-lg-6">
            <?= $form->field($model, 'no_of_girls')->textInput() ?>
        </div><div class="col-lg-6">
            <?= $form->field($model, 'no_of_boys')->textInput() ?>
        </div></div>
    
    <div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'confirm' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs('$("document").ready(function(){ '
        . '$("#noofgirlsboys").hide();}); '
        . 'setprice("'.$getrate.'","'.$model->club_id.'");'
        . ' $("#clubbooking-booking_date").on("change",function(){'
        . 'setprice("'.$getrate.'","'.$model->club_id.'");'
        . '})');

?>
<script>
    
    
    function setprice(url,club_id)
    {
           
        $.ajax({
            type: 'GET',
            cache: false,
            data: {'c_id': club_id,'currdate': $("#clubbooking-booking_date").val()},
            url: url,
            success: function(response) {             
               var price=response.split("##");              
               $("#clubbooking-price_of_girl").val(price[1]);
               $("#clubbooking-price_of_stage").val(price[0]);
               $("#clubbooking-price_of_couple").val(price[2]);
               

            }
        });
        
        
    }
    
    function getGroups(booking_type)
    {
        if(booking_type=="Group")
        $("#noofgirlsboys").show();
    else{
        $("#noofgirlsboys").hide();
    }
        
    }
    
        
        
    
    </script>