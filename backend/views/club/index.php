<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ClubSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$userinfo=  yii::$app->user->identity;
?>
<div class="club-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php if($userinfo['role_id']==1){
        
     $this->title = 'Manage Clubs';
$this->params['breadcrumbs'][] = $this->title;   
     ?>
    <p>
        <?= Html::a('Create Club', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'name',
            'address',
          //  'club_capacity',
          //  'booking_capacity',
            // 'logo',
             'area',
             'cityName',
            'priority_range',
            // 'booking_rate_ladies',
            // 'booking_rate_boy',
            // 'booking_rate_couple',
            // 'club_open_days',
            // 'bank_name',
            // 'bank_account_number',
            // 'bank_branch',
            // 'ifsc_code',
             [
                                    'class' => '\yii\grid\DataColumn',
                                    'attribute' => 'is_active',
                                    'value' => function ($model) {
                                        //var_dump($model);die;
                                        return $model->is_active ? "Active" : "Inactive";
                                    },
                                    //  'filterType' => '\yii\widgets\Select2',
                                    'filter' => array("1" => "Active", "0" => "InActive"),
                                // 'filterWidgetOptions'=>['1'=>'1','2'=>'2']
                                ],
            // 'created_date',
            // 'modified_date',

            //['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\ActionColumn',
                                    'template' => '{update}',
                                    ],
        ],
    ]); ?>
<?php }else{
    
    $this->title = 'Manager Clubs=>'.$clubName->name;;
$this->params['breadcrumbs'][] = $this->title;   

    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

         //   'id',
          //  'name',
            'address',
            'club_capacity',
            'booking_capacity',
            // 'logo',
            // 'area',
            // 'city_id',
            // 'priority_range',
            // 'booking_rate_ladies',
            // 'booking_rate_boy',
            // 'booking_rate_couple',
            // 'club_open_days',
            // 'bank_name',
            // 'bank_account_number',
            // 'bank_branch',
            // 'ifsc_code',
            // 'is_active',
            // 'created_date',
            // 'modified_date',

            //['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\ActionColumn',
                                    'template' => '{update}',
                                    ],
        ],
    ]);} ?>
</div>
