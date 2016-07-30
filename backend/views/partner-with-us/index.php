<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PartnerWithUsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Partner With Us';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partner-with-us-index">

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'partner_type',
            'name_of_venue',
            //'description:ntext',
            //'address',
             'email:email',
             'contact_no',
             'contact_name',
            // 'created_at',

            ['class' => 'yii\grid\ActionColumn','template'=>"{view}"],
        ],
    ]); ?>
</div>
