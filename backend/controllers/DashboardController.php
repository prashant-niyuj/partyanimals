<?php

namespace backend\controllers;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class DashboardController extends \yii\web\Controller
{
    
    public function behaviors() {
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
    public function actionIndex()
    {
           $userinfo = \yii::$app->user->identity;
        if ($userinfo['role_id'] == 3) {
            $this->redirect(['club-booking-names/index']);
        } else if ($userinfo['role_id'] == 5) {
            $this->redirect(['club-booking/index']);
        }
        $bookingobj=new \backend\models\ClubBooking();
        $bookingdata=$bookingobj->getBookingData();
        $bookingtotal=$bookingobj->getBookingTotal();
        $todaybookingtotal=$bookingobj->getTodayBookingTotal();
        $totaluser=  \backend\models\User::find()->where(['role_id'=>4])->all();
       // var_dump(count($totaluser));die;
        return $this->render('index',['bookingdata'=>$bookingdata,'total'=>$bookingtotal[0]['total'],'todaybookingtotal'=>$todaybookingtotal[0]['total'],'totaluser'=>$totaluser]);
    }
    
    public function actionUserAction()
    {
        $userinfo = \yii::$app->user->identity;
        if ($userinfo['role_id'] == 3) {
            $this->redirect(['club-booking-names/index']);
        } else if ($userinfo['role_id'] == 5) {
            $this->redirect(['club-booking/index']);
        }else if ($userinfo['role_id'] ==1 || $userinfo['role_id'] ==2) {
            $this->redirect(['dashboard/index']);
        }
        
    }

}
