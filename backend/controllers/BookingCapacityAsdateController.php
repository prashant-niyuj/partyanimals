<?php

namespace backend\controllers;

use Yii;
use backend\models\BookingCapacityAsdate;
use backend\models\BookingCapacityAsdateSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * BookingCapacityAsdateController implements the CRUD actions for BookingCapacityAsdate model.
 */
class BookingCapacityAsdateController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all BookingCapacityAsdate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BookingCapacityAsdateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
         $userinfo=  Yii::$app->user->identity;
         $clubName=  \backend\models\Club::findOne($userinfo['club_id']);
         
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'clubName'=>$clubName
        ]);
    }

    /**
     * Displays a single BookingCapacityAsdate model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new BookingCapacityAsdate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BookingCapacityAsdate();
        $model->created_at=date("Y-m-d H:i:s");
       $userinfo=  \yii::$app->user->identity;
       if($userinfo['role_id']==1)
        {
        $clubModels = \backend\models\Club::find()->asArray()->all();
        }else{
            
            $clubModels = \backend\models\Club::find()->asArray()->where(['id'=>$userinfo['club_id']])->all();
        }
        $clubArray = ArrayHelper::map($clubModels, 'id', 'name');
        $param['clubArray']=$clubArray;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'param'=>$param
            ]);
        }
    }

    /**
     * Updates an existing BookingCapacityAsdate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $userinfo=  \yii::$app->user->identity;
       if($userinfo['role_id']==1)
        {
        $clubModels = \backend\models\Club::find()->asArray()->all();
        }else{
            
            $clubModels = \backend\models\Club::find()->asArray()->where(['id'=>$userinfo['club_id']])->all();
        }
        $clubArray = ArrayHelper::map($clubModels, 'id', 'name');
        $param['clubArray']=$clubArray;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                 'param'=>$param
            ]);
        }
    }

    /**
     * Deletes an existing BookingCapacityAsdate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BookingCapacityAsdate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return BookingCapacityAsdate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BookingCapacityAsdate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
