<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ClubBooking */

$this->title = $model->pa_pnr;
$this->params['breadcrumbs'][] = ['label' => 'Club Bookings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="club-booking-view">

    <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_1" data-toggle="tab">Booking Details</a></li>
                  <li><a href="#tab_2" data-toggle="tab">Payment History</a></li>                 
                  
                 
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
               
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'pa_pnr',
            'clubName',
             [
                    'class' => '\yii\grid\DataColumn',
                    'attribute' => 'booked_type',
                    'value' =>$model->booked_type==0?"System User":"Guest User",
                        
                        
                  
                    //  'filterType' => '\yii\widgets\Select2',
                  //  'filter' => $vatTypeArray,
                // 'filterWidgetOptions'=>['1'=>'1','2'=>'2']
            ],
            
            'bookedName',
            'price_of_girl',
            'price_of_stage',
            'price_of_couple',
            'booking_category',
            'no_of_girls',
            'no_of_boys',
            'tax_rate',
            'commission_rate',
            'commission',
            'convenience_fee',
            'total_price',
            'booking_date',
           // 'in_confirm',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
                
        <div class="tab-pane" id="tab_2">
                   <?= DetailView::widget([
        'model' => $paymentModel,
        'attributes' => [
            'id',
            'booking_id',
            'payment_type',
            'amount',
            'payment_transaction_id',
           // 'raw_request',
            //'response:ntext',
            'payment_status',
            'customer_ip',
            'created_at',
            'updated_at',
        ],
    ]) ?>
                  </div><!-- /.tab-pane -->
                  <!-- /.tab-pane -->
                </div><!-- /.tab-content -->
              </div><!-- nav-tabs-custom -->
            </div>
