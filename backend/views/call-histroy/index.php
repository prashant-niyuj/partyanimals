<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\CallHistroy;
use backend\models\CallHistroySearch;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CallHistroySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'view your call logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="call-histroy-index">
	<h4>This numbers log are avalaible<h4>
	<?php 
			foreach(CallHistroySearch::getAllDistinct() as $value)
			{
				//print_r($value);
				echo "&nbsp;&nbsp;&nbsp;<a href='index.php?CallHistroySearch[self]={$value['self']}&r=call-histroy'>".$value['self']."</a>";
			}
	?>	
    
	<h3>Currently view logs for 9011041990</h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<style>
	.miss_call {
		background-color:#C7A7A7;
	}
	.dial_call {
		background-color:#A0C1BC!important;
	}
	.rec_call {
		background-color:#fff;
	}
    </style>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		 'rowOptions' => function ($model, $index, $widget, $grid){
			  if($model->c_type == 'm'){
				return ['class' => 'miss_call'];
			  } if($model->c_type == 'd'){ 
				return ['class' => 'dial_call'];
			  } else {
				return ['class' => 'rec_call'];
			  }
			},
        'columns' => [
			[
            'attribute' => 'incoming',
            'label' => 'Incoming',
            'format' => 'raw',  
            'value' => function($model) {
				if($model->name != 'null')
                return $model->name."<br>".$model->incoming;
				else
				 return $model->incoming;
            },
			],
            'created_time',
             ['class' => 'yii\grid\ActionColumn',
					'template' => '{update}',
					'header' => '<div id="actionColumnheader"></div>',
					'buttons' => [
					'update' => function ($url, $model) {
					return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
								'title' => Yii::t('app', 'View'),
					]);
					},
					],
					'urlCreator' => function ($action, $model, $key, $index) {
					$self = $model->self;
					$incoming = $model->incoming;
					if ($action === 'update') {
						$url = Yii::$app->urlManager->createUrl(['call-histroy/view', 'incoming' => $incoming, 'self' => $self, 'id' => $key]); // your own url generation logic
						return $url;
						}
					} 
			 ],
			 ['class' => 'yii\grid\ActionColumn',
					'template' => '{google}',
					'header' => '<div id="actionColumnheader"></div>',
					'buttons' => [
					'google' => function ($url, $model) {
					return Html::a('<span class="glyphicon glyphicon-menu-up1">G</span>', "https://www.google.co.in/#q=".str_replace(' ','',str_replace('91','',$model->incoming)), [
								'title' => Yii::t('app', 'Google'),
								'target'=>'_blank',
					])."&nbsp;&nbsp;".Html::a('<span class="glyphicon glyphicon-menu-up1">F</span>', "https://www.facebook.com/search/str/".str_replace(' ','',str_replace('91','',$model->incoming))."/keywords_top", [
								'title' => Yii::t('app', 'Facebook'),
								'target'=>'_blank',
					])."&nbsp;&nbsp;".Html::a('<span class="glyphicon glyphicon-menu-up1">T</span>',"https://www.truecaller.com/in/".str_replace(' ','',str_replace('91','',$model->incoming)), [
								'title' => Yii::t('app', 'True Caller'),
								'target'=>'_blank',
					]);
					},
					],
					
			],
			
]  ,                               
    ]); ?>

</div>
