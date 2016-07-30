<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * @var yii\widgets\ActiveForm    $form
 * @var dektrium\user\models\User $user
 */
//$param['clubArray']=array();
//$param['userroleArray']=array();

$url = \Yii::$app->urlManager->createUrl(['user/admin/getclub']);

?>

<?= $form->field($user, 'username')->textInput(['maxlength' => 25]) ?>
<?= $form->field($user, 'email')->textInput(['maxlength' => 255]) ?>
<?= $form->field($user, 'phone_no')->textInput(['maxlength' => 10]) ?>
<?= $form->field($user, 'role_id')->dropDownList($param['userroleArray'],['onchange'=>'changeClub(this.value,"'.$url.'","'.$user->id.'")','prompt' => '-Choose a User role-']); ?>
<?= $form->field($user, 'club_id')->dropDownList($param['clubArray'],['prompt' => '-Choose a Club-']); ?>

<?= $form->field($user, 'password')->passwordInput() ?>

<script>
    function changeClub(role_id, url,user_id) {

    $.ajax({
        type: 'GET',
        cache: false,
        data: {'role_id': role_id,'user_id':user_id},
        url: url,
        success: function(response) 
        {
            console.log(response);
            if (response.length != 0) {
               // $('tbody').html('<tr><td colspan="8"><div class="empty"></div></td></tr>');
                $('#user-club_id').html(response);
            }
            

        }
    });
}
</script>