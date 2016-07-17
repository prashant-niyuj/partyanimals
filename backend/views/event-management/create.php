<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\EventManagement */

$this->title = 'Create Event Management';
$this->params['breadcrumbs'][] = ['label' => 'Event Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-management-create">

   

    <?= $this->render('_form', [
        'model' => $model,
        'param'=>$param
    ]) ?>

</div>
