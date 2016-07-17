<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ClubBookingNames;

/**
 * ClubBookingNamesSearch represents the model behind the search form about `backend\models\ClubBookingNames`.
 */
class ClubBookingNamesSearch extends ClubBookingNames
{
    /**
     * @inheritdoc
     */
    public $booking_no;
    public $booking_category;
   
    
    public function rules()
    {
        return [
            [['id', 'club_booking_id', 'is_in'], 'integer'],
            [['booking_no','booking_category','booking_name', 'mobile_no', 'created_at', 'updated_at'], 'safe'],
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
        $query = ClubBookingNames::find()->select("club_booking_names.id,club_booking_names.club_booking_id,club_booking.booking_category,club_booking.pa_pnr as booking_no,club_booking.booking_date,club_booking_names.booking_name,club_booking_names.mobile_no,club_booking_names.is_in")->asArray();
        $userinfo=  \yii::$app->user->identity;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array('pageSize' => 10),
        ]);
       //var_dump($userinfo);die;

        $query->joinWith(['clubBooking'], true, 'INNER JOIN');
     if($userinfo['role_id']==3)
       {
             $query->andFilterWhere(['like', 'club_booking.booking_date',date("Y-m-d")]);
        $query->andFilterWhere([           
            'club_booking.club_id' => $userinfo['club_id'],        
        ]);
       }
       if($userinfo['role_id']==2)
       {
         
        $query->andFilterWhere([           
            'club_booking.club_id' => $userinfo['club_id'],        
        ]);
       }
       
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'club_booking_id' => $this->club_booking_id,
            'is_in' => $this->is_in,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
     
       
        $query->andFilterWhere(['like', 'club_booking.pa_pnr', $this->booking_no]);
       $query->andFilterWhere(['like', 'club_booking.booking_category', $this->booking_category]);
        $query->andFilterWhere(['like', 'booking_name', $this->booking_name])
            ->andFilterWhere(['like', 'mobile_no', $this->mobile_no]);
       
       
       $query->orderBy(" club_booking_id desc, is_in asc,club_booking.booking_date desc");
    // var_dump($query);die;
        return $dataProvider;
    }
   
}
