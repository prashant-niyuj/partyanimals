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
class ClubController extends Controller {

    public function behaviors() {
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
    public function actionIndex() {
        $userinfo = \yii::$app->user->identity;

        $clubName = \backend\models\Club::findOne($userinfo['club_id']);

        $searchModel = new ClubSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'clubName' => $clubName
        ]);
    }

    /**
     * Displays a single Club model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Club model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Club();
        $model->created_date = date("Y-m-d H:i:s");
        //$model->modified_date=date("Y-m-d H:i:s");
        $cityList = \backend\models\City::find()->asArray()->orderBy("name asc")->all();
        $cityArray = ArrayHelper::map($cityList, 'id', 'name');
        $model->created_date = date("Y-m-d h:i:s");
        if ($model->load(Yii::$app->request->post())) {
            $postparam = Yii::$app->request->post('club_open_days');

            if (isset($postparam)) {
                // echo "kkk";die;
                $opendays = implode(",", $postparam);
                $model->club_open_days = $opendays;
            } else {
                //echo "hh";die;
                $model->club_open_days = "";
            }
            $utilsModel = new \common\models\Utils();
            $path = Yii::$app->params['uploadClubLogoPath'];
            $savelogo = $utilsModel->saveFileName($model, "logo", $path);
            if($savelogo)
            {
            $destinationPath = Yii::$app->params['uploadClubLogoResizePath'] . $model->logo; //note: create new directory (resize) in uploads directory
            $utilsModel->resize($savelogo, $destinationWidth = 200, $destinationHeight = 170, $destinationPath);
            }
            if ($model->save()) {
                return $this->redirect(['update', 'id' => $model->id]);
            }
            
              return $this->render('create', [
                        'model' => $model,
                        'cityArray' => $cityArray,
            ]);
        } else {

            return $this->render('create', [
                        'model' => $model,
                        'cityArray' => $cityArray,
            ]);
        }
    }

    /**
     * Updates an existing Club model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $cityList = \backend\models\City::find()->asArray()->orderBy("name asc")->all();
        $cityArray = ArrayHelper::map($cityList, 'id', 'name');
        $tab = Yii::$app->request->get('tab');
        $directory = \Yii::getAlias('@frontend/web/club_gallery/') . DIRECTORY_SEPARATOR . $model->name . DIRECTORY_SEPARATOR;
        if (!is_dir($directory)) {
            mkdir($directory,0777,true);
        }
        $galleryPath=\Yii::getAlias('@frontend/web/club_gallery/'.$model->name);
        
        $galleryFiles=$this->read_all_files($galleryPath);
     //  var_dump(Yii::$app->request->post());die;
        if ($model->load(Yii::$app->request->post())) {
          
            $postparam = Yii::$app->request->post('club_open_days');
            //    var_dump($postparam);die;
            if (isset($postparam)) {
                // echo "kkk";die;
                $opendays = implode(",", $postparam);
                $model->club_open_days = $opendays;
            } else {
                //echo "hh";die;
                $model->club_open_days = "";
            }
            $utilsModel = new \common\models\Utils();
            $path = Yii::$app->params['uploadClubLogoPath'];
            $savelogo = $utilsModel->saveFileName($model, "logo", $path);
            if ($savelogo) {
                $destinationPath = Yii::$app->params['uploadClubLogoResizePath'] . $model->logo; //note: create new directory (resize) in uploads directory
                $utilsModel->resize($savelogo, $destinationWidth = 200, $destinationHeight = 170, $destinationPath);
            } else {
                unset($model->logo);
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'successfully saved.');
                return $this->redirect(['update',"id"=>$model->id]);
            }else {
            return $this->render('update', [
                        'model' => $model,
                        'cityArray' => $cityArray,
                        'galleryFiles'=>$galleryFiles,
                        'tab'=>$tab
            ]);
        }
            
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'cityArray' => $cityArray,
                        'galleryFiles'=>$galleryFiles,
                        'tab'=>$tab
            ]);
        }
    }

    /**
     * Deletes an existing Club model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
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
    protected function findModel($id) {
        if (($model = Club::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionImageUpload() {
        
        $imageFile = \yii\web\UploadedFile::getInstanceByName('Club[logo]');
        $name=  Yii::$app->request->get("name");
        //var_dump($name);die;
        $directory = \Yii::getAlias('@frontend/web/club_gallery/') . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR;
        if (!is_dir($directory)) {
            mkdir($directory,0777,true);
        }
        //var_dump($imageFile);
        if ($imageFile) {
            $uid = uniqid(time(), true);
            $fileName = $uid . '.' . $imageFile->extension;
            $filePath = $directory . $fileName;
            
            
            
            if ($imageFile->saveAs($filePath)) 
            {
                $utilsModel = new \common\models\Utils();
                $destinationPath = $directory."resize".DIRECTORY_SEPARATOR;
                 if (!is_dir($destinationPath)) {
                            mkdir($destinationPath,0777,true);
                }
                 $destinationPath = $directory."resize".DIRECTORY_SEPARATOR . $fileName; 
                //note: create new directory (resize) in uploads directory
                $utilsModel->resize($filePath, $destinationWidth = 100, $destinationHeight = 100, $destinationPath);
                
                $path = "../../frontend/web/club_gallery/" . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . $fileName;
                return \yii\helpers\Json::encode([
                            'files' => [[
                            'name' => $fileName,
                            'size' => ($imageFile->size * 10 / 100),
                            "url" => $path,
                            "thumbnailUrl" => $path,
                            "deleteUrl" => '?r=club/image-delete&name=' . $fileName.'&clubName='.$name,
                            "deleteType" => "POST"
                                ]]
                ]);
            }
        }
        return '';
    }

    public function actionImageDelete($name,$clubName) 
      {
        $directory = \Yii::getAlias('@frontend/web/club_gallery/') . DIRECTORY_SEPARATOR . $clubName;
        if (is_file($directory . DIRECTORY_SEPARATOR . $name)) {
            unlink($directory . DIRECTORY_SEPARATOR . $name);
        }
        $files = \yii\helpers\FileHelper::findFiles($directory);
        $output = [];
        foreach ($files as $file) {
            $path = "/frontend/web/club_gallery/" . $clubName . DIRECTORY_SEPARATOR . basename($file);
            $output['files'][] = [
                'name' => basename($file),
                'size' => filesize($file),
                "url" => $path,
                "thumbnailUrl" => $path,
                "deleteUrl" => 'image-delete?name=' . basename($file),
                "deleteType" => "POST"
            ];
        }
        return \yii\helpers\Json::encode($output);
    }
    
    public function read_all_files($root = '.')
    {
        $files = array('files' => array(), 'dirs' => array());
        $directories = array();
        $last_letter = $root[strlen($root) - 1];
        $root = ($last_letter == '\\' || $last_letter == '/') ? $root : $root . DIRECTORY_SEPARATOR;

        $directories[] = $root;

        while (sizeof($directories)) {
            $dir = array_pop($directories);
            if ($handle = opendir($dir)) {
                while (false !== ($file = readdir($handle))) {
                    if ($file == '.' || $file == '..') {
                        continue;
                    }
                   // echo $file;
                     $filename=$file; 
                    $file = $dir . $file;
                   
                    if (is_dir($file)) {
                        $directory_path = $file . DIRECTORY_SEPARATOR;
                        array_push($directories, $directory_path);
                        $files['dirs'][] = $directory_path;
                    } elseif (is_file($file)) {
                        $files['files'][] = $filename;
                    }
                   
                }
                closedir($handle);
            }
        }

        return $files;
} 

}

