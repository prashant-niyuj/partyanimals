<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\PartnerWithUs */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Partner With uses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partner-with-us-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

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
