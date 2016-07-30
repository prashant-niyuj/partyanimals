<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ClubBooking;

/**
 * ClubBookingSearch represents the model behind the search form about `backend\models\ClubBooking`.
 */
class ClubBookingSearch extends ClubBooking
{
    /**
     * @inheritdoc
     */
    public $clubName;
    public $bookedName;
    public $booking_total;
    public function rules()
    {
        return [
            [['id', 'club_id','booked_type', 'user_id', 'price_of_girl', 'price_of_stage', 'price_of_couple', 'no_of_girls', 'no_of_boys', 'commission_rate', 'convenience_fee', 'in_confirm'], 'integer'],
            [['pa_pnr','clubName','bookedName', 'booking_category','booking_total', 'commission', 'booking_date', 'created_at', 'updated_at'], 'safe'],
            [['tax_rate', 'total_price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ClubBooking::find()->orderBy("updated_at desc");
         $userinfo=  \yii::$app->user->identity;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->joinWith(['club'], true, 'INNER JOIN');
        
       // $query->join('INNER JOIN','user','user.id=club_booking.user_id');
        //$query->join('INNER JOIN','booking_as_guest','booking_as_guest.id=club_booking.user_id');
        $dataProvider->sort->attributes['clubName'] = [
                  'asc' => ['club.name' => SORT_ASC],
                  'desc' => ['club.name' => SORT_DESC],
              ];
  /*$dataProvider->sort->attributes['bookedName'] = [
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];
  */
     if($userinfo['role_id']==2)
       {
         
        $query->andFilterWhere([           
            'club_booking.club_id' => $userinfo['club_id'],        
        ]);
       };
       
     if($userinfo['role_id']==5)
     {
         
        $query->andFilterWhere([           
            'club_booking.club_id' => $userinfo['club_id'],  
            'club_booking.user_id' => $userinfo['id'],  
        ]);
       };
       
   

        $this->load($params);

        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'club.name', $this->clubName]);
        
        $query->andFilterWhere([
            'id' => $this->id,
            'club_id' => $this->club_id,
            'booked_type' => $this->booked_type,
            'user_id' => $this->user_id,
            'price_of_girl' => $this->price_of_girl,
            'price_of_stage' => $this->price_of_stage,
            'price_of_couple' => $this->price_of_couple,
            'no_of_girls' => $this->no_of_girls,
            'no_of_boys' => $this->no_of_boys,
            'tax_rate' => $this->tax_rate,
            'commission_rate' => $this->commission_rate,
            'convenience_fee' => $this->convenience_fee,
            'total_price' => $this->total_price,
            'booking_date' => $this->booking_date,
            'in_confirm' => $this->in_confirm,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            
        ]);

        $query->andFilterWhere(['like', 'pa_pnr', $this->pa_pnr]);
        
  //   $query->andFilterWhere(['or',['like', 'user.username', $this->bookedName],['like', 'booking_as_guest.name', $this->bookedName]])
             
            $query->andFilterWhere(['like', 'booking_category', $this->booking_category])
            ->andFilterWhere(['like', 'commission', $this->commission]);

        return $dataProvider;
    }
    public function getDailyBookingData($param)
    {
        
        $userinfo = \yii::$app->user->identity;
        $connection=  \Yii::$app->db;
        if(!isset($param['booking_date']))
        {
            $param['booking_date']=date("Y-m-d");
        }
         
        if(!isset($param['c_id']))
        {
            $param['c_id']="";
        }
       
       if($userinfo['role_id']==2)
       {
            $param['c_id']=$userinfo['club_id'];
       }
        
        //$bookingData=$connection->createCommand("select * from club_booking as cb where club_id='".$club_id."' and booking_date='".$booking_date."'")->queryAll();
        $query = ClubBooking::find()->where(["booking_date"=>$param['booking_date'],'club_id' => $param['c_id']]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
  
    
     
        $this->load($param);
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'id' => $this->id,
            'booked_type' => $this->booked_type,
            'user_id' => $this->user_id,
            'price_of_girl' => $this->price_of_girl,
            'price_of_stage' => $this->price_of_stage,
            'price_of_couple' => $this->price_of_couple,
            'no_of_girls' => $this->no_of_girls,
            'no_of_boys' => $this->no_of_boys,
            'tax_rate' => $this->tax_rate,
            'commission_rate' => $this->commission_rate,
            'convenience_fee' => $this->convenience_fee,
            'total_price' => $this->total_price,
            'in_confirm' => $this->in_confirm,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            
        ]);

        $query->andFilterWhere(['like', 'pa_pnr', $this->pa_pnr]);
        
  //   $query->andFilterWhere(['or',['like', 'user.username', $this->bookedName],['like', 'booking_as_guest.name', $this->bookedName]])
             
            $query->andFilterWhere(['like', 'booking_category', $this->booking_category])
            ->andFilterWhere(['like', 'commission', $this->commission]);

        return $dataProvider;
  
        
        
    }
    
    public function getTotalBookingData($param)
    {
        
        
        $userinfo = \yii::$app->user->identity;
        $connection=  \Yii::$app->db;
       
        if(!isset($param['c_id']))
        {
            $param['c_id']="";
          
            
        }
        if(!isset($param['from_booking_date']))
        {
            $param['from_booking_date']=date("Y-m-d");
        }
        if(!isset($param['to_booking_date']))
        {
            $param['to_booking_date']=date("Y-m-d");
        }
       
        if($userinfo['role_id']==2)
        {
             $param['c_id']=$userinfo['club_id'];
        }
        
        $query=new  \yii\db\Query();
        $query->select("booking_date,count(*) as booking_total,club_id")
             ->from("club_booking")
             ->where(['club_id' => $param['c_id']])
             ->andWhere(['between', 'booking_date',$param['from_booking_date'],$param['to_booking_date'] ]);
       
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
  
    
     
        $this->load($param);
        
        if (!$this->validate()) {
          
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'id' => $this->id,
            'booked_type' => $this->booked_type,
            'user_id' => $this->user_id,
            'price_of_girl' => $this->price_of_girl,
            'price_of_stage' => $this->price_of_stage,
            'price_of_couple' => $this->price_of_couple,
            'no_of_girls' => $this->no_of_girls,
            'no_of_boys' => $this->no_of_boys,
            'tax_rate' => $this->tax_rate,
            'commission_rate' => $this->commission_rate,
            'convenience_fee' => $this->convenience_fee,
            'total_price' => $this->total_price,
            'in_confirm' => $this->in_confirm,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            
        ]);
       
     /*  if(isset($param['from_booking_date']) && isset($param['to_booking_date']))
       {
            $query->andFilterWhere(['between', 'booking_date',$param['from_booking_date'],$param['to_booking_date'] ]);
       }*/
        $query->andFilterWhere(['like', 'pa_pnr', $this->pa_pnr]);
        
  //   $query->andFilterWhere(['or',['like', 'user.username', $this->bookedName],['like', 'booking_as_guest.name', $this->bookedName]])
             
            $query->andFilterWhere(['like', 'booking_category', $this->booking_category])
            ->andFilterWhere(['like', 'commission', $this->commission]);
            
        $query->groupBy("booking_date");    

        return $dataProvider;
  
        
        
    }
}
