<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\PartnerWithUs */

$this->title = 'Update Partner With Us: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Partner With uses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="partner-with-us-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
