<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\BookingRateAsdate */

$this->title = 'Create Booking Rate Asdate';
$this->params['breadcrumbs'][] = ['label' => 'Booking Rate Asdates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="booking-rate-asdate-create">

   
    <?= $this->render('_form', [
        'model' => $model,        
        'param'=>$param
    ]) ?>

</div>
