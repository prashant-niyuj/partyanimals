<?php
namespace frontend\controllers;
use backend\models\Club;
use backend\models\City;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\db\Query;
use frontend\models\AtomPayment;



/**
 * Site controller
 */
class BookingController extends Controller
{
    public function actionSearch()
    {
    	$connection = \Yii::$app->db;
		if(isset($_COOKIE['selectcity']))
    		$arr_data = $_COOKIE['selectcity'];
			
		$where = "";
		if(isset($arr_data)) {
    		$city_id = City::find()->where(['name' => $arr_data])->one()->getCityId();
			$where = " where is_active = 1 and city_id = ".$city_id;
    	}	
		if($where)
		{
			$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';	
			if($location != '')
			{
				$where .= " and area = '".$location."'";
			}
			$club_name = isset($_REQUEST['club_name']) ? $_REQUEST['club_name'] : '';	
			if($club_name != '')
			{
				$where .= " and name = '".$club_name."'";
			}
		}
		//echo 'SELECT id,name,club_open_days,logo FROM club '.$where;
		//die;
    	$model = $connection->createCommand('SELECT id,name,club_open_days,logo FROM club '.$where);
		$arr_result = $model->queryAll();
    	
    	echo json_encode($arr_result);
		die;
    }
    
	public function actionCheckclubookingstatus()
    {
		$return_array = array();
		if(Club::is_full_club($_REQUEST['c_id'],$_REQUEST['txt_datepicker']))
		{
			$return_array['status'] = false;
			echo json_encode($return_array);
			die;
		}
		else
		{
			$arr_post_data = array();
			foreach($_POST as $key => $value) {
				if($value)
					$arr_post_data[$key] = $value;
			}
			$session = Yii::$app->session;
			$session['booking_data'] = $arr_post_data;
			if(Yii::$app->user->isGuest)
                        {
				$this->redirect(["/user/security/login",'formbooking'=>1]);
                        }
			else {
				$this->redirect(["/site/confirm"]);
                        }
		}	
    }
     public function actionGetratebydate()
    {
		$connection = \Yii::$app->db;
		$return_array = array();
		$currdate = isset($_REQUEST['currdate']) ? $_REQUEST['currdate'] : '';
		$c_id = isset($_REQUEST['c_id']) ? $_REQUEST['c_id'] : '';
		if($currdate !='' && $c_id !='')
		{
			$currdate = date("Y-m-d", strtotime($currdate));
			
			$model = $connection->createCommand('select 
			CASE
				WHEN b.rate_date IS Not NULL THEN b.boy_rate
			ELSE
				c.booking_rate_boy 
			END as boy,
			CASE
				WHEN b.rate_date IS Not NULL THEN b.girl_rate
			ELSE
				c.booking_rate_ladies 
			END as girl,
			CASE
				WHEN b.rate_date IS Not NULL THEN b.couple_rate
			ELSE
				c.booking_rate_couple 
			END as couple
			from club c
			left join booking_rate_asdate b on b.club_id = c.id and b.rate_date = "'.$currdate.'"
			where c.id = '.$c_id.' limit 0,1
			');
						
			$arr_result = $model->queryAll();
			$arr_city = array();
			$return_array = $arr_result[0];
			echo json_encode($return_array);
			die;
		}
		else
		{
			$model = $connection->createCommand('select 
			c.booking_rate_boy as boy,c.booking_rate_ladies as girl, c.booking_rate_couple as couple
			from club c
			where c.id = '.$c_id.' limit 0,1
			');
						
			$arr_result = $model->queryAll();
			$arr_city = array();
			$return_array = $arr_result[0];
			echo json_encode($return_array);
			die;
		}
    }
    public function actionProcessbookingpopup() {
        	
    	$arr_post_data = array();
    	foreach($_POST as $key => $value) {
    		if($value)
    			$arr_post_data[$key] = $value;
	   	}
	   	$session = Yii::$app->session;
	   	$session['booking_data'] = $arr_post_data;
   		
	   	if(Yii::$app->user->isGuest)
	   		$this->redirect("index.php?r=site/signup");
	   	else 
	   		$this->redirect("index.php?r=site/signup");
	   		
    }
    
    public function actionProcessbookingasguest() {
    	$session = Yii::$app->session;
    	$connection = \Yii::$app->db;
		$arr_post_data = $session['booking_data'];
    	
    	if(isset($_POST['email']))
    		$arr_post_data['email'] = $_POST['email'];
			
		if(isset($_POST['name']))
    		$arr_post_data['name'] = $_POST['name'];	
    	
    	if(isset($_POST['phone']))
    		$arr_post_data['phone'] = $_POST['phone'];
    	
    	$session['booking_data'] = $arr_post_data;
             $model=new \app\models\GuestUser();
           $saveguestuser = $model->setguestUserData($arr_post_data);
           
            if($saveguestuser)
             {
				 $session->set("user_id",$saveguestuser);
				 $session->set("is_guest",true);
             }		
    	//print_r($session['booking_data']);
    	$this->redirect("index.php?r=site/confirm");
    	 	
    }
    public function actionLocality() {
    	$connection = \Yii::$app->db;
    	
    	if(isset($_COOKIE['selectcity']))
    		$arr_data = $_COOKIE['selectcity'];
    	
    	if(isset($arr_data)) {
			$type_option = isset($_REQUEST['q']) ? $_REQUEST['q'] : '';
			
    		$city_id = City::find()->where(['name' => $arr_data])->one()->getCityId();
    		$model = $connection->createCommand('SELECT distinct area as name FROM club cl
			left join city c on c.id = cl.city_id
			where c.id = '.$city_id.' and area like "%'.$type_option.'%" and cl.area is NOT null limit 0,10');
    	}
    	else {
    		$model = $connection->createCommand('SELECT distinct area as name FROM club limit 0,10');
    	}
    	
    	$arr_result = $model->queryAll();
    	$arr_city = array();
    	
    	foreach ($arr_result as $item)
    	{
    		array_push($arr_city, ucfirst( $item['name']) );
    	}
    	
    	echo json_encode($arr_city);
    	die;
    }
    
    public function actionCity() {
    	$type_option = isset($_REQUEST['q']) ? $_REQUEST['q'] : '';
    	$connection = \Yii::$app->db;
    	if($type_option)
    		$model = $connection->createCommand('SELECT name FROM city where name like "%'.$type_option.'%" ');
    	else 
    		$model = $connection->createCommand('SELECT name FROM city');
    	$arr_result = $model->queryAll();
    	$arr_city = array();
    	 
    	foreach ($arr_result as $item)
    	{
    		array_push($arr_city, ucfirst( $item['name']) );
    	}
    	 
    	echo json_encode($arr_city);
    	die;
    }
    
    public function actionClublist() {
    	
		$locality = isset($_REQUEST['locality']) ? $_REQUEST['locality'] : '';
		$type_option = isset($_REQUEST['q']) ? $_REQUEST['q'] : '';
		
		if(isset($_COOKIE['selectcity']))
			$arr_data = $_COOKIE['selectcity'];
		
		$connection = \Yii::$app->db;
		$where = "";
		if(isset($arr_data)) {
			$city_id = City::find()->where(['name' => $arr_data])->one()->getCityId();
			$where .= " where city_id = '$city_id' ";
		}
		
		if($where != '')
		{
			$where .= ' and name like "%'.$type_option.'%" ';
			
		    $model = $connection->createCommand('SELECT name FROM club '.$where);
		}	
		else
			$model = $connection->createCommand('SELECT name FROM club');
			
    	$arr_result = $model->queryAll();
    	$arr_list = array();
    	 
    	foreach ($arr_result as $item)
    	{
    		array_push($arr_list, ucfirst( $item['name']) );
    	}
    	 
    	echo json_encode($arr_list);
    	die;
    }
	
	public function actionProcessorder() {
    	$session = Yii::$app->session;
    	$arr_booking_data = $session['booking_data'];
		$connection = \Yii::$app->db;
	
		if(isset($arr_booking_data['c_id'])) {
			$c_id = $arr_booking_data['c_id'];
			$obj_club = new Club();
			$obj_club_info = Club::findOne($c_id);
			$arr_return = array();
			if($obj_club->getCurentClubAvailableCapacity($c_id,$arr_booking_data['txt_datepicker']) == 0 ) {
				$arr_return['status'] = false;
				echo json_encode($arr_return);	
				die;
			}
			else
			{
				$model = new \backend\models\ClubBooking();
				 
				$model->club_id = $c_id;

				$utilsModel=new \common\models\Utils();
				$pnr  = $utilsModel->randomString(10);
				
				$model->pa_pnr = $pnr;
				if(isset($session['is_guest'])) {
					$b_type = 1;
					$model->booked_type = $b_type;
					$model->user_id = $session['user_id'];
				}	
				else {
					$b_type = 0;
					$model->booked_type = $b_type;
					$model->user_id = Yii::$app->user->id;
				}
						
				$price_model = $connection->createCommand('select 
				CASE
					WHEN b.rate_date IS Not NULL THEN b.boy_rate
				ELSE
					c.booking_rate_boy 
				END as boy,
				CASE
					WHEN b.rate_date IS Not NULL THEN b.girl_rate
				ELSE
					c.booking_rate_ladies 
				END as girl,
				CASE
					WHEN b.rate_date IS Not NULL THEN b.couple_rate
				ELSE
					c.booking_rate_couple 
				END as couple
				from club c
				left join booking_rate_asdate b on b.club_id = c.id and b.rate_date = "'.date("Y-m-d H:i:s",strtotime($arr_booking_data['txt_datepicker'])).'"
				where c.id = '.$c_id.' limit 0,1
				');
				$price_result = $price_model->queryAll();
				$price_array = $price_result[0];
				
				$model->price_of_girl = $price_array['girl'];
				$model->price_of_stage = $price_array['boy'];
				$model->price_of_couple = $price_array['couple'];
				
				$model->booking_category = ucfirst($arr_booking_data['b_type']);
				if($arr_booking_data['b_type'] == 'group') 
				{
					$model->no_of_girls = $arr_booking_data['popup_drop_girls'];
					$model->no_of_boys = $arr_booking_data['popup_drop_boys'];
				}
				
				
				
				$club_chagres = 0;
          		if($arr_booking_data['b_type'] == 'boy')
					$club_chagres = $price_array['boy'];
				if($arr_booking_data['b_type'] == 'girl')
					$club_chagres = $price_array['girl'];
				if($arr_booking_data['b_type'] == 'couple')
					$club_chagres = $price_array['couple'];
				if($arr_booking_data['b_type'] == 'group')
				{
					if($arr_booking_data['popup_drop_boys'] < $arr_booking_data['popup_drop_girls']) {
						$only_girls = $arr_booking_data['popup_drop_girls'] - $arr_booking_data['popup_drop_boys'];
						$couple = $arr_booking_data['popup_drop_boys'];
						$couples_rates = $price_array['couple'] * $couple;
						$club_chagres = $only_girls * $price_array['girl'];
						$club_chagres = $club_chagres + $couples_rates;
					}
					else {
						$only_boys = $arr_booking_data['popup_drop_boys'] - $arr_booking_data['popup_drop_girls'];
						$couple = $arr_booking_data['popup_drop_girls'];
						$couples_rates = $price_array['couple'] * $couple;
						$club_chagres = $only_boys * $price_array['boy'];
						$club_chagres = $club_chagres + $couples_rates;
					}
				}
				$convienice_charges = Yii::$app->params['convenience_fee'];
				$tax_charges = ($club_chagres * $obj_club_info->tax_rate) / 100;
				$gross_total = $club_chagres + $tax_charges + $convienice_charges;
				$model->tax_rate = $tax_charges ;
				$commission_rate = 10;
				$model->commission_rate = 0;
				$commission = 'Percentage';
				$model->commission = $commission;
			
				$model->convenience_fee = $convienice_charges;
				
				$model->total_price = $gross_total;
				$model->booking_date = date("Y-m-d H:i:s",strtotime($arr_booking_data['txt_datepicker']));
				$in_confirm = 0;
				//$model->in_confirm = 0;
				$model->created_at = date("Y-m-d H:i:s");
				if($model->save()){
					$order_id = $model->id;
					
					$p=0;
					foreach ($_REQUEST['booking_person'] as $name) {
						
						$modelClubBookingNames = new \backend\models\ClubBookingNames();
						
						if(isset($_REQUEST['booking_person_mobile'][$p])) {
							$phone	= $_REQUEST['booking_person_mobile'][$p];
							$modelClubBookingNames->mobile_no = $phone;
						}
						
						$modelClubBookingNames->club_booking_id = $order_id;
						$modelClubBookingNames->booking_name = $name;
						
						$modelClubBookingNames->created_at = date("Y-m-d H:i:s");
						if($modelClubBookingNames->save())
							$p++;
					}
					
					$modelBookingPaymentHistory = new \backend\models\BookingPaymentHistory();
					$raw_request ="123456";					
					$modelBookingPaymentHistory->booking_id = $order_id;
					$modelBookingPaymentHistory->amount = $gross_total;
					
					$modelBookingPaymentHistory->raw_request = $raw_request;
										
					if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
						$ip = $_SERVER['HTTP_CLIENT_IP'];
					} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
						$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
					} else {
						$ip = $_SERVER['REMOTE_ADDR'];
					}
					
					$modelBookingPaymentHistory->customer_ip = $ip;
					$modelBookingPaymentHistory->created_at = date("Y-m-d H:i:s");
					
					if($modelBookingPaymentHistory->save())
					{
						
						$bookingCapacityAsdateModels = \backend\models\BookingCapacityAsdate::find()->asArray()->where(['club_id'=>$c_id,'capacity_active_date'=>date("Y-m-d",strtotime($arr_booking_data['txt_datepicker']))])->all();
					
						if(count($bookingCapacityAsdateModels) == 0) {
							$query_bookingCapacityAsdateModels = $connection->createCommand("insert into booking_capacity_asdate (`id`,`club_id`,`booking_capacity`,`capacity_active_date`,`created_at`,`no_of_booking`) values ('NULL',".$c_id.",".$obj_club_info->booking_capacity.",'".date("Y-m-d",strtotime($arr_booking_data['txt_datepicker']))."','".date("Y-m-d")."',1);");
							$query_bookingCapacityAsdateModels->execute();			
						}
						else
						{
							$query_bookingCapacityAsdateModels = $connection->createCommand("update booking_capacity_asdate set `no_of_booking` = `no_of_booking` +1 where club_id = ".$c_id." and capacity_active_date= '".date("Y-m-d",strtotime($arr_booking_data['txt_datepicker']))."'");					
							$query_bookingCapacityAsdateModels->execute();
						}
						
						$arr_return['status'] = true;
						$arr_return['pnr'] = $pnr;
						//Site order process and dorward to payment 
						if(Yii::$app->params['is_local']) {
							 
							$payment = new AtomPayment();

							$returnData = $payment->sendInfo($order_id,$gross_total);
							$payment->writeLog($returnData."\n");
							$xmlObjArray = $payment->xmltoarray($returnData);
							
							$url = $xmlObjArray['url'];
							$postFields  = "";
							$postFields .= "&ttype=NBFundTransfer";
							$postFields .= "&tempTxnId=".$xmlObjArray['tempTxnId'];
							$postFields .= "&token=".$xmlObjArray['token'];
							$postFields .= "&txnStage=1";
							$url = $payment->url."?".$postFields;
							
							$payment->writeLog($url."\n");
							//header("Location: ".$url);

							$arr_return['b_id'] = $order_id;
							$arr_return['url'] = $url;
							echo json_encode($arr_return);	
							die;
						} else {
							
							$payment = new AtomPayment();

							$returnData = $payment->sendInfo($order_id,$gross_total);
							$payment->writeLog($returnData."\n");
							$xmlObjArray = $payment->xmltoarray($returnData);
							
							$url = $xmlObjArray['url'];
							$postFields  = "";
							$postFields .= "&ttype=NBFundTransfer";
							$postFields .= "&tempTxnId=".$xmlObjArray['tempTxnId'];
							$postFields .= "&token=".$xmlObjArray['token'];
							$postFields .= "&txnStage=1";
							$url = $payment->url."?".$postFields;
							
							$payment->writeLog($url."\n");
							//header("Location: ".$url);

							$arr_return['b_id'] = $order_id;
							$arr_return['url'] = $url;
							echo json_encode($arr_return);	
							die;
							// $api = new Instamojo('971542dda81fa94a308b13a07465194e', '20587eb9956553694f7159b29fd7b728');
				   //          try {
		     //                	$response = $api->linkCreate(array(
		     //                    'title'=>'Party Animals',
		     //                    'description'=>'Party Animals Ticket Booking',
		     //                    'base_price'=>$gross_total,
		     //                    'cover_image'=>'/path/to/photo.jpg',
		     //                    'redirect_url' => 'http://partyanimals.in/beta/frontend/web/index.php?r=site/thankyou&b_id='.$order_id
		     //                    ));

		     //                	$arr_return['url'] = $response["url"];
							// 	echo json_encode($arr_return);	
							// 	die;

			                }
			                // catch (Exception $e) {
			                //     print('Error: ' . $e->getMessage());
			                // }
			        	//}

			            
					}	
						
				}
				else {
					print_r($model);
					echo "Order not created";
					die;
				}	
				//echo "prashant"; 
			}
			
			
			die;
		}
		else
		{
			$this->redirect("index.php");
		}		
	}
}
