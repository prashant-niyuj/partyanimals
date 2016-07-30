<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\PartnerWithUs */

$this->title = $model->contact_name;
$this->params['breadcrumbs'][] = ['label' => 'Partner With Us', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partner-with-us-view">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'partner_type',
            'name_of_venue',
            'description:ntext',
            'address',
            'email:email',
            'contact_no',
            'contact_name',
            'created_at',
        ],
    ]) ?>

</div>
