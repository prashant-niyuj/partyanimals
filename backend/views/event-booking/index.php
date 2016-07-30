<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EventBookingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Event Bookings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-booking-index">

    <h1><?php // Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Create Event Booking', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'name',
            'email:email',
            'mobile',
           // 'no_ticket',
           // 'total_amount',
            'pnr',
            // 'ip',
            // 'is_confrm',
              ['class' => '\yii\grid\DataColumn',
                                    'attribute' => 'is_confrm',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                     $isconfrm=$model->is_confrm ? "Yes" : "No";
                                         if($isconfrm=="Yes")
                                          {
                                        return "<div style=color:green>".$isconfrm."</div>";
                                          }
                                          else
                                          {
                                        return "<div style=color:red>".$isconfrm."</div>";
                                          }
                                    },
                                   
                                    'filter' => array("1" => "Yes", "0" => "No"),
             ],
            // 'payment_id',
            // 'payment_responce',
            // 'created_date',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
        ],
    ]); ?>

</div>
