<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EventManagementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Event Managements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-management-index">

   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Event Management', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'clubName',            
            'event_name',
            'event_description',
            [
            'attribute' =>  'event_date',
             'filter' => DatePicker::widget([
                'model'      => $searchModel,
                'attribute'  => 'event_date',
                'dateFormat' => 'php:Y-m-d',
                'options' => [
                    'class' => 'form-control'
                ]
            ]),
            ],
           
            // 'created_by',
           /*         [
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
