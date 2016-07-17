<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ClubBookingNames */

$this->title = 'Create Club Booking Names';
$this->params['breadcrumbs'][] = ['label' => 'Club Booking Names', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="club-booking-names-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
