<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BookingRateAsdate */

$this->title = 'Update Booking Rate Asdate: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Booking Rate Asdates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="booking-rate-asdate-update">

  

    <?= $this->render('_form', [
        'model' => $model,        
        'param'=>$param
    ]) ?>

</div>
