<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ClubBooking */

$this->title = 'Create Club Booking';
$this->params['breadcrumbs'][] = ['label' => 'Club Bookings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="club-booking-create">

  
    <?= $this->render('_form', [
        'model' => $model,
        'bookingnameModelObj'=>$bookingnameModelObj,
        'paymentModelObj'=>$paymentModelObj
            
    ]) ?>

</div>
