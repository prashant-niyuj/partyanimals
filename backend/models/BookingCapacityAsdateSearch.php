<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\BookingCapacityAsdate;

/**
 * BookingCapacityAsdateSearch represents the model behind the search form about `backend\models\BookingCapacityAsdate`.
 */
class BookingCapacityAsdateSearch extends BookingCapacityAsdate {

    /**
     * @inheritdoc
     */
    public $clubName;

    public function rules() {
        return [
            [['id', 'club_id', 'booking_capacity'], 'integer'],
            [['clubName', 'capacity_active_date', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = BookingCapacityAsdate::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith(['club'], true, 'INNER JOIN');
        $userinfo = \yii::$app->user->identity;


        if ($userinfo['role_id'] == 2) {
            $query->andWhere(['club_id' => $userinfo['club_id']]);
        }


        $dataProvider->sort->attributes['clubName'] = [
            'asc' => ['club.name' => SORT_ASC],
            'desc' => ['club.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'booking_capacity_asdate.id' => $this->id,
            'booking_capacity_asdate.club_id' => $this->club_id,
            'booking_capacity_asdate.booking_capacity' => $this->booking_capacity,
            'booking_capacity_asdate.capacity_active_date' => $this->capacity_active_date,
            // 'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        $query->andFilterWhere(['like', 'club.name', $this->clubName]);
        //echo $this->created_at;die;
        if ($this->created_at !== null && $this->created_at != "") {
            $date = strtotime($this->created_at);
            $query->andFilterWhere(['between', 'booking_capacity_asdate.created_at', $date, $date + 3600 * 24]);
        }


        return $dataProvider;
    }

}
