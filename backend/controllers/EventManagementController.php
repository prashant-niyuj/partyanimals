<?php

namespace backend\controllers;

use Yii;
use backend\models\EventManagement;
use backend\models\EventManagementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * EventManagementController implements the CRUD actions for EventManagement model.
 */
class EventManagementController extends Controller
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
     * Lists all EventManagement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventManagementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EventManagement model.
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
     * Creates a new EventManagement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EventManagement();
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
        $model->created_by= Yii::$app->user->getId();
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
     * Updates an existing EventManagement model.
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
     * Deletes an existing EventManagement model.
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
     * Finds the EventManagement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return EventManagement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EventManagement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
