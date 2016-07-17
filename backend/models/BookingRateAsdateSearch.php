<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\BookingRateAsdate;

/**
 * BookingRateAsdateSearch represents the model behind the search form about `backend\models\BookingRateAsdate`.
 */
class BookingRateAsdateSearch extends BookingRateAsdate {

    /**
     * @inheritdoc
     */
    public $clubName;

    public function rules() {
        return [
            [['id', 'club_id', 'girl_rate', 'boy_rate', 'couple_rate'], 'integer'],
            [['clubName', 'rate_date', 'create_at', 'updated_at'], 'safe'],
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
        $query = BookingRateAsdate::find();

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
            'id' => $this->id,
            'club_id' => $this->club_id,
            'girl_rate' => $this->girl_rate,
            'boy_rate' => $this->boy_rate,
            'couple_rate' => $this->couple_rate,
            'rate_date' => $this->rate_date,
            'create_at' => $this->create_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'club.name', $this->clubName]);

        return $dataProvider;
    }

}
