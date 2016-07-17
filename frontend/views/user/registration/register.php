<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View              $this
 * @var yii\widgets\ActiveForm    $form
 * @var dektrium\user\models\User $user
 */

$this->title = Yii::t('user', 'Sign up');
$this->params['breadcrumbs'][] = $this->title;
//var_dump(Yii::$app);die;
$frombooking=  Yii::$app->request->get('formbooking');
$showsignasguest=0;
if(isset($frombooking))
{
    if($frombooking==1)
    {
        $showsignasguest=1;
    }
}
if(isset($_COOKIE['booking_data']))
	$arr_data = json_decode($_COOKIE['booking_data'], true);

?>
<?php if($showsignasguest==1){?>
<div class="container">

<div class="row" style="color:#fff;padding:10px">
    <div class="row">
                <div class="col-md-6">

   
	
	<h3 class="panel-title">Pay as Guest</h3>
            
		<form class="form-horizontal" method="post" id="guest_signup" action="index.php?r=booking/processbookingasguest">
			<fieldset>
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
                 <h3 class="panel-title">Sign Up</h3>
	 <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id'                     => 'registration-form',
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false
                ]); ?>
                <?= $form->field($model, 'name') ?>
                <?= $form->field($model, 'username') ?>               
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'phone_no') ?>
                <?php if ($module->enableGeneratingPassword == false): ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                 <?php endif ?>
                 <input id="register-form-role_id" class="form-control" name="register-form[role_id]" value="4" type="hidden">
                <p class="text-center">
                <?= Html::submitButton(Yii::t('user', 'Sign up'), ['class' => 'btn btn-primary']) ?>
                </p>
                <?php ActiveForm::end(); ?>
           
       </div>
        <p class="text-center">
            <?= Html::a(Yii::t('user', 'Already registered? Sign in!'), ['/user/security/login','formbooking'=>1]) ?>
        </p>
        
         </div>
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
                    'id'                     => 'registration-form',
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false
                ]); ?>

               <?= $form->field($model, 'name') ?>
                <?= $form->field($model, 'username') ?>               
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'phone_no') ?>


                <?php if ($module->enableGeneratingPassword == false): ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                <?php  endif ?>              

                <input id="register-form-role_id" class="form-control" name="register-form[role_id]" value="4" type="hidden">

             
                <?= Html::submitButton(Yii::t('user', 'Sign up'), ['class' => 'btn btn-success btn-block']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <p class="text-center">
            <?= Html::a(Yii::t('user', 'Already registered? Sign in!'), ['/user/security/login']) ?>
        </p>
    </div>
</div>
</div>
<?php }?>