<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BookingRateAsdateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Booking Rate Asdates';
$this->params['breadcrumbs'][] = $this->title;
$userinfo=  Yii::$app->user->identity;
?>
<div class="booking-rate-asdate-index">

  
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Booking Rate Asdate', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php if($userinfo['role_id']==2){?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
          //  'clubName',
            'girl_rate',
            'boy_rate',
            'couple_rate',
             [
            'attribute' => 'rate_date',
              'format' =>  ['date', 'php:Y-m-d'],
            ],
           
            // 'create_at',
            // 'updated_at',

             ['class' => 'yii\grid\ActionColumn',
                                    'template' => '{update}{delete}',
                                    ],
        ],
    ]); ?>
<?php }else{?> <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'clubName',
            'girl_rate',
            'boy_rate',
            'couple_rate',
             [
            'attribute' => 'rate_date',
            'format' =>  ['date', 'php:Y-m-d'],
            ],
           
            // 'create_at',
            // 'updated_at',

             ['class' => 'yii\grid\ActionColumn',
                                    'template' => '{update}{delete}',
                                    ],
        ],
    ]); ?><?php }?>
</div>
