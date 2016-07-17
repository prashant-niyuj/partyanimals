<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Club */

$this->title = 'Update Club: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Clubs', 'url' => ['index']];

$this->params['breadcrumbs'][] = 'Update';
?>
<div class="club-update">

  

    <?= $this->render('_form', [
        'model' => $model,
		'cityArray'=>$cityArray,
    ]) ?>

</div>
