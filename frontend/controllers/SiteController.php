<?php
namespace frontend\controllers;
use backend\models\Club;

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
use dektrium\user\Module;
use yii\authclient\AuthAction;
use yii\authclient\ClientInterface;
use yii\helpers\Url;
use yii\web\Response;
use dektrium\user\traits\AjaxValidationTrait;
use frontend\models\Instamojo;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function beforeAction($action)
    {
        if ($action->id == 'thankyou') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }


    public function actionIndex() {
        return $this->render('index');
    }

    public function actionSearch() {
        $arr_result = array(
            array(
                "id" => 1,
                "c_name" => "JavaScript",
                "girls" => 100,
                "boys" => 200,
                "boys" => 300,
                "url" => "images/1.jpg"
            ),
            array(
                "id" => 2,
                "c_name" => "C++",
                "girls" => 100,
                "boys" => 200,
                "boys" => 300,
                "url" => "images/1.jpg"
            )
        );
        echo json_encode($arr_result);
        die;
    }

    public function actionLogin() {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }   
    public function actionTrackcall()
    {
        $connection = \Yii::$app->db;
        $name="";
        $ctype="m";
        if($_REQUEST['self'] && $_REQUEST['incoming']) {
            if(isset($_REQUEST['name']))
                $name=$_REQUEST['name'];
            if(isset($_REQUEST['ctype']))
                $ctype=$_REQUEST['ctype'];  
            $connection->createCommand() ->insert('call_histroy', [ 'self' => $_REQUEST['self'], 'incoming' => $_REQUEST['incoming'],'name' =>$name,'c_type' =>$ctype ]) ->execute();
        }
        $return_arr = array();
        $return_arr['statusCode'] = 'Success';
        $return_arr['statusMessage'] = 'Data sent successfully';
        echo json_encode($return_arr);
        die;
    }
    
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                        'model' => $model,
            ]);
        }
    }

    public function actionProcessbookingpopup() {

        $arr_responce = array('status' => 'sucess');
        echo json_encode($arr_responce);
        die;
    }

    public function actionSignup() {
        //$model = new SignupForm();

        $model = \Yii::createObject(\backend\models\LoginForm::className());

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
                    'model' => $model,
                    //$modelLogin=>$modelLogin,
                    'module' => $this->module,
        ]);
    }

    public function actionConfirm() {
        $session = Yii::$app->session;
        $arr_booking_data = $session['booking_data'];
        if (isset($arr_booking_data['c_id'])) {
            $c_id = $arr_booking_data['c_id'];
            $obj_club = new Club();
            $obj_club_info = Club::findOne($c_id);

            if ($obj_club->getCurentClubAvailableCapacity($c_id,$arr_booking_data['txt_datepicker']) > 0)
                return $this->render('confirm', array('obj_club_info' => $obj_club_info));
            else
                return $this->render('confirm', array('obj_club_info' => $obj_club_info, 'is_full' => 1));
        }
        else {
            $this->redirect("index.php");
        }
    }

    public function actionThankyou() {
        $utilsobj=new \common\models\Utils;
        $array_b_type = array('boy' => 'Stag','girl' =>'girl','couple'=>'couple','group'=>'group');

        if(Yii::$app->params['is_local']) {
            $subject="Confirm Booking";
            $session = Yii::$app->session;
            //print_r($session['booking_data']);
            $arr_booking_data = '';
            $b_id = $_REQUEST['b_id'];
            $payment_id = '111';
            $status = 'Success';
            if($b_id) {
                $bookingObj = \backend\models\ClubBooking::findOne( $b_id );
                $bookingNames = $bookingObj->getClubBookingNames();
                $arr_booking_data['c_id'] = $bookingObj->club_id;
                $arr_booking_data['b_type'] = $bookingObj->booking_category;
                $arr_booking_data['txt_datepicker'] = date('d-m-Y',strtotime($bookingObj->booking_date));
                $arr_booking_data['pnr'] = $bookingObj->pa_pnr;

               $booking_payment_histroy = \backend\models\BookingPaymentHistory::find()
                                        ->where('booking_id = :b_id', [':b_id' => $b_id])
                                        ->one();
               $booking_payment_histroy->payment_transaction_id = $payment_id;
               $booking_payment_histroy->payment_type = 'local';
               $booking_payment_histroy->response = '';
               $booking_payment_histroy->payment_status = 'Success';
               $booking_payment_histroy->save();
                        
                
                $clubObj=Club::findOne( $arr_booking_data['c_id']);
                $param['club_name']= $clubObj->name ;
                $param['booking_date']=$arr_booking_data['txt_datepicker'];
                $param['booking_type'] = $array_b_type[strtolower($arr_booking_data['b_type'])];
                $param['pnr']= $arr_booking_data['pnr'];
            
                return $this->render('thankyou',['is_error'=>false,'param'=>$param]);
                } else {
                    return $this->render('thankyou',['is_error'=>true,'msg'=>'Order id not found']);
                }
            } 
            else 
            {
                $session = Yii::$app->session;
                $arr_booking_data = '';
                if(isset($_REQUEST['mer_txn'])) {
                $b_id = $_REQUEST['mer_txn'];
                $f_code = $_REQUEST['f_code'];

                if($b_id > 1 && $f_code == 'Ok' ) {
                    
                    $bookingObj = \backend\models\ClubBooking::findOne( $b_id );
                    $bookingNames = $bookingObj->getBookedName();
                    $arr_booking_data['c_id'] = $bookingObj->club_id;
                    $arr_booking_data['b_type'] = $bookingObj->booking_category;
                    $arr_booking_data['txt_datepicker'] = date('d-m-Y',strtotime($bookingObj->booking_date));
                    $arr_booking_data['pnr'] = $bookingObj->pa_pnr;

                    if($bookingObj->booked_type == 1) {
                        $user_obj = \backend\models\GuestUser::findOne( $bookingObj->user_id );
                        $param['mobile_no']=$user_obj->mobile_no;
                        $param['email']=$user_obj->email_address;
                    } else {
                        $user_obj = \backend\models\User::findOne( $bookingObj->user_id );
                        $param['mobile_no']=$user_obj->email;
                        $param['email']=$user_obj->phone_no;
                    }

                    $param['user_name']= $bookingNames;
                    
                    $clubObj=Club::findOne( $arr_booking_data['c_id']);
                    $param['club_name']= $clubObj->name ;
                    $param['booking_date']=$arr_booking_data['txt_datepicker'];

                    $param['booking_type'] = $array_b_type[strtolower($arr_booking_data['b_type'])];
                    $param['pnr']= $arr_booking_data['pnr'];
                    
                    $booking_payment_histroy = \backend\models\BookingPaymentHistory::find()
                    ->where('booking_id = :b_id', [':b_id' => $b_id])
                    ->one();
                            
                   $booking_payment_histroy->payment_transaction_id = $_REQUEST['bank_txn'];
                   $booking_payment_histroy->payment_type = 'ATOM';
                   $booking_payment_histroy->response = serialize($_REQUEST);
                   $booking_payment_histroy->payment_status = 'Success';
                   $booking_payment_histroy->save();

                    //Mail message send here
                    $view="orderconfirm";            
                    $param['subject']="Party Animals Confirm Booking";
                    $sendparam=array('mobile_no'=>$param['mobile_no'],'email'=>$param['email'],'club_name'=>$param['club_name'],'booking_date'=>$param['booking_date'],'pnr'=>$param['pnr'],'booking_type'=>$param['booking_type'],'user_name'=>$param['user_name']);
                    $mailsend=$utilsobj->sendMessage($param['email'], $param['subject'], $view, $sendparam,'booking@partyanimals.in',"Party Amimals Booking");
                    $view="sms/orderconfirm";
                    //$sendsms=$utilsobj->sendSMS($param['mobile_no'], $param['subject'], $view, $sendparam);
                    
                    return $this->render('thankyou',['is_error'=>'sucess','param'=>$param]);
                }
                if($b_id > 1 && $f_code == 'C' ) {
                    $bookingObj = \backend\models\ClubBooking::findOne( $b_id );
                    $bookingNames = $bookingObj->getBookedName();
                    $arr_booking_data['c_id'] = $bookingObj->club_id;
                    $arr_booking_data['b_type'] = $bookingObj->booking_category;
                    $arr_booking_data['txt_datepicker'] = date('d-m-Y',strtotime($bookingObj->booking_date));
                    $arr_booking_data['pnr'] = $bookingObj->pa_pnr;

                    if($bookingObj->booked_type == 1) {
                        $user_obj = \backend\models\GuestUser::findOne( $bookingObj->user_id );
                        $param['mobile_no']=$user_obj->mobile_no;
                        $param['email']=$user_obj->email_address;
                    } else {
                        $user_obj = \backend\models\User::findOne( $bookingObj->user_id );
                        $param['mobile_no']=$user_obj->email;
                        $param['email']=$user_obj->phone_no;
                    }

                    $param['user_name']= $bookingNames;

                    $clubObj=Club::findOne( $arr_booking_data['c_id']);
                    $param['club_name']= $clubObj->name ;
                    $param['booking_date']=$arr_booking_data['txt_datepicker'];

                    $param['booking_type'] = $array_b_type[strtolower($arr_booking_data['b_type'])];
                    $param['pnr']= $arr_booking_data['pnr'];
                    
                    $booking_payment_histroy = \backend\models\BookingPaymentHistory::find()
                    ->where('booking_id = :b_id', [':b_id' => $b_id])
                    ->one();
                            
                   $booking_payment_histroy->payment_transaction_id = $_REQUEST['bank_txn'];
                   $booking_payment_histroy->payment_type = 'ATOM';
                   $booking_payment_histroy->response = serialize($_REQUEST);
                   $booking_payment_histroy->payment_status = 'Cancelled';
                   $booking_payment_histroy->save();

                    $param['subject']="Party Amimals Booking Cancelled";
                    $view="ordercancel";
                    $sendparam=array('mobile_no'=>$param['mobile_no'],'email'=>$param['email'],'club_name'=>$param['club_name'],'booking_date'=>$param['booking_date'],'booking_type'=>$param['booking_type'],'user_name'=>$param['user_name']);
                    $mailsend=$utilsobj->sendMessage($param['email'], $param['subject'], $view, $sendparam,'booking@partyanimals.in',"Party Amimals Booking");
                    return $this->render('thankyou',['is_error'=>'cancel','msg'=>'Party Amimals booking Cancelled']);
                }
                if($b_id > 1 && $f_code == 'F' ) {
                    
                    $bookingObj = \backend\models\ClubBooking::findOne( $b_id );
                    $bookingNames = $bookingObj->getBookedName();
                    $arr_booking_data['c_id'] = $bookingObj->club_id;
                    $arr_booking_data['b_type'] = $bookingObj->booking_category;
                    $arr_booking_data['txt_datepicker'] = date('d-m-Y',strtotime($bookingObj->booking_date));
                    $arr_booking_data['pnr'] = $bookingObj->pa_pnr;

                    if($bookingObj->booked_type == 1) {
                        $user_obj = \backend\models\GuestUser::findOne( $bookingObj->user_id );
                        $param['mobile_no']=$user_obj->mobile_no;
                        $param['email']=$user_obj->email_address;
                    } else {
                        $user_obj = \backend\models\User::findOne( $bookingObj->user_id );
                        $param['mobile_no']=$user_obj->email;
                        $param['email']=$user_obj->phone_no;
                    }

                    $param['user_name']= $bookingNames;

                    $clubObj=Club::findOne( $arr_booking_data['c_id']);
                    $param['club_name']= $clubObj->name ;
                    $param['booking_date']=$arr_booking_data['txt_datepicker'];

                    $param['booking_type'] = $array_b_type[strtolower($arr_booking_data['b_type'])];
                    $param['pnr']= $arr_booking_data['pnr'];
                    
                    $booking_payment_histroy = \backend\models\BookingPaymentHistory::find()
                    ->where('booking_id = :b_id', [':b_id' => $b_id])
                    ->one();
                            
                   $booking_payment_histroy->payment_transaction_id = $_REQUEST['bank_txn'];
                   $booking_payment_histroy->payment_type = 'ATOM';
                   $booking_payment_histroy->response = serialize($_REQUEST);
                   $booking_payment_histroy->payment_status = 'Failed';
                   $booking_payment_histroy->save();

                    $param['subject']="oops! some think went wrong";
                    $view="orderfail";
                    $sendparam=array('mobile_no'=>$param['mobile_no'],'email'=>$param['email'],'club_name'=>$param['club_name'],'booking_date'=>$param['booking_date'],'booking_type'=>$param['booking_type'],'user_name'=>$param['user_name']);
                    $mailsend=$utilsobj->sendMessage($param['email'], $param['subject'], $view, $sendparam,'booking@partyanimals.in',"Party Amimals Booking");
                    return $this->render('thankyou',['is_error'=>'fail','msg'=>'Party Amimals booking Fail','reference_id'=>$b_id]);
            }
        }
        else
        {
            return $this->render('thankyou',['is_error'=>'sys']);
        }
        }
    }

    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
                    'model' => $model,
        ]);
    }

    public function actionResetPassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

    public function actionAboutus() {
        return $this->render('aboutus');
    }

    public function actionHtw() {
        return $this->render('htw');
    }

    public function actionTermsandconditions() {
        return $this->render('termsandconditions');
    }

    public function actionPartnerwithus() {
        return $this->render('partnerwithus');
    }

    public function actionPrivacypolicy() {
        return $this->render('privacypolicy');
    }
}
