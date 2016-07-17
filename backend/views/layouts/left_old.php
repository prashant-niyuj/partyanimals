<?php
use yii\bootstrap\Nav;

?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?php if(!Yii::$app->user->isGuest){ $userinfo=Yii::$app->user->identity; echo $userinfo['username'];}?></p>

               
            </div>
        </div>

        <!-- /.search form -->
      <?php if(!Yii::$app->user->isGuest){
          
          $userinfo=Yii::$app->user->identity; 
          
          if($userinfo['role_id']==1)
          {
          ?>
        
        
        <?=
        Nav::widget(
            [
                'encodeLabels' => false,
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    
                    ['label' => '<i class="fa fa-file-code-o"></i><span>Owner/Gatekeeper</span>', 'url' => ['/user/admin/index']],
                    ['label' => '<i class="fa fa-dashboard"></i><span>Club</span>', 'url' => ['/club/index']],
                    ['label' => '<i class="fa fa-file-code-o"></i><span>City</span>', 'url' => ['/city/index']],
                 
                     [
                          'label' => '<i></i><span>Club Booking</span>',
                        //  'icon' => 'fa fa-share',
                          'url' => '#',
                          'items' => [
                            ['label' => 'Club Booking', 'url' => ['/club-booking/index']],
                           ['label' => 'Booking Capacity', 'url' => ['/booking-capacity-asdate/index']],
                           ['label' => 'Booking Rate', 'url' => ['/booking-rate-asdate/index']],
                  
                         
                          ],
                          ],
                   
                    [
                          'label' => '<i></i><span>Report</span>',
                         // 'icon' => 'fa fa-share',
                          'url' => '#',
                          'items' => [
                            ['label' => 'Daily Booking', 'url' => ['/report/daily-report']],
                           ['label' => 'Total booking', 'url' => ['/report/total-booking-report']],
                           
                         
                          ],
                          ],
                   
                  
                    [
                        'label' => '<i class="glyphicon glyphicon-lock"></i><span>Sing in</span>', //for basic
                        'url' => ['/user/security/login'],
                        'visible' =>Yii::$app->user->isGuest
                    ],
                ],
            ]
        );
          }else if($userinfo['role_id']==2){?>
              
          <?= Nav::widget(
              [
                'encodeLabels' => false,
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    
                    ['label' => '<i class="fa fa-file-code-o"></i><span>Manage Gatekeeper/Agent</span>', 'url' => ['/user/admin/index']],
                    ['label' => '<i class="fa fa-dashboard"></i><span>Club</span>', 'url' => ['/club/index']],
                  
                  ['label' => '<i class="fa fa-dashboard"></i><span>Club Booking</span>', 'url' => ['/club-booking/index']],
                  
                  //  ['label' => '<i class="fa fa-file-code-o"></i><span>Event Management</span>', 'url' => ['/event-management/index']],
                    ['label' => '<i class="fa fa-dashboard"></i><span>Booking Capacity</span>', 'url' => ['/booking-capacity-asdate/index']],
                    ['label' => '<i class="fa fa-dashboard"></i><span>Booking Rate</span>', 'url' => ['/booking-rate-asdate/index']],
                    [
                        'label' => '<i class="glyphicon glyphicon-lock"></i><span>Sing in</span>', //for basic
                        'url' => ['/user/security/login'],
                        'visible' =>Yii::$app->user->isGuest
                    ],
                         [
                          'label' => '<i class="fa fa-file-code-o"></i><span>Report</span>',
                          'icon' => 'fa fa-share',
                          'url' => '#',
                          'items' => [
                            ['label' => 'Daily Booking', 'url' => ['/report/daily-report']],
                           ['label' => 'Total booking', 'url' => ['/report/total-booking-report']],
                           
                         
                          ],
                          ],
                ],
            ]
        );    
              
          }else if($userinfo['role_id']==3){?>
              
          <?= Nav::widget(
            [
                'encodeLabels' => false,
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                 
                    ['label' => '<i class="fa fa-dashboard"></i><span>Club Booking</span>', 'url' => ['/club-booking-names/index']],
                    [
                        'label' => '<i class="glyphicon glyphicon-lock"></i><span>Sing in</span>', //for basic
                        'url' => ['/user/security/login'],
                        'visible' =>Yii::$app->user->isGuest
                    ],
                ],
            ]
        );    
              
          }else if($userinfo['role_id']==5){?>
              
          <?= Nav::widget(
            [
                'encodeLabels' => false,
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                 
                   ['label' => '<i class="fa fa-dashboard"></i><span>Club Booking</span>', 'url' => ['/club-booking/index']],
                    [
                        'label' => '<i class="glyphicon glyphicon-lock"></i><span>Sing in</span>', //for basic
                        'url' => ['/user/security/login'],
                        'visible' =>Yii::$app->user->isGuest
                    ],
                ],
            ]
        );    
              
          }
        
}
      ?>
    </section>

</aside>
