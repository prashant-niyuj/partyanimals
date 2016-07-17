<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Club;

/**
 * ClubSearch represents the model behind the search form about `backend\models\Club`.
 */
class ClubSearch extends Club
{
    /**
     * @inheritdoc
     */
    public $cityName;
    public function rules()
    {
        return [
            [['id', 'club_capacity', 'booking_capacity', 'city_id', 'priority_range', 'bank_account_number', 'is_active'], 'integer'],
            [['cityName','name', 'address', 'logo', 'area', 'bank_name', 'bank_branch', 'ifsc_code', 'created_date', 'modified_date'], 'safe'],
            [['booking_rate_ladies', 'booking_rate_boy', 'booking_rate_couple'], 'number'],
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
        $query = Club::find();

        $userinfo=  \yii::$app->user->identity; 
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
         if($userinfo['role_id']==2)
        { 
            $query->andWhere(['club.id'=>$userinfo['club_id']]);
        }

        $this->load($params);
        $query->joinWith(['city'], true, 'INNER JOIN');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'club.id' => $this->id,
            'club_capacity' => $this->club_capacity,
            'booking_capacity' => $this->booking_capacity,
            'city_id' => $this->city_id,
            'priority_range' => $this->priority_range,
            'booking_rate_ladies' => $this->booking_rate_ladies,
            'booking_rate_boy' => $this->booking_rate_boy,
            'booking_rate_couple' => $this->booking_rate_couple,
            'bank_account_number' => $this->bank_account_number,
            'is_active' => $this->is_active,
            'created_date' => $this->created_date,
            'modified_date' => $this->modified_date,
        ]);

        $query->andFilterWhere(['like', 'club.name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'area', $this->area])
            ->andFilterWhere(['like', 'club_open_days', $this->club_open_days])
            ->andFilterWhere(['like', 'bank_name', $this->bank_name])
            ->andFilterWhere(['like', 'bank_branch', $this->bank_branch])
           ->andFilterWhere(['like', 'city.name', $this->cityName])
            ->andFilterWhere(['like', 'ifsc_code', $this->ifsc_code]);

        return $dataProvider;
    }
}
