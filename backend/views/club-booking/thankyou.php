<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

$this->title = 'Confirm';
$this->params ['breadcrumbs'] [] = $this->title;
?>
<div class="container">
	<div class="row" style="background-color:#fff;padding:10px">
    <h3>Thank you </h3>
	<div style="padding:10px">
		<p>Your booking has been completed Successfully.</p>
		<p>Your PNR-NUMBER is <b><?php if(isset($param['pnr'])) echo $param['pnr']; ?></b></p>
                <p>Your Booking Date is <b><?php if(isset($param['booking_date'])) echo $param['booking_date']; ?></b></p>
                <p>Your Club Name is <b><?php if(isset($param['club_name'])) echo $param['club_name']; ?></b></p>
                 <p>Your Booking type is <b><?php if(isset($param['booking_type'])) echo $param['booking_type']; ?></b></p> 
                 <p>We will send booking details on :<?php echo $param['email']." and mobile no:".$param['mobile_no']?> </p>
		<p>For any query you can send mail @ info@partyanimals.in</p>
	</div>
</div>
</div>