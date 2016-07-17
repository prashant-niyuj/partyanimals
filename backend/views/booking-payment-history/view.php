<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\BookingPaymentHistory */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Booking Payment Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="booking-payment-history-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'booking_id',
            'payment_type',
            'amount',
            'payment_transaction_id',
            'raw_request',
            'response:ntext',
            'payment_status',
            'customer_ip',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
