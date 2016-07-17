<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

$this->title = 'Contact Us';
$this->params ['breadcrumbs'] [] = $this->title;
?>
<div class="partyanimals">
    <h2>Contact Us</h2>
    <p class="text-center">Your feedback and suggestions will help us make your party experience better.</p>

    <form class="PAforms">
    	<div class="row">
    		<div class="col-md-6"><input type="text" class="form-control" placeholder="Name"></div>
    		<div class="col-md-6"><input type="text" class="form-control" placeholder="Email"></div>
    	</div>

    	<div class="row">
    		<div class="col-md-6"><input type="text" class="form-control" placeholder="Mobile No."></div>
    		<div class="col-md-6"><input type="text" class="form-control" placeholder="Subject"></div>
    	</div>

    	<div class="row">
    		<div class="col-md-12"><textarea class="form-control" placeholder="Message"></textarea></div>
    	</div>

    	<div class="row">
    		<div class="col-md-12 text-right">
    			<input type="button" value="Send">
    			<input type="button" value="Clear">
    		</div>
    	</div>
    </form>

    <div>
    	<p class="text-center" style="margin-top: 20px;">Or get in touch with us - <a href="mailto:support@partyanimals.in">support@partyanimals.in</a> </p>
    </div>

</div>
<?php

$this->registerJs('$("document").ready(function(){ 
 	$(".navbar-toggle").click(function(e) {
		 $("#wrapper").toggleClass("toggled");
    });
		
});');

?>