<?php

namespace app\models;

use dektrium\user\models\Profile;
use dektrium\user\models\RegistrationForm as BaseRegistrationForm;
use dektrium\user\models\User;

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
          $rules[] = ['phone_no', 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'];
         $rules[] = ['phone_no', 'string', 'min'=>10,'max'=>10];
      
        
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
     * @inheritdoc
     */
    public function loadAttributes(User $user)
    {
        
        // here is the magic happens
        $user->setAttributes([
            'email'    => $this->email,
            'username' => $this->username,
            'password' => $this->password,
            'role_id' => 4,
        ]);
        /** @var Profile $profile */
        $profile = \Yii::createObject(Profile::className());
        $profile->setAttributes([
            'phone_no' => $this->phone_no,
        ]);
        $profile->setAttributes([
            'name' => $this->name,
        ]);
        
        $user->setProfile($profile);
        
    }
}
