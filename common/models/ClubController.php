<?php

namespace backend\controllers;

use Yii;
use backend\models\Club;
use backend\models\ClubSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * ClubController implements the CRUD actions for Club model.
 */
class ClubController extends Controller
{
    public function behaviors()
    {
        return [
             'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                         'actions' => [],
                        'allow' => true,
                        'roles' => ['@'],
                     
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Club models.
     * @return mixed
     */
    public function actionIndex()
    {
         $userinfo=  \yii::$app->user->identity;
         
         $clubName=  \backend\models\Club::findOne($userinfo['club_id']);
         
       if($userinfo['role_id']==3)
        {
           $this->redirect(['club-booking/index']);
        }
        $searchModel = new ClubSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'clubName'=>$clubName
        ]);
    }

    /**
     * Displays a single Club model.
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
     * Creates a new Club model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Club();
        $model->created_date=date("Y-m-d H:i:s");
       //$model->modified_date=date("Y-m-d H:i:s");
        $cityList = \backend\models\City::find()->asArray()->orderBy("name asc")->all();
        $cityArray = ArrayHelper::map($cityList, 'id', 'name');
		$model->created_date=date("Y-m-d h:i:s");	
        if ($model->load(Yii::$app->request->post())) {
            $postparam=Yii::$app->request->post('club_open_days');
        //    var_dump($postparam);die;
            if(isset($postparam)){
           // echo "kkk";die;
            $opendays=  implode(",",$postparam);            
            $model->club_open_days=$opendays;
            }else{
                //echo "hh";die;
                $model->club_open_days="";
            }
            $utilsModel=new \common\models\Utils();
            $path = Yii::$app->params['uploadClubLogoPath'];
            $savelogo=$utilsModel->saveFileName($model, "logo", $path);
            
            $destinationPath = Yii::$app->params['uploadClubLogoResizePath']. $model->logo;//note: create new directory (resize) in uploads directory
            $utilsModel->resize($savelogo, $destinationWidth=175, $destinationHeight=125, $destinationPath);
            $model->save();
        
            
            return $this->redirect(['index', 'id' => $model->id]);
        } 
        else 
        {
            
            return $this->render('create', [
                'model' => $model,
				'cityArray'=>$cityArray,
            ]);
        }
    }

    /**
     * Updates an existing Club model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $cityList = \backend\models\City::find()->asArray()->orderBy("name asc")->all();
        $cityArray = ArrayHelper::map($cityList, 'id', 'name');
        
        if ($model->load(Yii::$app->request->post())) {
            $postparam=Yii::$app->request->post('club_open_days');
        //    var_dump($postparam);die;
            if(isset($postparam)){
           // echo "kkk";die;
            $opendays=  implode(",",$postparam);            
            $model->club_open_days=$opendays;
            }else{
                //echo "hh";die;
                $model->club_open_days="";
            }
            $utilsModel=new \common\models\Utils();
            $path = Yii::$app->params['uploadClubLogoPath'];
            $savelogo=$utilsModel->saveFileName($model, "logo", $path);
            if($savelogo)
            {
            $destinationPath = Yii::$app->params['uploadClubLogoResizePath']. $model->logo;//note: create new directory (resize) in uploads directory
            $utilsModel->resize($savelogo, $destinationWidth=175, $destinationHeight=125, $destinationPath);
            }else{
                unset($model->logo);
            }
            $model->save();
            
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
				'cityArray'=>$cityArray,
            ]);
        }
    }

    /**
     * Deletes an existing Club model.
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
     * Finds the Club model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Club the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Club::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
