<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BookingCapacityAsdateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Set Booking Capacity Per Date';
$this->params['breadcrumbs'][] = $this->title;
$userinfo=Yii::$app->user->identity;
if($userinfo['role_id']==2)
{
    $this->title = $clubName->name.' - Set Booking Capacity For Date';
}
?>
<div class="booking-capacity-asdate-index">

  
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Booking Capacity Asdate', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php if($userinfo['role_id']==1)
{?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

          //  'id',
           'clubName',
            'booking_capacity',
          
              [
            'attribute' => 'capacity_active_date',
             'format' =>  ['date', 'php:Y-m-d'],
             'filter' => DatePicker::widget([
              'model'      => $searchModel,
                'attribute'  =>   'capacity_active_date',
                'dateFormat' => 'php:Y-m-d',
                'options' => [
                    'class' => 'form-control'
                ]
            ]),
            ],
          /*          [
            'attribute' =>  'created_at',
            'filter' => DatePicker::widget([
                'model'      => $searchModel,
                'attribute'  =>  'created_at',
                'dateFormat' => 'php:Y-m-d',
                'options' => [
                    'class' => 'form-control'
                ]
            ]),
            ],*/
            
           
            // 'updated_at',

             ['class' => 'yii\grid\ActionColumn',
                                    'template' => '{update}{delete}',
                                    ],
        ],
    ]); ?>
<?php }else{?>  <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

          //  'id',
          // 'clubName',
            'booking_capacity',
               [
            'attribute' => 'capacity_active_date',
             'format' =>  ['date', 'php:Y-m-d'],
             'filter' => DatePicker::widget([
              'model'      => $searchModel,
                'attribute'  =>   'capacity_active_date',
                'dateFormat' => 'php:Y-m-d',
                'options' => [
                    'class' => 'form-control'
                ]
            ]),
            ],
          /*          [
            'attribute' =>  'created_at',
            'filter' => DatePicker::widget([
                'model'      => $searchModel,
                'attribute'  =>  'created_at',
                'dateFormat' => 'php:Y-m-d',
                'options' => [
                    'class' => 'form-control'
                ]
            ]),
            ],*/
            
           
            // 'updated_at',

   ['class' => 'yii\grid\ActionColumn',
                                    'template' => '{update}{delete}',
                                    ],
        ],
    ]); ?><?php }?>
</div>
