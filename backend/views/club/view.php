<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ClubBooking */

$this->title = $model->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="club-booking-view">

   <p>
        <?php echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
       
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'address',
            'club_capacity',
            'booking_capacity',
            'logo',
            'area',
            'cityName',
            'priority_range',
            'booking_rate_ladies',
            'booking_rate_boy',
            'booking_rate_couple',
            'tax_rate',
            'commission',
            'commission_for_girl',
            'commission_for_stage',
            'commission_for_couple',
            'TAN',
            'PAN',            
            'club_open_days',
            'bank_name',
            'bank_account_number',
            'bank_branch',
            'ifsc_code',
            //'is_active',
            'created_date',
            'modified_date',
        ],
    ]) ?>

</div>
