<?php

namespace backend\models;

use dektrium\user\models\RegistrationForm as BaseRegistrationForm;
use yii;


class RegistrationForm extends BaseRegistrationForm
{
    /**
     * Add a new field
     * @var string
     */
    public $name;

    public $phone_no;
    
    public $role_id;
    
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['name', 'required'];
        $rules[] = ['role_id', 'safe'];
        $rules[] = ['name', 'string', 'max' => 255];
        $rules[] = ['phone_no', 'required'];
         $rules[] = ['phone_no', 'number', 'min'=>10];
        $rules[] = ['phone_no', 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'];
        
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['name'] = \Yii::t('user', 'Name');
        $labels['phone_no'] = \Yii::t('user', 'Phone No');
        return $labels;
    }

    /**
     * Registers a new user account. If registration was successful it will set flash message.
     *
     * @return bool
     */
    public function register($formbooking=0)
    {
       
        if (!$this->validate()) {
            return false;
        }

        /** @var User $user */
        $user = Yii::createObject(User::className());
        $user->setScenario('register');
        $this->loadAttributes($user);
       
     
        if (!$user->register($formbooking)) {
            return false;
        }
        $usermodel=  User::find()->where(['email'=>$this->email])->one();
       Yii::$app->user->login($usermodel, "1209600");        

       

        return true;
    }

    /**
     * Loads attributes to the user model. You should override this method if you are going to add new fields to the
     * registration form. You can read more in special guide.
     *
     * By default this method set all attributes of this model to the attributes of User model, so you should properly
     * configure safe attributes of your User model.
     *
     * @param User $user
     */
    protected function loadAttributes(User $user)
    {
        $user->setAttributes($this->attributes);
    }
}
