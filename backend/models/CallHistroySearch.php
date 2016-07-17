<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CallHistroy;

/**
 * CallHistroySearch represents the model behind the search form about `backend\models\CallHistroy`.
 */
class CallHistroySearch extends CallHistroy
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['self', 'incoming', 'name', 'created_time'], 'safe'],
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
        $query = CallHistroy::find()->orderBy([
	       'id'=>SORT_DESC
		]);
		
		//print_r($query);
		//die;
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
		
		
		
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'self', $this->self])
            ->andFilterWhere(['like', 'incoming', $this->incoming])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
	 public static function getAllDistinct()
    {
		$connection = \Yii::$app->db;
		$model = $connection->createCommand("SELECT distinct (self) FROM `call_histroy` WHERE self <> 'null' and self <> 'yii'");
		$arr_result = $model->queryAll();
		$arr_city = array();
		$return_array = $arr_result;
		if(count($return_array) > 0) {
			return $return_array;
		}
		else
			return 1;
	}	
	
}
