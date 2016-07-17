<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ClubBookingNamesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Club Booking Names';
$this->params['breadcrumbs'][] = $this->title;

$url = \Yii::$app->urlManager->createUrl(['club-booking-names/setentry']);
$searchurl = \Yii::$app->urlManager->createUrl(['club-booking-names/index']);
$fullcluburl = \Yii::$app->urlManager->createUrl(['club-booking-names/fullclub']);
?>
<div style="float:left;padding-right:10px;"><?php echo "Booking Capacity: ".$bookinginfo['booking_capacity']?></div>
     <div style="float:left;padding-right:10px;"><?php echo "Booked: ".$bookinginfo['no_of_booking']?></div>
    <div style="float:left;padding-right:10px;"><?php echo "No of Entry : ".$noofentry?></div>
    <div style="padding-right:10px;"><a href="#" onclick="getfull('<?php echo $fullcluburl?>',<?php echo $club_id?>)"> <?php echo "Full Club "?></a></div>
    <br/>
<div class="club-booking-names-index">
   
 <div id="w0" class="grid-view">
    
<table class="table table-striped table-bordered"><thead>
<tr><th>#</th>
    <th><a href="/index.php?r=club-booking-names%2Findex&amp;sort=booking_no" data-sort="booking_no">Booking No</a></th>
     <!--<th><a href="/index.php?r=club-booking-names%2Findex&amp;sort=booking_date" data-sort="booking_date">Booking Date</a></th>-->
     <th><a href="/index.php?r=club-booking-names%2Findex&amp;sort=booking_category" data-sort="booking_category">Booking Category</a></th>
    <th><a href="/index.php?r=club-booking-names%2Findex&amp;sort=booking_name" data-sort="booking_name">Booking Name</a></th>
    <th><a href="/index.php?r=club-booking-names%2Findex&amp;sort=mobile_no" data-sort="mobile_no">Mobile No</a></th>
    <th><a href="/index.php?r=club-booking-names%2Findex&amp;sort=is_in" data-sort="is_in">Is In</a></th></tr>
    <tr id="w0-filters" class="filters">
        <td>&nbsp;</td>
        <td><input class="form-control" name="ClubBookingNamesSearch[booking_no]" type="text" id="booking_no" onBlur="getSearch('<?php echo $searchurl?>',this.value)"></td>
        <!--<td><input class="form-control" name="ClubBookingNamesSearch[booking_date]" type="text" id="booking_date" onBlur="getSearch('<?php echo $searchurl?>',this.value)"></td>-->
        <td><input class="form-control" name="ClubBookingNamesSearch[booking_category]" type="text" id="booking_category" onBlur="getSearch('<?php echo $searchurl?>',this.value)"></td>
        <td><input class="form-control" name="ClubBookingNamesSearch[booking_name]" type="text" id="booking_name" onBlur="getSearch('<?php echo $searchurl?>',this.value)"></td>
        <td><input class="form-control" name="ClubBookingNamesSearch[mobile_no]" type="text" id="mobile_no" onBlur="getSearch('<?php echo $searchurl?>',this.value)"></td>
        <td>Action</td>
    </tr>
</thead>
<tbody>
    <?php
    $i=1;
    $j=0;
    $groupno="0";
    if(count($models))
    {
    $bookingno=$models[0]['booking_no'];
    }else{
        $bookingno=""; 
    }
    $bookingName="";
    $flag=0;
   
    foreach($models as $data)
    {
     if(isset($models[$j+1]['booking_no']))
     {
        if($data["booking_category"]=="Couple" && $models[$j+1]['booking_no']==$data['booking_no'] )
        {
            $flag=1;
           // echo $models[$j+1]['booking_name'];die;
            $bookingName= $data['booking_name']." \\ ".$models[$j+1]['booking_name'];
            $j++;
            continue;

        }        
        if($flag==1)
        {
           
            $data['booking_name']=$bookingName;
            $flag=0;
        }
        
     }else{
      if($flag==1)
        {
            $data['booking_name']=$bookingName;
            $flag=0;
        }
     }
    ?>
     <?php 
      
        
        if($groupno!=$data['booking_no'] && $bookinginfo['is_full']==0 )
         {
           $groupno=$data['booking_no'];
            
           ?><tr><td></td><td><b><?php echo $data['booking_category']." - "?> <?php echo $data['booking_no'] ;?></b></td><td colspan="5" align="right"><?php if($data['booking_category']=="Group"){?><button onclick="getEntry(<?php echo $data['id']?>,'<?php echo $url?>','<?php echo $data['club_booking_id']?>','<?php echo $data['booking_category']?>','1')">All Entry</button><?php }?>
    </td></tr><?php }?>
<tr data-key="1">
    <?php ?>
    <td><?php echo $i++?></td>
    <td><?php echo $data['booking_no']?></td>
    <!--<td><?php echo $data['booking_date']?></td>-->
    <td><?php echo $data['booking_category']?></td> 
    <td><?php echo $data['booking_name']?></td>
    <td><?php echo $data['mobile_no']?></td>
    <td>
        <?php if( $data['is_in']==0 && $bookinginfo['is_full']==0){?>
        <div>
            <button onclick="getEntry(<?php echo $data['id']?>,'<?php echo $url?>','<?php echo $data['club_booking_id']?>','<?php echo $data['booking_category']?>','0')">In</button>
           
        </div>
        <?php }else{
            
            echo "-";
        }?>
       
    </td>
</tr>

    <?php 
  
    $j++;
    
        }?>
</tbody></table>
</div>
</div>
 <?php echo \yii\widgets\LinkPager::widget([
    'pagination'=>$dataProvider->pagination,
]); 
 
 ?>
<script>
   function getEntry(record_id,url,club_booking_id,booking_category,all_entry)
   {
       
       var r=confirm("Are you sure?");
       if(r===true)
       {
          
           
        $.ajax({
            type: 'GET',
            cache: false,
            data: {'record_id': record_id,'club_booking_id': club_booking_id,'booking_category': booking_category,'all_entry':all_entry},
            url: url,
            success: function(response) {
               location.reload(); 

            }
        });
        }
       
   }
   function getSearch(url,fieldvalue)
   {
      
       window.location=url+"&ClubBookingNamesSearch[booking_no]="+$("#booking_no").val()+"&ClubBookingNamesSearch[mobile_no]="+$("#mobile_no").val()+"&ClubBookingNamesSearch[booking_name]="+$("#booking_name").val()+"&ClubBookingNamesSearch[booking_category]="+$("#booking_category").val();
       
   }
   function getfull(fullcluburl,club_id)
   {
       var r=confirm("Are you sure?");
       if(r===true)
       {
        $.ajax({
            type: 'GET',
            cache: false,
            data: {'club_id': club_id},
            url: fullcluburl,
            success: function(response) {
               location.reload(); 

            }
        });
     }
       
   }
</script>
