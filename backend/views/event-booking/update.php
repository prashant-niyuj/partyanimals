<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\EventBooking */

$this->title = 'Update Event Booking: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Event Bookings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="event-booking-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
