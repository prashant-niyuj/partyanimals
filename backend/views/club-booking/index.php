<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ClubBookingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Club Bookings';
$this->params['breadcrumbs'][] = $this->title;

$userinfo=  Yii::$app->user->identity;
?>
<div class="club-booking-index">

  
<?php if($userinfo['role_id']==1){?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'pa_pnr',
            'clubName',
            //'booked_type',
            'bookedName',
            // 'price_of_girl',
            // 'price_of_stage',
            // 'price_of_couple',
            // 'booking_category',
            // 'no_of_girls',
            // 'no_of_boys',
            // 'tax_rate',
            // 'commission_rate',
            // 'commission',
            // 'convenience_fee',
          //   'total_price',
             [
            'attribute' =>   'booking_date',
             'format' =>  ['date', 'php:Y-m-d'],
             'filter' => DatePicker::widget([
                'model'      => $searchModel,
                'attribute'  =>   'booking_date',
                'dateFormat' => 'php:Y-m-d',
                'options' => [
                    'class' => 'form-control'
                ]
            ]),
            ],
            // 'created_at',
            // 'updated_at',

             ['class' => 'yii\grid\ActionColumn',
                                    'template' => '{view}',
                                    ],
        ],
    ]); ?>
<?php }else if($userinfo['role_id']==5){?>
<p>
        <?= Html::a('Booking', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
  <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

          //  'id',
            'pa_pnr',
            //'clubName',
            //'booked_type',
            'bookedName',
            // 'price_of_girl',
            // 'price_of_stage',
            // 'price_of_couple',
            // 'booking_category',
            // 'no_of_girls',
            // 'no_of_boys',
            // 'tax_rate',
            // 'commission_rate',
            // 'commission',
            // 'convenience_fee',
          //   'total_price',
             [
            'attribute' =>   'booking_date',
             'format' =>  ['date', 'php:Y-m-d'],
             'filter' => DatePicker::widget([
                'model'      => $searchModel,
                'attribute'  =>   'booking_date',
                'dateFormat' => 'php:Y-m-d',
                'options' => [
                    'class' => 'form-control'
                ]
            ]),
            ],
          
            // 'created_at',
            // 'updated_at',

             ['class' => 'yii\grid\ActionColumn',
                                    'template' => '{view}',
                                    ],
        ],
    ]); ?><?php } else{ ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'pa_pnr',
            'clubName',
            //'booked_type',
            'bookedName',
            // 'price_of_girl',
            // 'price_of_stage',
            // 'price_of_couple',
            // 'booking_category',
            // 'no_of_girls',
            // 'no_of_boys',
            // 'tax_rate',
            // 'commission_rate',
            // 'commission',
            // 'convenience_fee',
          //   'total_price',
             [
            'attribute' =>   'booking_date',
             'format' =>  ['date', 'php:Y-m-d'],
             'filter' => DatePicker::widget([
                'model'      => $searchModel,
                'attribute'  =>   'booking_date',
                'dateFormat' => 'php:Y-m-d',
                'options' => [
                    'class' => 'form-control'
                ]
            ]),
            ],
          
            // 'created_at',
            // 'updated_at',

             ['class' => 'yii\grid\ActionColumn',
                                    'template' => '{view}',
                                    ],
        ],
    ]); } ?>
</div>
