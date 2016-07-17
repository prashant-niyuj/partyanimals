<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

$this->title = 'How It Works';
$this->params ['breadcrumbs'] [] = $this->title;
?>
<div class="partyanimals">
    <h2>How It Works</h2>
    <div class="row">
    	<div class="col-md-4 text-center" style="margin-bottom: 15px;"><img class="howitwork" src="images/screen-1.png" /></div>
    	<div class="col-md-4 text-center" style="margin-bottom: 15px;"><img class="howitwork" src="images/screen-2.png" /></div>
    	<div class="col-md-4 text-center" style="margin-bottom: 15px;"><img class="howitwork" src="images/screen-3.png" /></div>
    </div>
</div>
<br>
<br>
<?php

$this->registerJs('$("document").ready(function(){ 
 	$(".navbar-toggle").click(function(e) {
		 $("#wrapper").toggleClass("toggled");
    });
		
});');

?>