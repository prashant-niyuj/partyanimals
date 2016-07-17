<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CallHistroy */

$this->title = 'Update Call Histroy: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Call Histroys', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="call-histroy-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
