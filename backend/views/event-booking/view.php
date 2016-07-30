<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\EventBooking */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Event Bookings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-booking-view">

    <h1><?php // Html::encode($this->title) ?></h1>

    <p>
        <?php Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'name',
            'email:email',
            'mobile',
            'no_ticket',
            'total_amount',
            'pnr',
           // 'ip',
            'is_confrm',
            'payment_id',
            //'payment_responce',
            'created_date',
        ],
    ]) ?>

</div>
