<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CallHistroy */

$this->title = 'Create Call Histroy';
$this->params['breadcrumbs'][] = ['label' => 'Call Histroys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="call-histroy-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
