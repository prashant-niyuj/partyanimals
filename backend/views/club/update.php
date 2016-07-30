<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Club */
$userinfo=Yii::$app->user->identity; 
$this->title = 'Update Club: ' . ' ' . $model->name;
if($userinfo['role_id']==2)
{
$this->params['breadcrumbs'][] = ['label' => 'Clubs', 'url' => ['view',"id"=>$model->id]];
}else{
    
    $this->params['breadcrumbs'][] = ['label' => 'Clubs', 'url' => ['index']];
}

$updateurl=\Yii::$app->urlManager->createUrl(['club/update','id'=>$model->id,'tab'=>"clubgallery"]);
$this->params['breadcrumbs'][] = 'Update';

$flash = Yii::$app->session->getFlash('success');

?>
 <?php
    if(isset($flash) && $flash!="")
    {?>
    <div class="alert-success alert fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        <?php  echo $flash;?>
    </div>
    <?php
    
     Yii::$app->session->removeFlash('success');
    }
    ?>
<div class="club-update">

   <ul class="nav nav-tabs">
        <li <?php if(!isset($tab)){ echo "class='active first'";}else{ echo "class=''";}?>><a href="#home" data-toggle="tab" aria-expanded="false"><span>Club Details</span></a> </li>
        <li <?php if(isset($tab) && $tab=="clubgallery" ) echo "class='active' "?>><a href="#clubgallery"  data-toggle="tab"><span>Gallery</span></a> </li>
       
    </ul>
   <div class="tab-content">
       <div class="tab-pane fade <?php if(!isset($tab)){ echo 'active in';}?>" id="home">
         <div class="product-master-update">  

    <?= $this->render('_form', [
        'model' => $model,
		'cityArray'=>$cityArray,
                 'galleryFiles'=>$galleryFiles
    ]) ?>

</div></div>      
            
        </div>
        <div class="tab-pane fade <?php if(isset($tab) && $tab=="clubgallery" ){ echo 'active in';}?>" id="clubgallery">
          <?php

// with UI

use dosamigos\fileupload\FileUploadUI;
?>
   
            <div class="row">
                <div class="form-group">
                <div class="col-rg-1"></div>
                <div class="col-rg-11" style="align-text:right;margin-top:10px;margin-left: 600px;"><a href="<?php echo $updateurl?>" class="btn btn-primary">Done</a></div>
                </div>
            </div>
<?= FileUploadUI::widget([
    'model' => $model,
    'attribute' => 'logo',
    'url' => ['image-upload','name'=>$model->name],
    'gallery' => true,
    'fieldOptions' => [
            'accept' => 'image/*'
    ],
    'clientOptions' => [
            //'maxFileSize' => 2000000
    ],
    // ...
    'clientEvents' => [
            'fileuploaddone' => 'function(e, data) {
                                    console.log(e);
                                    console.log(data);
                                }',
            'fileuploadfail' => 'function(e, data) {
                                    console.log(e);
                                    console.log(data);
                                }',
    ],
]);
?>

            
            <?php
  
  $gallaryfiles=  array_unique($galleryFiles['files']);
  
$items=[];
$i=1;
foreach($gallaryfiles as $image)
{

$items[]=[
        'url' => "../../frontend/web/club_gallery" . DIRECTORY_SEPARATOR . $model->name . DIRECTORY_SEPARATOR.$image,
        'src' => "../../frontend/web/club_gallery" . DIRECTORY_SEPARATOR . $model->name. DIRECTORY_SEPARATOR . "resize".DIRECTORY_SEPARATOR.$image ,
        
        'options' => array('title' => 'image'+$i)
    ];
    $i++;
}
     // var_dump($items);
   ?>
        <?= dosamigos\gallery\Gallery::widget(['items' => $items,"options"=>['width'=>"100px",'height'=>"100px"]
         
]);?>
            
        
</div>
        
        </div>
