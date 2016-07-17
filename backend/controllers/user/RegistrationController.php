<?php

namespace backend\controllers\user;

use dektrium\user\controllers\RegistrationController as BaseRegistrationController;
use Yii;

class RegistrationController extends BaseRegistrationController
{
    
    
    /**
     * Displays the registration page.
     * After successful registration if enableConfirmation is enabled shows info message otherwise redirects to home page.
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionRegister()
    {
        
        
        if (!$this->module->enableRegistration) {
            throw new NotFoundHttpException();
        }

        /** @var RegistrationForm $model */
        $model = Yii::createObject(\backend\models\RegistrationForm::className());

        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            
              $formbooking=  \Yii::$app->request->get('formbooking');
            // \Yii::$app->user->login($model);
            
        }
        
        if(isset($formbooking))
                {
                    \backend\models\User::updateAll(['role_id'=>4], ["id"=>  \yii::$app->user->id]);
                    $this->redirect(['/site/confirm']);
                }

        return $this->render('register', [
            'model'  => $model,
            'module' => $this->module,
        ]);
        
        
        
    }

    
}
