<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\EventBooking;

/**
 * EventBookingSearch represents the model behind the search form about `backend\models\EventBooking`.
 */
class EventBookingSearch extends EventBooking
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'no_ticket', 'is_confrm'], 'integer'],
            [['name', 'email', 'mobile', 'total_amount', 'pnr', 'ip', 'payment_id', 'payment_responce', 'created_date'], 'safe'],
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
        $query = EventBooking::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'no_ticket' => $this->no_ticket,
            'is_confrm' => $this->is_confrm,
            'created_date' => $this->created_date,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'total_amount', $this->total_amount])
            ->andFilterWhere(['like', 'pnr', $this->pnr])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'payment_id', $this->payment_id])
            ->andFilterWhere(['like', 'payment_responce', $this->payment_responce]);

        return $dataProvider;
    }
}
