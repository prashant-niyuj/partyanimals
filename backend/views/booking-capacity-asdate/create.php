<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\BookingCapacityAsdate */

$this->title = 'set booking capacity';
$this->params['breadcrumbs'][] = ['label' => 'Booking Capacity Asdates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="booking-capacity-asdate-create">

   
    <?= $this->render('_form', [
        'model' => $model,        
        'param'=>$param
    ]) ?>

</div>
