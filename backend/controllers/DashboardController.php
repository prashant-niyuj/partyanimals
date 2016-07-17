<?php

namespace backend\controllers;

class DashboardController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $bookingobj=new \backend\models\ClubBooking();
        $bookingdata=$bookingobj->getBookingData();
        $bookingtotal=$bookingobj->getBookingTotal();
        $todaybookingtotal=$bookingobj->getTodayBookingTotal();
        $totaluser=  \backend\models\User::find()->where(['role_id'=>4])->all();
       // var_dump(count($totaluser));die;
        return $this->render('index',['bookingdata'=>$bookingdata,'total'=>$bookingtotal[0]['total'],'todaybookingtotal'=>$todaybookingtotal[0]['total'],'totaluser'=>$totaluser]);
    }

}
