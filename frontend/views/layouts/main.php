<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    
</head>
<body>
    <?php $this->beginBody() ?>
    <div id="menupanel">
        <div class="inside_menu_icon"><span class="glyphicon glyphicon-menu-hamburger menuicon"></span></div>
        <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="index.php?r=site/aboutus">About Us</a></li>
        <li><a href="index.php?r=site/htw">How it Works</a></li>
        <li><a href="index.php?r=site/termsandconditions">Terms & Conditions</a></li>
        <li><a href="index.php?r=site/privacypolicy">Privacy Policy</a></li>
        <li><a href="index.php?r=partner-with-us/create">Partner with us</a></li>
        <li><a href="index.php?r=contact-us/create">Contact</a></li>
        <?php
        if(Yii::$app->user->isGuest)
        {
           
        ?>
        <li><?= Html::a(
                                    'Login',
                                    ['/user/security/login']                                    
                                ) ?></li>
        <?php }else{
            
            
            ?>
        
            <li> <?= Html::a(
                                    'Logout',
                                    ['/user/security/logout'],
                                    ['data-method' => 'post']
                                ) ?></li> 
            
       <?php }?>
        </ul>
    </div>
    <div class="container">
        <header>
            <div class="row">
                <div class="col-md-2 col-xs-2"><span class="glyphicon glyphicon-menu-hamburger" id="menuicon"></span></div>
                <div class="col-md-8 col-xs-7 text-center"><a href="index.php"><img src="images/logo.png" class="logo" /></a></div>
                <div class="col-md-2 col-xs-2 text-right"></div>
            </div>
            <div class="headerdetails">
                <div class="row ">
                    <div class="col-md-6 col-xs-6"><span class="glyphicon glyphicon-map-marker"></span> 
                        <a data-target="#myModal" data-toggle="modal" class="changeCity" class="pull-right" href="#"></a>
                    </div>
                    <div class="col-md-6 col-xs-6 text-right">
                      <?php
        if(Yii::$app->user->isGuest)
        {
            
        ?>
                   <?= Html::a(
                                    'Sign In',
                                    ['/user/security/login']                                    
                                ) ?>
        <?php }else{
            
            ?><?= Html::a(
                                    'Logout',
                                    ['/user/security/logout'],
                                    ['data-method' => 'post']
                                ) ?>
       <?php }?>
                        
                    </div>
                </div>
            </div>
        </header> 
        

        <?= $content ?>

    </div>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="title">How it Works</div>
                    <p>Party Animals started off as a ticketing website for clubs
and we have come a long way since then. But our primary 
focus has always been delivering the very best club
experience to our dedicated customers. belonging to 
different different cities. <a href="index.php?r=site/htw" style="color: brown;">Know More..</a></p>              
                 </div>
                 
                 
                <div class="col-sm-4">
                <div class="title">Party animals</div>
                    <ul class="list-unstyled pillor-2">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="index.php?r=site/aboutus">About Us</a></li> 
                        <li><a href="index.php?r=site/htw">How it Works</a></li>
                        <li><a href="index.php?r=site/termsandconditions">Terms & Conditions</a></li>
                        <li><a href="index.php?r=site/privacypolicy">Privacy Policy</a></li>
                        <li><a href="index.php?r=contact-us/create">Contact Us</a></li>
                        <li><a href="index.php?r=partner-with-us/create">Partner with us</a></li>
                    </ul>
                    <div class="snicons">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-linkedin"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                    </div>
                </div>
                
                
                <div class="col-sm-4 address">
                    <div class="title">get in touch with us</div>
                     <span><i class="fa fa-map-marker"></i> 301, Elite Astram, Baner, Pune-411045, Maharashtra, India.</span>
                    <span><i class="fa fa-phone"></i><a href="tel:020 65332122"> 020 65332122</a></span>
                    <!--<span><i class="fa fa-fax"></i>(020)-65332122</span>-->
                    <span><i class="fa fa-envelope"></i> <a href="mailto:support@partyanimals.in">support@partyanimals.in</a></span>
                </div>
                
            </div>
        </div>
        <div class="inside">
            <div class="container">
                © Infinte E Ticketing Pvt. Ltd.
            </div>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<div id="selectCity" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content banner colored ">
        <div class="modal-header">
            <button type="button" class="close hide" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Select Your City</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
            <input type="text" placeholder="Enter Your City" name="ccity"  id="ccity" aria-describedby="basic-addon1" class="form-control typeahead">
            </div>
            <div class="popup_buttons_group" style="margin-top:50px">
                <div class="form-group">
                <button class="btn btn-lg btn-primary btn-block submit_city" type="button" data="signin">Sign in</button>
                </div>
                <div class="form-group">
                <button class="btn btn-lg btn-primary btn-block submit_city" type="button"  data="signup">Sign up</button>
                </div>
                <div class="form-group">
                <button class="btn btn-lg btn-primary btn-block submit_city" type="button"  data="guest">As Guest</button>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <span class="tip-box pull-left">Discover the best Entertainment Club in your city.</span>
            <button type="button" class="btn btn-primary submit_city" data="ok">OK</button>
        </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php $this->endPage() ?>
