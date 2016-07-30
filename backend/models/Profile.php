<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace backend\models;


use dektrium\user\models\Profile as BaseProfile;
use yii;
/**
 * This is the model class for table "profile".
 *
 * @property integer $user_id
 * @property string  $name
 * @property string  $public_email
 * @property string  $gravatar_email
 * @property string  $gravatar_id
 * @property string  $location
 * @property string  $website
 * @property string  $bio
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com
 */
class Profile extends BaseProfile
{
    
    /** @inheritdoc */
    //public $name;
    //public $phone_no;
    
    public static function tableName()
    {
        return '{{%profile}}';
    }

    /**
     * @inheritdoc
     */
    
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        // add field to create and update scenarios
       // $scenarios['create'] = array_merge($scenarios['create'], ['phone_no']);
       // $scenarios['update'] = array_merge($scenarios['update'], ['phone_no']);
      
        return $scenarios;
    }
    
    public function rules()
    {
        $rules = parent::rules();
        // let's add some rules for field
        // suppose, it is required and have max length with 10 symbols:
      //  $rules['phonenoRequired'] = ['club_id', 'required'];
      //   $rules['phonenoSafe'] = ['phone_no', 'safe'];
      //  $rules['phonenoLength']   = ['phone_no', 'string'];
        return $rules;
    }

   

    /** @inheritdoc */
    public function beforeSave($insert)
    {
        
       $request=Yii::$app->request->post('register-form');
       $this->setAttribute('user_image', $this->user_image);
       if(!isset($request))
       {
           $request=Yii::$app->request->post('User');
           if(isset($request))
           {
               if(isset($request['phone_no']))
                    $this->setAttribute('phone_no',$request['phone_no']);
           }
       }else
       {
            $this->setAttribute('phone_no',$request['phone_no']);
             $this->setAttribute('name',$request['name']);
       }
        if (parent::beforeSave($insert)) {
            if ($this->isAttributeChanged('gravatar_email')) {
                $this->setAttribute('gravatar_id', md5(strtolower($this->getAttribute('gravatar_email'))));
            }
            
            return true;
        }

        return false;
    }

    /**
     * @return \yii\db\ActiveQueryInterface
     */
    public function getUser()
    {
        return $this->hasOne($this->module->modelMap['User'], ['id' => 'user_id']);
    }
}
