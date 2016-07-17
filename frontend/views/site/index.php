<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->title = 'Party Animals';
?>

<div class="banner bot-border">
    <div class="row">
        <form id="search_club">
        <div class="col-md-6 col-sm-6">
            <div class="input-group">
                <input type="text" name="location" class="form-control pa-input" id="location" placeholder="Search Location Here"> <span class="input-group-addon"><span class="glyphicon glyphicon-map-marker"></span></span>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="input-group">
                <input type="text" name="club_name" class="form-control pa-input" id="club_name" placeholder="Search Club Here"> <span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
            </div>
        </div>
    </form>
    </div>
</div>
<div class="mac-container">     
    <div class="slider">
				<div class="owl-navigation">
			            <a href="#home_carousel" data-slide="prev" class="owl-btn prev"><i class="fa fa-angle-left"></i></a>
			            <a href="#home_carousel" class="owl-btn next" data-slide="next"><i class="fa fa-angle-right"></i></a>
			            <div class="title">
		                <div class="searchedclube">Trending Venues</div>
		            </div>
		        </div>
				<div class="container">
					<div class="row clearfix">
						<div class="col-xs-12 text-center" style="padding:0;width:98%">
							<div class="carousel slide" id="home_carousel">
								
							<div class="carousel-inner">
								<div id="req_res_loading"></div>
							</div>
						
						</div> 
					</div>
				</div>
				<div class="no_data_found"><center>No data found</center></div>
			</div>
		</div>
</div>


<!--input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" /-->	
<div id="popover-content" style="display:none;">
	<input type="hidden" name="c_id" id="c_id" value="0" />
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td>
		<div class="form-group">
			<div class="error_club_full alert alert-danger" role="alert">Sorry! Club full</div>
			<input class="form-control txt_datepicker cicon" id="txt_datepicker" placeholder="Booking Date" name="txt_datepicker" type="text"  readonly />
		</div>
	  </td>
	  </tr>
	 
	  <tr>
		<td>
		<div class="form-group">
		<div class="radio">
			<label>
				<input type="radio" name="b_type" id="radio_boy" value="boy"  />Stag <span class="ru"></span> <span class='span_boy'>100</span>
			</label>
		</div>
		<div class="radio">
			<label>
				<input type="radio" name="b_type" id="radio_girl" value="girl"   />Girls <span class="ru"></span> <span class='span_girl'>200</span>
			</label>
		</div>
		<div class="radio">
			<label>
				<input type="radio" name="b_type" id="radio_couple" value="couple"  />Couple <span class="ru"></span> <span class='span_couple'>300</span></label>
			</label>
		</div>
		<div class="radio">
			<label>
				<input type="radio" name="b_type" id="radio_group" value="group"  /> Groups
			</label>
		</div>
		</div>
		</td>
	  </tr>
	  <tr class="tr_group">
		<td>
		<div class="form-group">
			<select class="form-control txt_group popup_drop_boys" id="popup_drop_boys" name="popup_drop_boys">
				<option value="0">Boys</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
			  </select>
			  <select class="form-control txt_group popup_drop_girls" id="popup_drop_girls" name="popup_drop_girls">
				<option value="0">Girls</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
			  </select>
		</div>
		</td>
	  </tr>
	  <tr>
		<td><center><button type='submit' class='btn btn-xs btn_book_now'>Book Now</button><center>
			<center><a href="index.php?r=site/explore" class="a_explore">Explore Club</a><center>
		</td>
	  </tr>
	</table>
</div>

<?php

$this->registerJs('$("document").ready(function(){ 
	$(".navbar-toggle").click(function(e) {
		$(".popover").hide();
		$(".popover").removeClass("in");
		$(".popover").remove();
		e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
	load_club();
		$(".carousel-inner").swiperight(function() {  
			$("#home_carousel").carousel("prev");
		});  
	    $(".carousel-inner").swipeleft(function() {  
			$("#home_carousel").carousel("next");
		});
	//load_events();		
});');

?>

