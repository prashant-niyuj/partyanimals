<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$basepath=Yii::getAlias('@web');
$baseurl=Yii::$app->request->hostInfo.$basepath;
?>

<div class="container">
    <div style="background: #1e1e22; border: 2px solid #000000; width: 618px; margin:0 auto;">
      <div style="padding: 20px; font-family: Arial, Helvetica, sans-serif; color:#ffffff; font-size:14px;">
          <div style="text-align:center; padding: 0 0 10px 0;border-bottom: 1px solid #0391b2;"><img src="<?php echo $baseurl."/images/logo.png"?>" alt="Party Animals"></div>
            <p>Hey <?php echo ucfirst($user_name) ?> <br>
            <br>
            <strong style="color:#00c3f0;">Thank you for showing interest in partyanimals.in!</strong><br>
            <br>
            <p>We have noticed that you made and attempt for booking on www.partyanimlas.in which seems to be failed.<br>

            <b>Here is what you can do -</b> <br>
            1. In case the amount is debited from your account, Kindaly let us know the bank tanscation id on 
            booking@partyanimals.in
            </p>
            
            <p>For any query you can send mail @ <a href='mailto:support@partyanimals.in'> support@partyanimals.in</a></p>
    
            <table width="100%" style="background:#111111; font-size:12px; padding:0 20px; color:#d2d2d2; font-family: Arial, Helvetica, sans-serif;">
                <tr>
                    <td><img src="<?php echo $baseurl.'/images/footer-logo.png'?>" alt="Party Animals"></td>
                    <td><a href="https://www.facebook.com/" target="_blank"><img src="<?php echo $baseurl.'/images/facebook.png'?>" alt="Facebook"></a> <a href="https://twitter.com/" target="_blank"><img src="<?php echo $baseurl.'/images/twitter.png'?>" alt="twitter"></a> <a href="https://www.linkedin.com/" target="_blank"><img src="<?php echo $baseurl.'/images/linkedin.png'?>" alt="linkedin"></a> <a href="https://www.instagram.com/?hl=en" target="_blank"><img src="<?php echo $baseurl.'/images/instagram.png'?>" alt="instagram"></a></td>
                    <td>
                    301, Elite Astram, Baner, Pune-411045,<br>
                    Maharashtra, India.<br>
                    <br>
                    020 65332122<br>
                    <br>
                    <a href="mailto:support@partyanimals.in" style="color: #006cff;">support@partyanimals.in</a>
                    </td>
                </tr>
            </table>
</div>
</div>
