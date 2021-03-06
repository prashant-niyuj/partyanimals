<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dektrium\user\widgets\Connect;

/**
 * @var yii\web\View                   $this
 * @var dektrium\user\models\LoginForm $model
 * @var dektrium\user\Module           $module
 */
$frombooking=  Yii::$app->request->get('formbooking');
$showsignasguest=0;
if(isset($frombooking))
{
    if($frombooking==1)
    {
        $showsignasguest=1;
    }
}

        
$this->title = Yii::t('user', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;
?>


<?php if($showsignasguest==1){?>
<div class="site-signup">
    <div class="row" style="color:#fff;padding-top:10px">
		<div class="col-md-6">
    

	
	<h3 class="panel-title">Pay as Guest</h3>
            
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
    <div class="col-md-6">
                <?php // $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>
				<h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
           

                <?php $form = ActiveForm::begin([
                    'id'                     => 'login-form',
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                    'validateOnBlur'         => false,
                    'validateOnType'         => false,
                    'validateOnChange'       => false,
                ]) ?>

                <?= $form->field($model, 'login', ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1']]) ?>

                <?= $form->field($model, 'password', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2']])->passwordInput()->label(Yii::t('user', 'Password') . ($module->enablePasswordRecovery ? ' (' . Html::a(Yii::t('user', 'Forgot password?'), ['/user/recovery/request'], ['tabindex' => '5']) . ')' : '')) ?>

                <?= $form->field($model, 'rememberMe')->checkbox(['tabindex' => '4']) ?>
                <p class="text-center">
                    <?= Html::submitButton(Yii::t('user', 'Sign in'), ['class' => 'btn btn-primary', 'tabindex' => '3']) ?>
                </p>
                <?php ActiveForm::end(); ?>
           
         </div>
        <?php if ($module->enableConfirmation): ?>
            <p class="text-center">
                <?= Html::a(Yii::t('user', 'Didn\'t receive confirmation message?'), ['/user/registration/resend']) ?>
            </p>
        <?php endif ?>
        <?php if ($module->enableRegistration): ?>
            <p class="text-center">
                <?= Html::a(Yii::t('user', 'Don\'t have an account? Sign up!'), ['/user/registration/register','formbooking'=>1]) ?>
            </p>
        <?php endif ?>
           
    </div>
 </div>
   <?php }else{?>
        
        
   
<div class="partyanimals">
<div class="site-login">
    <h2><?= Html::encode($this->title) ?></h2>

    <p class="text-center">Please fill out the following fields to login:</p>
    <div class="PAforms width30">
    <div class="row">
        <div class="col-md-12">
   
                <?php $form = ActiveForm::begin([
                    'id'                     => 'login-form',
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                    'validateOnBlur'         => false,
                    'validateOnType'         => false,
                    'validateOnChange'       => false,
                ]) ?>

                <?= $form->field($model, 'login', ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1']]) ?>

                <?= $form->field($model, 'password', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2']])->passwordInput()->label(Yii::t('user', 'Password') . ($module->enablePasswordRecovery ? ' (' . Html::a(Yii::t('user', 'Forgot password?'), ['/user/recovery/request'], ['tabindex' => '5']) . ')' : '')) ?>

                <?= $form->field($model, 'rememberMe')->checkbox(['tabindex' => '4']) ?>

                <?= Html::submitButton(Yii::t('user', 'Sign in'), ['class' => 'btn btn-success btn-block']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <?php if ($module->enableConfirmation): ?>
            <p class="text-center">
                <?= Html::a(Yii::t('user', 'Didn\'t receive confirmation message?'), ['/user/registration/resend']) ?>
            </p>
        <?php endif ?>
            <br/>
        <?php if ($module->enableRegistration): ?>
            <div class="col-md-12 text-center">
           
                <?= Html::a(Yii::t('user', 'Don\'t have an account? Sign up!'), ['/user/registration/register']) ?>
            </div>
        <?php endif ?>
        <?= Connect::widget([
            'baseAuthUrl' => ['/user/security/auth']
        ]) ?>
    </div>
</div>
</div>
   <?php }?>
<?php

$this->registerJs('$("document").ready(function(){ 
 	$(".navbar-toggle").click(function(e) {
		e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
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
        
			/*
         jQuery.each( fields, function( i, field ) {
        	 saveintoCookie(field.name,field.value);
         });
        */
        
        // Use Ajax to submit form data
        $.post($form.attr("action"), $form.serialize(), function(result) {
            //console.log(result);
            window.location.assign("index.php?r=site/confirm");
        }, "json");
    });
	
	
});');

?>
