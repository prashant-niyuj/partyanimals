<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ClubBooking */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Club Bookings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="club-booking-view">

    <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_1" data-toggle="tab">Booking Details</a></li>
                  <li><a href="#tab_2" data-toggle="tab">Payment History</a></li>
                 
                  
                  <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
               <!--       <table>
                          
                          <tr>
                              <td><?php echo "Booking No"?></td><td><?php echo $model->booking_no?></td>
                               <td><?php echo "Booking Date"?></td><td><?php echo $model->booking_date?></td>
                          </tr>
                           <tr>
                              <td><?php echo "Booking Category"?></td><td><?php echo $model->booking_category?></td>
                              <?php if($model->booking_category=="Girl"){?>
                               <td><?php echo "Price of Girl/s"?></td><td><?php echo $model->price_of_girl?></td>
                              <?php }else if($model->booking_category=="Boy"){?>
                               <td><?php echo "Price of Stage/s"?></td><td><?php echo $model->price_of_stage?></td>
                              <?php }else if($model->booking_category=="Couple"){?>
                               <td><?php echo "Price of Couple"?></td><td><?php echo $model->price_of_couple?></td>
                              <?php }else if($model->booking_category=="Group"){?>
                               <td><?php echo "Price of Group"?></td><td><?php echo $model->price_of_group?></td>
                              <?php }?>
                          </tr>
                            <tr>
                                <?php if($model->booking_category=="Girl"){?>
                               <td><?php echo "No of Girl/s"?></td><td><?php echo $model->no_of_girls?></td>
                              <?php }else if($model->booking_category=="Boy"){?>
                               <td><?php echo "No of Stage/s"?></td><td><?php echo $model->no_of_stage?></td>
                              <?php }else if($model->booking_category=="Group"){?>
                               <td><?php echo "No of Girls"?></td><td><?php echo $model->no_of_group?></td>
                               <td><?php echo "No of Stage"?></td><td><?php echo $model->price_of_group?></td>
                              <?php }?>
                          </tr>
                            <tr>
                              <td><?php echo "Booking No"?></td><td><?php echo $model->booking_no?></td>
                               <td><?php echo "Booking No"?></td><td><?php echo $model->booking_no?></td>
                          </tr>
                            <tr>
                              <td><?php echo "Booking No"?></td><td><?php echo $model->booking_no?></td>
                               <td><?php echo "Booking No"?></td><td><?php echo $model->booking_no?></td>
                          </tr>
                            <tr>
                              <td><?php echo "Booking No"?></td><td><?php echo $model->booking_no?></td>
                               <td><?php echo "Booking No"?></td><td><?php echo $model->booking_no?></td>
                          </tr>
                            <tr>
                              <td><?php echo "Booking No"?></td><td><?php echo $model->booking_no?></td>
                               <td><?php echo "Booking No"?></td><td><?php echo $model->booking_no?></td>
                          </tr>
                          <tr>
                              <td><?php echo "Booking No"?></td><td><?php echo $model->booking_no?></td>
                               <td><?php echo "Booking No"?></td><td><?php echo $model->booking_no?></td>
                          </tr>
                          
                      
                      </table>-->
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
            'city_id',
            'priority_range',
            'booking_rate_ladies',
            'booking_rate_boy',
            'booking_rate_couple',
            'club_open_days',
            'bank_name',
            'bank_account_number',
            'bank_branch',
            'ifsc_code',
            'is_active',
            'created_date',
            'modified_date',
        ],
    ]) ?>

</div>
