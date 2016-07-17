<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ContactUs */

$this->title = 'Create Contact Us';
$this->params['breadcrumbs'][] = ['label' => 'Contact uses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-us-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
