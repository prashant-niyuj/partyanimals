<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

$this->title = 'Booking Details';
$this->params ['breadcrumbs'] [] = $this->title;
?>
<div class="container">
	<div class="row" style="color:#fff;padding:10px">
    <?php if($is_error == 'sys') { ?>
    <h3>opps Sorry Somethink wrong</h3>
	<div style="padding:10px">
	<p>For any query you can send mail @ <a href='mailto:support@partyanimals.in'> support@partyanimals.in</a></p>
	</div>
    <?php } ?>

    <?php if($is_error == 'fail') { ?>
    <h3>opps Sorry Somethink wrong</h3>
	<div style="padding:10px">
		<p>Please try again.</p>
		<p>For any query you can send mail @ <a href='mailto:support@partyanimals.in'> support@partyanimals.in</a></p>
	</p>
	</div>
    <?php } ?>

    <?php if($is_error == 'cancel') { ?>
    <h3>Let Us know what went wrong ?</h3>
	<div style="padding:10px">
	<p>We have noticed that you made and attempt for booking, but cancelled at last movement.<br>
	Fill free to update us regarding  any of your quires and suggestions to help us to improve the user experience.<br>
	We will be glad to here from you.
	</p>
	<p>For any query you can send mail @ <a href='mailto:support@partyanimals.in'> support@partyanimals.in</a></p>
	</div>

    <?php } ?> 

    <?php if($is_error == 'sucess') { ?>
    <h3>Thank you </h3>
	<div style="padding:10px">
		<p>Your booking has been completed Successfully.</p>
			<p>Your PNR-NUMBER is <b><?php if(isset($param['pnr'])) echo $param['pnr']; ?></b></p>
                <p>Your Booking Date is <b><?php if(isset($param['booking_date'])) echo $param['booking_date']; ?></b></p>
                <p>Your Club Name is <b><?php if(isset($param['club_name'])) echo $param['club_name']; ?></b></p>
                <p>Your Booking type is <b><?php if(isset($param['booking_type'])) echo $param['booking_type']; ?></b></p> 
                <p>For any query you can send mail @ <a href='mailto:support@partyanimals.in'> support@partyanimals.in</a></p>
	</div>
	<?php } ?>
	</div>
</div>
<?php

$this->registerJs('$("document").ready(function(){ 
 	$(".navbar-toggle").click(function(e) {
		 $("#wrapper").toggleClass("toggled");
    });
		
});');

?>