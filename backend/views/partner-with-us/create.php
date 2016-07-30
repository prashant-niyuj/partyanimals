<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\PartnerWithUs */

$this->title = 'Create Partner With Us';
$this->params['breadcrumbs'][] = ['label' => 'Partner With uses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partner-with-us-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
