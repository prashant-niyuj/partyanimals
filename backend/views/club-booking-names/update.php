<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ClubBookingNames */

$this->title = 'Update Club Booking Names: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Club Booking Names', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="club-booking-names-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
