<?php

namespace backend\controllers;
use Yii;
use yii\helpers\ArrayHelper;
class ReportController extends \yii\web\Controller
{
    public function actionDailyReport()
    {
        //$booking_date=Yii::$app->request->get('booking_date');
        //$club_id=Yii::$app->request->get('c_id');
    
        
        $bookingobj=new \backend\models\ClubBookingSearch();
        $dataProvider=$bookingobj->getDailyBookingData(Yii::$app->request->queryParams); 
        $userinfo = \yii::$app->user->identity;
        //var_dump(Yii::$app->request);
        if($userinfo['role_id']==2)
        {
         $clubObj=  \backend\models\Club::find()->select("id,name")->where(['id'=>$userinfo['club_id']])->asArray()->all();
         
        }
        else
        {
            $clubObj=  \backend\models\Club::find()->select("id,name")->asArray()->all();
        }
        $clubArray=ArrayHelper::map($clubObj, 'id', 'name');
        $c_id=  Yii::$app->request->get('c_id');
        $booking_date=  Yii::$app->request->get('booking_date');
        
        if($userinfo['role_id']==2)
        {
             $c_id=$userinfo['club_id'];
        }
        if(!isset($booking_date))
        {
            $booking_date=date("Y-m-d");
        }
        
        
        return $this->render('/report/daliyreport',
            [
                'dataProvider'=>$dataProvider,
                'searchModel'=>$bookingobj,
                'clubArray'=>$clubArray,
                 'c_id'=>$c_id,
                 'booking_date'=>$booking_date,
                
                
            ]);
        
    }
    
    public function actionTotalBookingReport()
    {
        //$booking_date=Yii::$app->request->get('booking_date');
        //$club_id=Yii::$app->request->get('c_id');
    
        
        $bookingobj=new \backend\models\ClubBookingSearch();
        $dataProvider=$bookingobj->getTotalBookingData(Yii::$app->request->queryParams); 
        $userinfo = \yii::$app->user->identity;
        
       $userinfo = \yii::$app->user->identity;
        //var_dump(Yii::$app->request);
        if($userinfo['role_id']==2)
        {
            $clubObj=  \backend\models\Club::find()->select("id,name")->where(["id"=>$userinfo['club_id']])->asArray()->all();
        }else{
            $clubObj=  \backend\models\Club::find()->select("id,name")->asArray()->all();
        }
        $clubArray=ArrayHelper::map($clubObj, 'id', 'name');
        $c_id=  Yii::$app->request->get('c_id');
        $to_booking_date=  Yii::$app->request->get('to_booking_date');
        $from_booking_date=  Yii::$app->request->get('from_booking_date');
        
        if($userinfo['role_id']==2)
        {
             $c_id=$userinfo['club_id'];
        }
        if(!isset($to_booking_date))
        {
            $to_booking_date=date("Y-m-d");
        }
        
        if(!isset($from_booking_date))
        {
            $from_booking_date=date("Y-m-d");
        }
        
        return $this->render('/report/totalbookingreport',
            [
                'dataProvider'=>$dataProvider,
                'searchModel'=>$bookingobj,
                'clubArray'=>$clubArray,
                 'c_id'=>$c_id,
                 'to_booking_date'=>$to_booking_date,
                 'from_booking_date'=>$from_booking_date,
                
                
            ]);
        
    }

}
