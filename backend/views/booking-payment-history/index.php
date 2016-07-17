<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BookingPaymentHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Booking Payment Histories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="booking-payment-history-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Booking Payment History', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'booking_id',
            'payment_type',
            'amount',
            'payment_transaction_id',
            // 'raw_request',
            // 'response:ntext',
            // 'payment_status',
            // 'customer_ip',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
