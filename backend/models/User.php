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

use dektrium\user\models\User as BaseUser;



use yii\helpers\ArrayHelper;


/**
 * User ActiveRecord model.
 *
 * @property bool    $isAdmin
 * @property bool    $isBlocked
 * @property bool    $isConfirmed
 *
 * Database fields:
 * @property integer $id
 * @property string  $username
 * @property string  $email
 * @property string  $unconfirmed_email
 * @property string  $password_hash
 * @property string  $auth_key
 * @property integer $registration_ip
 * @property integer $confirmed_at
 * @property integer $blocked_at
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $flags
 * @property  integer $club_id
 * @property integer $role_id
 * Defined relations:
 * @property Account[] $accounts
 * @property Profile   $profile
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class User extends BaseUser
{   
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        // add field to create and update scenarios
        $scenarios['create'] = array_merge($scenarios['create'], ['club_id']);
        $scenarios['update'] = array_merge($scenarios['update'], ['club_id']);
        
        $scenarios['create'] = array_merge($scenarios['create'], ['role_id']);
        $scenarios['update'] = array_merge($scenarios['update'], ['role_id']);

        
        $scenarios['create'] = array_merge($scenarios['create'], ['phone_no']);
        $scenarios['update'] = array_merge($scenarios['update'], ['phone_no']);

        return $scenarios;
    }
    public function rules()
    {
        $rules = parent::rules();
        // let's add some rules for field
        // suppose, it is required and have max length with 10 symbols:
        $rules['clubRequired'] = ['club_id', 'required'];
         $rules['clubSafe'] = ['club_id', 'safe'];
        $rules['clubLength']   = ['club_id', 'string', 'max' => 10];
        
        $rules['userroleRequired'] = ['role_id', 'required'];
        $rules['userroleLength']   = ['role_id', 'string', 'max' => 10];

        $rules['phoneNoRequired'] = ['phone_no', 'required'];
        
        $rules['phoneNoLength'] = ['phone_no', 'string', 'min'=>10,'max' => 10];
        $rules['phoneNoPattern'] = ['phone_no', 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'];
        
       // $rules['phoneNoLength']   = ['phone_no', 'string', 'max' => 10];

        return $rules;
    }
    public function attributeLabels()
    {
        return [
            'username'          => \Yii::t('user', 'Username'),
            'email'             => \Yii::t('user', 'Email'),
            'registration_ip'   => \Yii::t('user', 'Registration ip'),
            'unconfirmed_email' => \Yii::t('user', 'New email'),
            'password'          => \Yii::t('user', 'Password'),
            'created_at'        => \Yii::t('user', 'Registration time'),
            'confirmed_at'      => \Yii::t('user', 'Confirmation time'),
            'club_id'           => \Yii::t('user', 'Club'),
            'role_id'           => \Yii::t('user', 'User Role'),
            'phone_no'         =>\Yii::t('user', 'Phone No'),
        ];
    }
    public function getClubName()
    {
        $clubObj=  \backend\models\Club::find()->where(["id"=>$this->club_id])->asArray()->one();
        return $clubObj['name'];
        
    }
    public function getUserRoleName()
    {
        $roleObj= \backend\models\UserRole::find()->where(["id"=>$this->role_id])->asArray()->one();
        return $roleObj['role_name'];
        
    }
    public function getClubList()
    {
        $clubModels = \backend\models\Club::find()->asArray()->all();
        $clubArray = ArrayHelper::map($clubModels, 'id', 'name');
        
        return $clubArray;
        
    }
     public function getUserRoleList()
    {
        $roleModels = \backend\models\UserRole::find()->asArray()->all();
        $roleArray = ArrayHelper::map($roleModels, 'id', 'role_name');
        
        return $roleArray;
        
    }
    public function checkAllreadyOwner()
    {
        $db = \Yii::$app->db;
        $clublist = $db->createCommand('SELECT * from club where id not in (SELECT club_id from user where role_id=2)')
                    ->queryAll();
        return $clublist;
    }
}
