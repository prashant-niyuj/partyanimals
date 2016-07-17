<?php

namespace backend\controllers\user;

use dektrium\user\controllers\SecurityController as BaseSecurityController;
use Yii;

class SecurityController extends BaseSecurityController
{
     /**
     * Displays the login page.
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            $this->goHome();
        }

        $model = \Yii::createObject(\backend\models\LoginForm::className());

        $this->performAjaxValidation($model);
   
        $formbooking=  \Yii::$app->request->get('formbooking');
       
        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
            if(isset($formbooking))
            {
                $this->redirect(['/site/confirm']);
            }else{
            return $this->goBack();
            }
        }

        return $this->render('login', [
            'model'  => $model,
            'module' => $this->module,
        ]);
    }

    /**
     * Logs the user out and then redirects to the homepage.
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->getUser()->logout();
        return $this->goHome();
    }
}