<?php
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

$this->title = 'About Us';
$this->params ['breadcrumbs'] [] = $this->title;
?>
<div class="partyanimals">
    <h2>About Us</h2>
	<div>
		<p>Let’s get back in December 2015 when our founder’s birthday

turned to a sad party just because they could not manage to

enter a club despite of being on the guest list and their pockets

being full. Well things needed to be changed and they came up

with the idea of making their and everyone’s party experiences

better, hence partyanimals.in was born.
		</p>
		<p>So what is partyanimals.in? </p>
		<p>Partyanimals.in is a service providing ballot of clubs and bars in

the town giving you the opportunity of being on the guest list

and letting you walk through the long queue. It was inspired by

the idea of making your clubbing experience a lot easier by

putting you on the guest list of your favourite club in Real-Time.

Partyanimals.in is the ride to the Den for the party animal inside

you and our objective is to make this ride as smooth as your

drinks.</p>
<p>So now clubbing is just a tap away! </p>
	</div>
</div>
<?php

	$this->registerJs('$("document").ready(function(){ 
 	$(".navbar-toggle").click(function(e) {
		 $("#wrapper").toggleClass("toggled");
    });
		
});');

?>