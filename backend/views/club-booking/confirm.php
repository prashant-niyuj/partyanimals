<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Party Animals : Confirm';
$this->params['breadcrumbs'][] = $this->title;
$session = Yii::$app->session;
$arr_data = $session['booking_data'];

//var_dump($arr_data);die;
if(!Yii::$app->user->isGuest)
{
   $userinfo=Yii::$app->user->identity;
   $profile= backend\models\Profile::findOne($userinfo['id']);
 //  var_dump($profile);die;
   $arr_data['name'] =$userinfo['username'];
   $arr_data['phone'] =$profile['phone_no'];
}
$tax_charges = $obj_club_info->tax_rate;
$convienice_charges = $obj_club_info->convenience_fee;
?>
<div class="container">

	<div class="row" style="background-color:#fff;padding:10px">
	
	<form method="post" id="booking_confirm" action="index.php?r=club-booking/processorder">
    <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />		
	<h2 class="confirm_h2">Confirm Booking</h2>
    <h4 class="confirm_h4"> <?php echo $obj_club_info->name." <span>(".ucfirst($obj_club_info->area)."- Pune)</span> "; ?></h4>
	<p><center>
			<?php
			if(isset($arr_data['txt_datepicker']))
          	{
          		$date = date_create($arr_data['txt_datepicker']);
          		echo date_format($date, 'l jS F Y');
          	} ?>
	
	 <!--a href="#" style="padding-left:10px"> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a--></center></p>
	<div id="isconfirm">
		 <div class="alert alert-danger isfull" role="alert" style="display:none">Sorry! Club has Allready full</div>
		
	  <table class="table table-condensed">
      
      <tbody>
        
		<tr>
          <td width="40%"><b>Booking Type -</b></td>
          <td><?php echo ucfirst($arr_data['b_type']) ?></td>
        </tr>
        <tr>
          <td><b>Names - </b></td>
          <td></td>
        </tr>
        <tr>
		  <td colspan="2">
		  <table width="100%">
			<?php
				if($arr_data['b_type'] == 'boy') {
			?>		
			<tr>
				<td style="padding-bottom:5px">
				 <div class="row clearfix">
				 <div class="col-xs-6 col-md-6">
				 <div class="form-group">
				 <input name="booking_person[]" type="text" placeholder="Mr." class="form-control " value="<?php echo $arr_data['name'] ?>">
				 </div>
				 </div>
				 <div class="col-xs-6 col-md-6">
				 <div class="form-group">
				 <input id="booking_person_mobile_0" name="booking_person_mobile[]" type="text" placeholder="Mobile No" class="form-control " value="<?php echo $arr_data['phone'] ?>">
				  </div>
				  </div>
				  </div>
				  <!--a href="#" style="float:left;padding-left:10px">Edit</a-->
				 </td>
			</tr>
			<?php } ?>
			<?php
				if($arr_data['b_type'] == 'girl') {
			?>		
			<tr>
				<td style="padding-bottom:5px">
				<div class="row clearfix">
				<div class="col-xs-6 col-md-6">
				<div class="form-group">
				  <input name="booking_person[]" type="text" placeholder="Miss." class="form-control" value="<?php echo $arr_data['name'] ?>">
				 </div>
				 </div>
				 <div class="col-xs-6 col-md-6">
				 <div class="form-group">
				  <input id="booking_person_mobile_0" name="booking_person_mobile[]" type="text" placeholder="Mobile No" class="form-control " value="<?php echo $arr_data['phone'] ?>"> <!--a href="#" style="float:left;padding-left:10px">Edit</a-->
				  </div>
				  </div>
				  </div>
				 </td>
			</tr>
			<?php } ?>	
			<?php
				if($arr_data['b_type'] == 'couple') {
			?>		
			<tr>
				<td style="padding-bottom:5px">
				<div class="row clearfix">
				<div class="col-xs-6 col-md-6">
				<div class="form-group">
				<input name="booking_person[]" type="text" placeholder="Mr." class="form-control " value="<?php echo $arr_data['name'] ?>">
				</div>
				</div>
				<div class="col-xs-6 col-md-6">
				<div class="form-group">
				 <input id="booking_person_mobile_0" name="booking_person_mobile[]" type="text" placeholder="Mobile No" class="form-control " value="<?php echo $arr_data['phone'] ?>"> 
				</div>
				</div>
				</div>
				 <!--a href="#" style="float:left;padding-left:10px">Edit</a-->
				 </td>
			</tr>
			<tr>
				<td style="padding-bottom:5px">
				<div class="row clearfix">
				<div class="col-xs-6 col-md-6">
				<div class="form-group">
				<input name="booking_person[]" type="text" placeholder="Miss." class="form-control " >
				</div>
				</div>
				<div class="col-xs-6 col-md-6">
				<div class="form-group">
				  <input name="booking_person_mobile[]" type="text" placeholder="Mobile No" class="form-control " > 
				</div>
				</div>
				</div>
				<!--a href="#" style="float:left;padding-left:10px">Edit</a-->
				</td>
			</tr>
			<?php } ?>	
			<?php
				$is_phone_set = 0;
				if($arr_data['b_type'] == 'group') {
				for($i=0;$i< $arr_data['popup_drop_boys'];$i++) {
			?>		
			<tr>
				<td style="padding-bottom:5px">
				<div class="row clearfix">
				<div class="col-xs-6 col-md-6">
				<div class="form-group">				  
				 <input name="booking_person[]" type="text" placeholder="Mr." class="form-control " value="">
				  </div>
				</div>
				<div class="col-xs-3 col-md-3">
				<div class="form-group">
				  <?php if($i == 0) { 
					$is_phone_set = 1;
				  ?>	
				  <input id="booking_person_mobile_0" name="booking_person_mobile[]" type="text" placeholder="Mobile No" class="form-control " value=""> 
				  <?php } else { ?>
					<input name="booking_person_mobile[]" type="text" placeholder="Mobile No" class="form-control " > 
				  <?php } ?>	
				</div>
				</div>
				</div>  
				  <!--a href="#" style="float:left;padding-left:10px">Edit</a-->
				 </td>
			</tr>
			<?php } 
				for($i=0;$i< $arr_data['popup_drop_girls'] ;$i++) {
			?>
			<tr>
				<td style="padding-bottom:5px">
				  <div class="row clearfix">
				<div class="col-xs-6 col-md-6">
				<div class="form-group">
				  <input name="booking_person[]" type="text" placeholder="Miss." class="form-control confirm_booking_person" >
				  </div>
				 </div>
				 <div class="col-xs-3 col-md-3">
				 <div class="form-group">
				  <?php if($i == 0 && $is_phone_set == 0) { 
					$is_phone_set = 1;
				  ?>
				  <input id="booking_person_mobile_0" name="booking_person_mobile[]" type="text" placeholder="Mobile No" class="form-control " >
				 <?php } else { ?>
					<input  name="booking_person_mobile[]" type="text" placeholder="Mobile No" class="form-control " >
				<?php } ?> 
				  </div>
				</div>
				</div>
				  <!--a href="#" style="float:left;padding-left:10px">Edit</a-->
				 </td>
			</tr>
			<?php } } ?>
		  </table>
		  </td>
		</tr>         
		<tr>
          <td><b>Club Charges</b></td>
          <td><span class="ru"></span>
			<?php
			if(isset($arr_data['b_type']))
          	{
				$club_chagres = 0;
          		if($arr_data['b_type'] == 'boy')
					$club_chagres = $obj_club_info->booking_rate_boy;
				if($arr_data['b_type'] == 'girl')
					$club_chagres = $obj_club_info->booking_rate_ladies;
				if($arr_data['b_type'] == 'couple')
					$club_chagres = $obj_club_info->booking_rate_couple;
				if($arr_data['b_type'] == 'group')
				{
					if($arr_data['popup_drop_boys'] < $arr_data['popup_drop_girls']) {
						$only_girls = $arr_data['popup_drop_girls'] - $arr_data['popup_drop_boys'];
						$couple = $arr_data['popup_drop_boys'];
						$couples_rates = $obj_club_info->booking_rate_couple * $couple;
						$club_chagres = $only_girls * $obj_club_info->booking_rate_ladies;
						$club_chagres = $club_chagres + $couples_rates;
					}
					else {
						$only_boys = $arr_data['popup_drop_boys'] - $arr_data['popup_drop_girls'];
						$couple = $arr_data['popup_drop_girls'];
						$couples_rates = $obj_club_info->booking_rate_couple * $couple;
						$club_chagres = $only_boys * $obj_club_info->booking_rate_boy;
						$club_chagres = $club_chagres + $couples_rates;
					}
				}
				echo number_format($club_chagres,2);
          	} ?>	
		            
          </td>
        </tr>
		<?php if($convienice_charges > 0 )
			{ ?>
		<tr>
          <td><b>Convienice Charges</b></td>
          <td><span class="ru"></span>
			<?php
				//$convienice_charges = 20;
				echo number_format($convienice_charges,2);
			?>
				
          </td>
        </tr>
       <?php } ?>
	   <?php if($obj_club_info->tax_rate > 0 )
			{ ?>
		<tr>
          <td><b>Service Tax</b></td>
          <td><span class="ru"></span>
		  <?php
			
			if($obj_club_info->tax_rate > 0 )
			{
				$tax_charges = ($club_chagres * $obj_club_info->tax_rate) / 100;
				echo number_format($tax_charges,2);
			}
		  ?>
		  </td>
        </tr>
		<?php } ?>
        <tr>
          <td><b>Gross Total</b></td>
          <td><span class="ru"></span>
			<b><?php
				$gross_total = $club_chagres + $tax_charges + $convienice_charges;
				echo number_format($gross_total,2);
			?></b>
		  </td>
        </tr>

		<tr>
          <td><button type="submit" class="btn btn-primary pay_now">Pay Now</button></td>
          <td><button type="button" data-bb="confirm"  class="btn_book_now btn btn-primary cancel" data="6">Cancel</button></td>
        </tr>

        </tbody>
        </table>
        </div>
		</form>
</div>
</div>
<div id="confirm" class="modal hide fade">
  <div class="modal-body">
    Are you sure?
  </div>
  <div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Delete</button>
    <button type="button" data-dismiss="modal" class="btn">Cancel</button>
  </div>
</div>
<?php 
	if(isset($is_full))
	{
		if($is_full > 0 ) {
			echo "<script> var is_full = 'full';</script>";
		}
	}	
?>
		
<?php
$this->registerJs('$("document").ready(function(){ 
	if (typeof is_full !== "undefined") {
		if(is_full == "full") {
			$(".isfull").show();
			$(\'.pay_now\').attr(\'disabled\',\'disabled\');
		}	
		
			
	}	
	$(".navbar-toggle").click(function(e) {
		e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
	
	/*
	$("#booking_confirm").submit(function() {
		var paramObj = {};
		$.each($("#booking_confirm").serializeArray(), function(_, kv) {
		  paramObj[kv.name] = kv.value;
		});
								
		console.log(paramObj);
		 return false;
	});
	*/
	$("#booking_confirm")
    .bootstrapValidator({
        message: "This value is not valid",
        fields: {
            \'booking_person[]\': {
                validators: {
                   notEmpty: {
                        message: "The Name is required"
                    }
                }
            },
			\'booking_person_mobile[]\': {
                selector: \'#booking_person_mobile_0\',
				validators: {
                   notEmpty: {
                        message: "The phone is required"
                    },
					digits: {
						message: "The mobile phone number is not valid"
					},
					stringLength: {
                        min: 10,
                        message: "The mobile number must be 10 number"
                    }
                }
            }	
        }
    })
    .on("success.form.bv", function(e) {
        // Prevent form submission
        e.preventDefault();

        // Get the form instance
        var $form = $(e.target);

        // Get the BootstrapValidator instance
        var bv = $form.data("bootstrapValidator");
        var fields = $form.serializeArray();
        //console.log(fields);
		
        // Use Ajax to submit form data
         $.post($form.attr("action"), $form.serialize(), function(result) {
           	console.log(result);
			if(result["status"] == false)
			{
				$(".isfull").show();
				$(\'.pay_now\').attr(\'disabled\',\'disabled\');
			}
			else 
			{
				//alert("sucess");
				if(result["b_id"])
					window.location.href = "index.php?r=club-booking/thankyou&b_id="+result["b_id"];
				else
					window.location.href = result["url"];
				
			}
        }, "json");
		
    });
	
	
	
	
	$(".cancel").click(function() {
		bootbox.confirm("Are you sure want to quit this process?", function(result) {
		if(result == true) {
			window.location.href= "index.php";
		}	
		});
  });
	
});');

?>	
