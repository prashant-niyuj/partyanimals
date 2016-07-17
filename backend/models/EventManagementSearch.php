<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\EventManagement;

/**
 * EventManagementSearch represents the model behind the search form about `backend\models\EventManagement`.
 */
class EventManagementSearch extends EventManagement
{
    /**
     * @inheritdoc
     */
     public $clubName;
     
    public function rules()
    {
        return [
            [['id', 'club_id', 'created_by'], 'integer'],
            [['clubName','event_name', 'event_description', 'event_date', 'created_at', 'updated_at'], 'safe'],
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
        $query = EventManagement::find();
        
        $userinfo=  \yii::$app->user->identity; 
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith(['club'], true, 'INNER JOIN');
         if($userinfo['role_id']==2)
        { 
            $query->andWhere(['club_id'=>$userinfo['club_id']]);
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
            'event_date' => $this->event_date,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
         $query->andFilterWhere(['like', 'club.name', $this->clubName]);
        $query->andFilterWhere(['like', 'event_name', $this->event_name])
            ->andFilterWhere(['like', 'event_description', $this->event_description]);

        return $dataProvider;
    }
}
