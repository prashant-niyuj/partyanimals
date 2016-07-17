<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BookingCapacityAsdate */

$this->title = 'Update Booking Capacity Asdate: ' . ' ' . $model->club->name;
$this->params['breadcrumbs'][] = ['label' => 'Booking Capacity Asdates', 'url' => ['index']];

$this->params['breadcrumbs'][] = 'Update';
?>
<div class="booking-capacity-asdate-update">

   

    <?= $this->render('_form', [
        'model' => $model,        
        'param'=>$param
    ]) ?>

</div>
