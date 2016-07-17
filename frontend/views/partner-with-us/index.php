<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PartnerWithUsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Partner With uses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partner-with-us-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Partner With Us', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'partner_type',
            'name_of_venue',
            'description:ntext',
            'address',
            // 'email:email',
            // 'contact_no',
            // 'contact_name',
            // 'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
