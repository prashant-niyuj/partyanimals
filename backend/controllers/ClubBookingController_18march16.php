<?php

namespace backend\controllers;

use Yii;
use backend\models\ClubBooking;
use backend\models\ClubBookingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ClubBookingController implements the CRUD actions for ClubBooking model.
 */
class ClubBookingController extends Controller
{
    public function behaviors()
    {
        return [
             'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                         'actions' => [],
                        'allow' => true,
                        'roles' => ['@'],
                     
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }


    /**
     * Lists all ClubBooking models.
     * @return mixed
     */
    public function actionIndex()
    {
        $userinfo=  \yii::$app->user->identity;
        if($userinfo['role_id']==3)
       {
            $this->redirect(['club-booking-names/index']);
       }
        $searchModel = new ClubBookingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
          
        ]);
    }

    /**
     * Displays a single ClubBooking model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $paymentModelObj=new \backend\models\BookingPaymentHistory();
        $paymentModel=$paymentModelObj->getPaymentHistory($id);
       // var_dump($paymentModel);die;
        return $this->render('view', [
            'model' => $this->findModel($id),
            'paymentModel'=>$paymentModel
        ]);
    }

    /**
     * Creates a new ClubBooking model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ClubBooking();
        
        $userinfo=Yii::$app->user->identity;
        $utilsObj=new \common\models\Utils();
        $model->pa_pnr=$utilsObj->randomString();
        $model->booked_type=1;
        $model->user_id=$userinfo['id'];
        $model->created_at=date("Y-m-d H:i:s");
        $model->updated_at=date("Y-m-d H:i:s");
        $model->in_confirm=0;
        $model->price_of_girl=0;
        $model->price_of_couple=0;
        $model->price_of_stage=0;
        $model->no_of_boys=0;
        $model->no_of_girls=0;
        if($userinfo['role_id']==5)
        {
           $model->club_id=$userinfo['club_id'];
           $clubDetails=  \backend\models\Club::findOne($userinfo['club_id']);
           $model->commission=$clubDetails->commission;
           $model->commission_rate=$clubDetails->commission_rate;
           $model->tax_rate=$clubDetails->tax_rate;
           $model->convenience_fee=$clubDetails->convenience_fee;
           
        }
        
        $bookingnameModelObj=new \backend\models\ClubBookingNames();
        $paymentModelObj=new \backend\models\BookingPaymentHistory();

        if($model->load(Yii::$app->request->post()) ) {
         
          // var_dump($model->booking_category);die;
             $session = Yii::$app->session;
            
             $arr_booking_data['c_id']=$userinfo['club_id'];
             $arr_booking_data['txt_datepicker']=$model->booking_date;
             $arr_booking_data['b_type']=  strtolower($model->booking_category);
             $arr_booking_data['popup_drop_boys']=$model->no_of_boys;
             $arr_booking_data['popup_drop_girls']=$model->no_of_girls;
             
             $session['booking_data']=$arr_booking_data;
            
            if (isset($arr_booking_data['c_id'])) 
            {
                $c_id = $arr_booking_data['c_id'];
                $obj_club = new \backend\models\Club();
                $obj_club_info = \backend\models\Club::findOne($c_id);
                //echo $obj_club->getCurentClubAvailableCapacity($c_id);
                //print_r($arr_booking_data);
                //die;
                if ($obj_club->getCurentClubAvailableCapacity($c_id) > 0)
                    return $this->render('confirm', array('obj_club_info' => $obj_club_info,'session'=>$session));
                else
                    return $this->render('confirm', array('obj_club_info' => $obj_club_info, 'is_full' => 1,'session'=>$session));
            }
            
         
            $model->save();
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'bookingnameModelObj'=>$bookingnameModelObj,
                'paymentModelObj'=>$paymentModelObj
            ]);
        }
    }

    /**
     * Updates an existing ClubBooking model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ClubBooking model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ClubBooking model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ClubBooking the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ClubBooking::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
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
                        echo $return_array['boy']."##".$return_array['girl']."##".$return_array['couple'] ;
			//echo json_encode($return_array);
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
                        echo $return_array['boy']."##".$return_array['girl']."##".$return_array['couple'] ;
			//echo json_encode($return_array);
			die;
		}
    }
    public function actionProcessorder() 
    {
    	
        $session = Yii::$app->session;
    	$arr_booking_data = $session['booking_data'];
       // var_dump($arr_booking_data);die;
		$connection = \Yii::$app->db;
	
		if(isset($arr_booking_data['c_id'])) {
			$c_id = $arr_booking_data['c_id'];
			$obj_club = new \backend\models\Club();
			$obj_club_info = \backend\models\Club::findOne($c_id);
			$arr_return = array();
			if($obj_club->getCurentClubAvailableCapacity($c_id) == 0 ) {
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
				$convienice_charges = $obj_club_info->convenience_fee;
				$tax_charges = ($club_chagres * $obj_club_info->tax_rate) / 100;
				$gross_total = $club_chagres + $tax_charges + $convienice_charges;
				$model->tax_rate = $tax_charges ;
				$commission_rate = 20;
				$model->commission_rate = 0;
				$commission = 'Percentage';
				$model->commission = $commission;
			
				$model->convenience_fee = $convienice_charges;
				
				$model->total_price = $gross_total;
				$model->booking_date = date("Y-m-d H:i:s",strtotime($arr_booking_data['txt_datepicker']));
				$in_confirm = 0;
				//$model->in_confirm = 0;
				$model->created_at = date("Y-m-d H:i:s");
                                //var_dump($_REQUEST);die;
                                $param=Yii::$app->request->post();
				if($model->save()){
					$order_id = $model->id;
                                        					
					$p=0;
					foreach ($param['booking_person'] as $name) {
						
						$modelClubBookingNames = new \backend\models\ClubBookingNames();
						
						if(isset($param['booking_person_mobile'][$p])) {
							$phone	= $param['booking_person_mobile'][$p];
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
						echo json_encode($arr_return);	
						die;
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
        
    public function actionThankyou() {
        
       // $utilsModel = new \common\models\Utils();
       // $pnr = $utilsModel->randomString(10);
        $subject="Confirm Booking";
        $session = Yii::$app->session;
        $arr_booking_data = $session['booking_data'];
        $userinfo=\Yii::$app->user->identity;
        
        if(isset($arr_booking_data['phone']))
        {
        $param['mobile_no']=$arr_booking_data['phone'];
        }else if(isset($userinfo['id']))
        {
        	$profile=\backend\models\Profile::find()->where(['user_id'=>$userinfo['id']])->one();
        	$param['mobile_no']=$profile->phone_no;
        }
        
        $param['subject']=$subject;
        if(isset($arr_booking_data['email']))
        {
        $param['email']=$arr_booking_data['email'];
        }else if(isset($userinfo['id']))
        {
        	$param['email']=$profile->gravatar_email;
        }
        $clubObj=  \backend\models\Club::findOne( $arr_booking_data['c_id']);
        $param['club_name']= $clubObj->name ;
        $param['booking_date']=$arr_booking_data['txt_datepicker'];
        $param['booking_type']=$arr_booking_data['b_type'];
        $pnr=  Yii::$app->request->get('pnr');
        $param['pnr']=$pnr;
        $view="orderconfirm";
        $utilsobj=new \common\models\Utils;
        $sendparam=array('mobile_no'=>$param['mobile_no'],'email'=>$param['email'],'club_name'=>$param['club_name'],'booking_date'=>$param['booking_date'],'pnr'=>$param['pnr'],'booking_type'=>$param['booking_type']);
        $mailsend=$utilsobj->sendMessage($param['email'], $param['subject'], $view, $sendparam);
        $view="sms/orderconfirm";
        $sendsms=$utilsobj->sendSMS($param['mobile_no'], $param['subject'], $view, $sendparam);
        return $this->render('thankyou',['param'=>$param]);
    }
    
}
