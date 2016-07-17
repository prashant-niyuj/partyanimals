<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\BookingPaymentHistory */

$this->title = 'Create Booking Payment History';
$this->params['breadcrumbs'][] = ['label' => 'Booking Payment Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="booking-payment-history-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
