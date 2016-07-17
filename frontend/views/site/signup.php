<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'Party Animals : Signup';
$this->params['breadcrumbs'][] = $this->title;

if(isset($_COOKIE['booking_data']))
	$arr_data = json_decode($_COOKIE['booking_data'], true);
?>
<style>
fieldset {
	width:90%;
}
</style>
<div class="site-signup">
    <div class="row" style="background-color:#fff;">
	<div class="col-xs-6">
	<h3>Pay as Guest</h3>
            
		<form class="" method="post" id="guest_signup" action="index.php?r=booking/processbookingasguest">
			<fieldset>
			<input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />	
			<div class="form-group">
				<label for="signupform-username" class="control-label">Name</label>
				<input id="name" name="name" type="text" placeholder="Enter your Name" class="form-control" >
			</div>
			<div class="form-group">
				<label for="signupform-username" class="control-label">Email</label>
				<input id="email" name="email" type="text" placeholder="Enter your Email" class="form-control" >
			</div>
			<div class="form-group">
				<label for="signupform-username" class="control-label">Mobile No</label>
				<input id="phone" name="phone"  maxlength="10" type="text" placeholder="Enter your Mobile number" class="form-control" >
			</div>	
			<div class="col-md-12 text-right">
				<button type="submit" class="btn btn-primary" id="btn_book_continue">Continue</button>
			</div>
			</fieldset>
		</form>

        </div>        
	<div class="col-xs-6">
		<h3><?= Html::encode('Sign In') ?></h3>
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <fieldset>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
                </fieldset>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php

$this->registerJs('$("document").ready(function(){ 
 	$("#guest_signup")
    .bootstrapValidator({
        message: "This value is not valid",
        fields: {
            name: {
                validators: {
                   notEmpty: {
                        message: "The full name is required"
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: "The full name must be more than 6 and less than 30 characters long"
                    },
                    regexp: {
                        regexp: /^[a-zA-Z\s]+$/,
                        message: "The full name can only consist of alphabetical and spaces"
                    }
                }
            },
			email: {
                validators: {
                    notEmpty: {
                        message: "The email address is required"
                    },
                    emailAddress: {
                        message: "The input is not a valid email address"
                    }
                }
            },
            phone: {
                validators: {
					notEmpty: {
						message: "The mobile phone number is required"
					},
					digits: {
						message: "The mobile phone number is not valid"
					},
					stringLength: {
                        min: 10,
                        message: "The mobile number must be 10 number"
                    }
					
                }
            }
        }
    })
    .on("success.form.bv", function(e) {
        // Prevent form submission
        e.preventDefault();

        // Get the form instance
        var $form = $(e.target);

        // Get the BootstrapValidator instance
        var bv = $form.data("bootstrapValidator");
        var fields = $form.serializeArray();
        console.log(fields);
        
         jQuery.each( fields, function( i, field ) {
        	 saveintoCookie(field.name,field.value);
         });
        
        
        // Use Ajax to submit form data
        $.post($form.attr("action"), $form.serialize(), function(result) {
            //console.log(result);
            window.location.assign("index.php?r=site/confirm");
        }, "json");
    });
	
	
});');

?>