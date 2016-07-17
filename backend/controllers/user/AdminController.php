<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\controllers\user;

use dektrium\user\controllers\AdminController as BaseAdminController;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use backend\models\User;
use yii\filters\VerbFilter;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;

/**
 * AdminController allows you to administrate users.
 *
 * @property Module $module
 * @author Dmitry Erofeev <dmeroff@gmail.com
 */
class AdminController extends BaseAdminController
{
     /** @inheritdoc */
    public function behaviors() {


        return [
          
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'update-profile','delete', 'block', 'confirm','getclub'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                    $userInfo = \Yii::$app->user->identity;
                    
                    if ($userInfo['role_id']==1 || $userInfo['role_id']==2) {
                        return TRUE;
                    } else {
                        return FALSE;
                    }
                }
                    ],
                   
                ]
            ]
        ];
    }

     /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        Url::remember('', 'actions-redirect');
        $searchModel  = Yii::createObject(UserSearch::className());
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        
        $user=new User();
        $clubArray= $user->getClubList();
        $userroleArray=$user->getUserRoleList();
       
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
            'clubArray'=>$clubArray,
            'userroleArray'=>$userroleArray
        ]);
    }

    
    public function actionCreate()
    {
        /** @var User $user */
        $user = Yii::createObject([
            'class'    => User::className(),
            'scenario' => 'create',
        ]);
        $userinfo=  \yii::$app->user->identity;
      
        if($userinfo['role_id']==2)
        {
            $clubModels = \backend\models\Club::find()->asArray()->where(["id"=>$userinfo['club_id']])->all();
            $userroleModels = \backend\models\UserRole::find()->asArray()->where(["id"=>array(3,5)])->all();
            
        }else{
            
        $clubModels = \backend\models\Club::find()->asArray()->all();
        $userroleModels = \backend\models\UserRole::find()->asArray()->where(['id'=>array(2,3,5)])->all();
        }
        $clubArray = ArrayHelper::map($clubModels, 'id', 'name');
       
         
        
        $userroleArray = ArrayHelper::map($userroleModels, 'id', 'role_name');


        $this->performAjaxValidation($user);

        if ($user->load(Yii::$app->request->post()) && $user->create()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('user', 'User has been created'));
            return $this->redirect(['update', 'id' => $user->id]);
        }
        $param['clubArray']=$clubArray;
         $param['userroleArray']=$userroleArray;

        return $this->render('create', [
            'user' => $user,
            'param'=>$param,
        ]);
    }
     /**
     * Updates an existing User model.
     * @param  integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        Url::remember('', 'actions-redirect');
        $user = $this->findModel($id);
        $user->scenario = 'update';
         $userinfo=  \yii::$app->user->identity;  
         
        if($userinfo['role_id']==2)
        {
               $clubModels = \backend\models\Club::find()->asArray()->where(['id'=>$userinfo['club_id']])->all();
                $userroleModels = \backend\models\UserRole::find()->asArray()->where(['id'=>array(3,5)])->all();
        }else{
        $clubModels = \backend\models\Club::find()->asArray()->all();
         $userroleModels = \backend\models\UserRole::find()->asArray()->where(['id'=>array(2,3,5)])->all();
        }
        $clubArray = ArrayHelper::map($clubModels, 'id', 'name');
        
         
       
        $userroleArray = ArrayHelper::map($userroleModels, 'id', 'role_name');

        $this->performAjaxValidation($user);

        if ($user->load(Yii::$app->request->post()) && $user->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('user', 'Account details have been updated'));
            return $this->refresh();
        }
         $param['clubArray']=$clubArray;
         $param['userroleArray']=$userroleArray;
        return $this->render('_account', [
            'user'    => $user,            
            'param'=>$param,
        ]);
    }
     /**
     * Updates an existing profile.
     * @param  integer $id
     * @return mixed
     */
    public function actionUpdateProfile($id)
    {
        Url::remember('', 'actions-redirect');
        $user    = $this->findModel($id);
        $profile = $user->profile;
        
        $this->performAjaxValidation($profile);
        
       // var_dump($profile_info['Profile']);die;
        if ($profile->load(Yii::$app->request->post()) && $profile->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('user', 'Profile details have been updated'));
            return $this->refresh();
        }
        
        return $this->render('_profile', [
            'user'    => $user,
            'profile' => $profile,
        ]);
    }
    
     /**
     * Performs AJAX validation.
     * @param array|Model $model
     * @throws ExitException
     */
    protected function performAjaxValidation($model)
    {
        if (Yii::$app->request->isAjax && !Yii::$app->request->isPjax) {
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                echo json_encode(ActiveForm::validate($model));
                Yii::$app->end();
            }
        }
    }
    public function actionGetclub()
    {
      $userinfo=  \yii::$app->user->identity;  
      $role_id=Yii::$app->request->get('role_id');
      $user_id=Yii::$app->request->get('user_id');
       
      //var_dump($param);die;
       $user=new User();
      if($role_id==2)
      {
        if($user_id=="")
        {
               $clublist=  $user->checkAllreadyOwner();
        }
      }
      else{
          
          $clublist= \backend\models\Club::find()->asArray()->all();
          
      }
      if($userinfo['role_id']==2)
      {
        $clublist= \backend\models\Club::find()->asArray()->where(['id'=>$userinfo['club_id']])->all();  
      }
     // var_dump($clublist);die;
       return $this->render('getclub', [
            'clublist'    => $clublist,   
        ]);
      //return $clublist;
        
    }        
    
   
   
}
