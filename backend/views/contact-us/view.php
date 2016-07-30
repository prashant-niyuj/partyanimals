<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\ContactUs */

$this->title = $model->contact_name;
$this->params['breadcrumbs'][] = ['label' => 'Contact Us', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-us-view">
 

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'contact_name',
            'contact_email:email',
            'contact_no',
            'subject',
            'message:ntext',
            'created_at',
        ],
    ]) ?>

</div>
