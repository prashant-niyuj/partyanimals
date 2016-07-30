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


use dektrium\user\models\UserSearch as BaseUserSearch;
use yii\behaviors\TimestampBehavior;
use yii\log\Logger;
use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form about User.
 */
class UserSearch extends BaseUserSearch
{
    /** @var string */
    public $username;

    /** @var string */
    public $email;

    /** @var integer */
    public $created_at;

    /** @var string */
    public $registration_ip;

        /** @var string */
    public $club_id;

        /** @var string */
    public $role_id;

    
    
    /** @inheritdoc */
   public function rules()
    {
        $rules = parent::rules();
        // let's add some rules for field
        // suppose, it is required and have max length with 10 symbols:
       // $rules['clubRequired'] = ['club_id', 'required'];
         $rules['clubSafe'] = ['club_id', 'safe'];
        //$rules['clubLength']   = ['club_id', 'string', 'max' => 10];
        $rules['roleSafe'] = ['role_id', 'safe'];
       // $rules['userroleRequired'] = ['role_id', 'required'];
        //$rules['userroleLength']   = ['role_id', 'string', 'max' => 10];

        return $rules;
    }
    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        //$query = $this->finder->getUserQuery();
         $query = User::find();
        
        $userinfo=  \yii::$app->user->identity;  
       
       

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
         if($userinfo['role_id']==2)
        { 
            $query->andWhere(['club_id'=>$userinfo['club_id'],'role_id'=>array(2,3,5)]);
        }

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        
        if ($this->created_at !== null) {
            $date = strtotime($this->created_at);
            $query->andFilterWhere(['between', 'created_at', $date, $date + 3600 * 24]);
        }
        
        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['registration_ip' => $this->registration_ip])
           ->andFilterWhere(['club_id' => $this->club_id])
        ->andFilterWhere(['role_id' => $this->role_id]);

        return $dataProvider;
    }
}
