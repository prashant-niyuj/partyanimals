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
       <?php
       $eventbooking=[];
          $eventbooking[] =['label' => 'Event Booking', 'icon' => 'fa fa-dashboard', 'url' => ['/event-booking/index']];
 $eventbookingItemsArray=""; 
         if(count($eventbooking))
              {
                  $eventbookingItemsArray=[
                                'label' => 'Event Booking',
                                'icon' => 'fa fa-share',
                                'url' => '#',
                                'items' => $eventbooking,
                            ];
              }
        $clubbooking=[];
        
          $clubbooking[] =['label' => 'Club Booking', 'icon' => 'fa fa-dashboard', 'url' => ['/club-booking/index']];
                           $clubbooking[] =['label' => 'Booking Capacity', 'icon' => 'fa fa-dashboard', 'url' => ['/booking-capacity-asdate/index']];
                           $clubbooking[] =['label' => 'Booking Rate', 'icon' => 'fa fa-dashboard', 'url' => ['/booking-rate-asdate/index']];
           
                           $report=[];
                         $report[]=['label' => 'Daily Booking','icon' => 'fa fa-dashboard', 'url' => ['/report/daily-report']];
                         $report[]=['label' => 'Total booking','icon' => 'fa fa-dashboard', 'url' => ['/report/total-booking-report']];
                                
              $clubbookingItemsArray=""; 
              if(count($clubbooking))
              {
                  $clubbookingItemsArray=[
                                'label' => 'Club Booking',
                                'icon' => 'fa fa-share',
                                'url' => '#',
                                'items' => $clubbooking,
                            ];
              }
             $reporttemsArray=""; 
              if(count($report))
              {
                  $reporttemsArray=[
                                'label' => 'Report',
                                'icon' => 'fa fa-share',
                                'url' => '#',
                                'items' => $report,
                            ];
              }
              
              ?>
        <!-- /.search form -->
      <?php if(!Yii::$app->user->isGuest){
          
          $userinfo=Yii::$app->user->identity; 
          
          if($userinfo['role_id']==1)
          {
              
            
       
          ?>
         <?=
            dmstr\widgets\Menu::widget(
                    [
                        'options' => ['class' => 'sidebar-menu'],
                        'items' => [
                                ['label' => 'Owner/Gatekeeper', 'icon' => 'fa fa-file-code-o', 'url' => ['/user/admin/index']],
                                ['label' => 'Club', 'icon' => 'fa fa-dashboard', 'url' => ['/club/index']],
                                ['label' => 'City', 'icon' => 'fa fa-file-code-o', 'url' => ['/city/index']],  
                               
                           $clubbookingItemsArray,
                            $reporttemsArray,
                            $eventbookingItemsArray,
                       
                           
                        ],
                    ]
            )
            ?>
        

<?Php  }else if($userinfo['role_id']==2){?>
              
        <?=
            dmstr\widgets\Menu::widget(
                    [
                        'options' => ['class' => 'sidebar-menu'],
                        'items' => [
                                ['label' => 'Manage Gatekeeper/Agent', 'icon' => 'fa fa-file-code-o', 'url' => ['/user/admin/index']],
                                ['label' => 'Club', 'icon' => 'fa fa-dashboard', 'url' => ['/club/index']],
                                ['label' => 'Club Booking', 'icon' => 'fa fa-file-code-o', 'url' => ['/club-booking/index']],  
                              ['label' => 'Booking Capacity', 'icon' => 'fa fa-dashboard', 'url' => ['/booking-capacity-asdate/index']],
                                ['label' => 'Booking Rate', 'icon' => 'fa fa-file-code-o', 'url' => ['/booking-rate-asdate/index']],  
                              
                          
                            $reporttemsArray,
                            
                       
                           
                        ],
                    ]
            ) 
            ?>
              
        <?php      
          }else if($userinfo['role_id']==3){?>
           <?=
            dmstr\widgets\Menu::widget(
                    [
                        'options' => ['class' => 'sidebar-menu'],
                        'items' => [
                                ['label' => 'Club Booking', 'icon' => 'fa fa-dashboard', 'url' => ['/club-booking-names/index']],
                                
                           
                        ],
                    ]
            ) 
            ?> 
   
           <?php 
          
          }else if($userinfo['role_id']==5){?>
              <?=
            dmstr\widgets\Menu::widget(
                    [
                        'options' => ['class' => 'sidebar-menu'],
                        'items' => [
                                ['label' => 'Club Booking', 'icon' => 'fa fa-dashboard', 'url' => ['/club-booking/index']],
                                
                           
                        ],
                    ]
            ) 
            ?> 
          <?php 
              
          }
        
}
      ?>
    </section>

</aside>
