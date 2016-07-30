<?php

namespace backend\controllers;

use Yii;
use backend\models\ClubBookingNames;
use backend\models\ClubBookingNamesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClubBookingNamesController implements the CRUD actions for ClubBookingNames model.
 */
class ClubBookingNamesController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all ClubBookingNames models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ClubBookingNamesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $userinfo = Yii::$app->user->identity;
        // var_dump($dataProvider->query);die;
        $models = $dataProvider->getModels();
        $bookinginfo = \backend\models\BookingCapacityAsdate::find()->select("booking_capacity,no_of_booking,is_full")->where(['club_id' => $userinfo['club_id'], 'capacity_active_date' => date('Y-m-d')])->asArray()->one();
        $noofentry = ClubBookingNames::find()->select("*")->leftJoin("club_booking", 'club_booking.id=club_booking_names.club_booking_id')->andFilterWhere(['club_id' => $userinfo['club_id']])->andFilterWhere(['is_in' => '1'])->andFilterWhere(['like', 'booking_date', date("Y-m-d")])->all();
        
      
        $clubName=  \backend\models\Club::findOne($userinfo['club_id']);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'models' => $models,
                    'bookinginfo' => $bookinginfo,
                    'noofentry' => count($noofentry),
                    'club_id' => $userinfo['club_id'],
                    'clubName'=>$clubName
        ]);
    }

    /**
     * Displays a single ClubBookingNames model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ClubBookingNames model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ClubBookingNames();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ClubBookingNames model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
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
     * Deletes an existing ClubBookingNames model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ClubBookingNames model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ClubBookingNames the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ClubBookingNames::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSetentry() {

        $id = \Yii::$app->request->get("record_id");
        $booking_category = \Yii::$app->request->get("booking_category");
        $club_booking_id = \Yii::$app->request->get("club_booking_id");
        $all_entry = \Yii::$app->request->get("all_entry");
        $connection = \Yii::$app->db;
        if (isset($id)) 
        {
            $clubbookingnamesObj = ClubBookingNames::findOne($id);
            if($clubbookingnamesObj)
            $param['mobile_no'] = $clubbookingnamesObj->mobile_no;
        }
        
          if($booking_category=="Couple" || ($booking_category=="Group" && $all_entry=="1"))
          {
          $command = $connection->createCommand(
          'UPDATE club_booking_names as cn SET is_in=1 WHERE club_booking_id='.$club_booking_id);
          }else{
          $command = $connection->createCommand(
          'UPDATE club_booking_names SET is_in=1 WHERE id='.$id);

          }

          $command->execute(); 

        //send mail and sms to user
        $subject = "Entry Confirm";
        $clubookingObj = \backend\models\ClubBooking::findOne($club_booking_id);
        if ($clubookingObj->booked_type == 1) 
        {
            $userinfo = \backend\models\GuestUser::findOne($clubookingObj->user_id);
            $param['email'] = $userinfo->email_address;
            
            //$param['mobile_no']=$userinfo->mobile_no;
        } 
        else 
        {
            $userinfo = \backend\models\Profile::findOne($clubookingObj->user_id);
            $param['email'] = $userinfo->gravatar_email;
            //$param['mobile_no']=$userinfo->phone_no;
        }

        $param['subject'] = $subject;
        $clubObj = \backend\models\Club::findOne($clubookingObj->club_id);
        $param['club_name'] = $clubObj->name;
        $param['pnr'] = $clubookingObj->pa_pnr;
        $param['booking_date'] = $clubookingObj->booking_date;
        $param['booking_type'] = $clubookingObj->booking_category;
        $view = "entryconfirm";
        $utilsobj = new \common\models\Utils;
        $sendparam = array('mobile_no' => $param['mobile_no'], 'email' => $param['email'], 'club_name' => $param['club_name'], 'booking_date' => $param['booking_date'], 'pnr' => $param['pnr'], 'booking_type' => $param['booking_type']);
        if($param['email']!="" && $param['email']!=NULL)
        {
            $mailsend = $utilsobj->sendMessage($param['email'], $param['subject'], $view, $sendparam);
        }

       
        if (isset($all_entry)) {
         
            if($all_entry==1)
            {
                $clubbookingnamesArray = ClubBookingNames::find()->where(['club_booking_id' => $club_booking_id])->asArray()->all();
                foreach ($clubbookingnamesArray as $cb) {
                    $sendparam = array('mobile_no' => $cb['mobile_no'], 'email' => $param['email'], 'club_name' => $param['club_name'], 'booking_date' => $param['booking_date'], 'pnr' => $param['pnr'], 'booking_type' => $param['booking_type']);
                    $view = "sms/entryconfirm";
                    if (isset($cb['mobile_no'])) {
                        $sendsms = $utilsobj->sendSMS($cb['mobile_no'], $param['subject'], $view, $sendparam);
                    }
                }
            }else{
                
                 if (isset($param['mobile_no'])) 
                 {
                    $view = "sms/entryconfirm";
                    $sendsms = $utilsobj->sendSMS($param['mobile_no'], $param['subject'], $view, $sendparam);
                 }
            }
        }else{
            
             if (isset($param['mobile_no'])) {
            $view = "sms/entryconfirm";
            $sendsms = $utilsobj->sendSMS($param['mobile_no'], $param['subject'], $view, $sendparam);
        }
            
        }

        Yii::$app->session->setFlash("success","successfully confirm entry.");
        $this->redirect(["index"]);
    }

    public function actionFullclub() {
        
        $id = \Yii::$app->request->get("club_id");

        $connection = \Yii::$app->db;
        $command = $connection->createCommand(
                'UPDATE booking_capacity_asdate SET is_full=1 WHERE club_id=' . $id . " and capacity_active_date='" . date("Y-m-d") . "'");
        $command->execute();
        $getclubowner=  \backend\models\User::find()->where(['club_id'=>$id,'role_id'=>2])->one();
        $clubObj=  \backend\models\Club::findOne($id);
        if(count($clubObj))
        $param['club_name']=$clubObj->name;
        
        $gatekeeperinfo=  \yii::$app->user->identity;
        
        if(count($getclubowner))
        {  
           
            $getclubOwnerProfile=  \backend\models\Profile::find()->where(['user_id'=>$getclubowner->id])->asArray()->one();
           // var_dump($getclubOwnerProfile);die;
            if(count($getclubOwnerProfile))
            {
                $utilsobj = new \common\models\Utils;
                $sendparam = array('ownername'=>$getclubowner->username,'club_name' => $param['club_name'], 'booking_date' => date("Y-m-d"),'gatekeepername'=>$gatekeeperinfo['username']);
                $view='fullclub';
                $subject="Full Club";           
                $mailsend = $utilsobj->sendMessage($getclubowner->email, $subject, $view, $sendparam);
                
                if($mailsend)
                {
                    echo "Mail send successfully";
                }else{
                    echo "Issue in sending mail";
                }
            }
        }else{
            echo "no club owner";
        }
       
        
         Yii::$app->session->setFlash("success","Club full successfully.");
         $this->redirect(["index"]);

        
    }

}
