<?php

/* 
 * This file is part of the Dektrium project
 * 
 * (c) Dektrium project <http://github.com/dektrium>
 * 
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\User $user
 */


$userimagepath=Yii::$app->params['userimagesPath'];
$userimage=Yii::$app->request->baseUrl.$userimagepath;
//var_dump($profile->user_image);die;
?>

<?php $this->beginContent('@dektrium/user/views/admin/update.php', ['user' => $user]) ?>

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'enableAjaxValidation'   => true,
        'enableClientValidation' => false,
         'options' => ['enctype' => 'multipart/form-data'],
        'fieldConfig' => [
            'horizontalCssClasses' => [
                'wrapper' => 'col-sm-9',
            ]
        ],
    ]); ?>

    <?= $form->field($profile, 'name') ?>
    <?= $form->field($profile, 'public_email') ?>
    <?= $form->field($profile, 'website') ?>


<?= $form->field($profile, 'user_image')->fileInput() ?>
<?php if(isset($profile->user_image) && !empty($profile->user_image)) 
    {echo '<center><img src= "'.$userimage.$profile->user_image.'" height="50"/></center>'; ?>
<?php }else{ ?>
   <center> <img src="<?= $userimage?>noimage.png" class="user-image" height="50" alt="User Image"/> </center>  
           <?php }?>    
   <br>
    <div class="form-group">
        <div class="col-lg-offset-3 col-lg-9">
            <?= Html::submitButton(Yii::t('user', 'Update'), ['class' => 'btn btn-block btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

<?php $this->endContent() ?>
