<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\EventBooking */

$this->title = 'Create Event Booking';
$this->params['breadcrumbs'][] = ['label' => 'Event Bookings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-booking-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
