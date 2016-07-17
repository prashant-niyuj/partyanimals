<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\EventManagement */

$this->title = 'Update Event Management: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Event Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="event-management-update">

    

    <?= $this->render('_form', [
        'model' => $model,
        'param'=>$param
    ]) ?>

</div>
