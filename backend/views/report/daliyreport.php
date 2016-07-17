<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ClubBookingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daily Report';
$this->params['breadcrumbs'][] = $this->title;
$userinfo=  Yii::$app->user->identity;

?>

    <div class="form-group">
        <?php $form = ActiveForm::begin(['method'=>"get"]); ?>

<div class="rows">
    <?php
    
     if($userinfo['role_id']==1)
        {
    ?>
    <div class="col-lg-2">
    <select name="c_id">
        <option value=""><?php echo "Select Club"?></option>
        
        <?php foreach($clubArray as $key=>$club){?>
        <option value="<?php echo $key?>" <?php if($c_id==$key){ echo "Selected";}?>><?php echo $club?></option>
        <?php } ?>
    </select>
    </div>
        <?php } ?>
    <div class="col-lg-4">
        <label>Booking Date </label>
        <?php
        echo DatePicker::widget([
    'name' => "booking_date",
    'attribute' => 'booking_date',
    //'language' => 'ru',
    'dateFormat' => 'yyyy-MM-dd',
     'value'=>$booking_date,
]);
        ?>
        
    </div>
    
</div>
<div class="col-lg-2">
    <div class="form-group">
    <?= Html::submitButton('generate' , ['class' => 'btn btn-success']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
</div>
<br/>
<br/>
<div class="club-booking-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
           // 'pa_pnr',
           // 'clubName',
            //'booked_type',
           // 'bookedName',
            // 'price_of_girl',
            // 'price_of_stage',
            // 'price_of_couple',
             'booking_category',
             'no_of_girls',
             'no_of_boys',
            // 'tax_rate',
            // 'commission_rate',
             'commission',
             'convenience_fee',
               'total_price',
          /*   [
            'attribute' =>   'booking_date',
              'format' =>  ['date', 'php:Y-m-d'],
            ],*/
          
            // 'created_at',
            // 'updated_at',

             
        ],
    ]); ?>

</div>
