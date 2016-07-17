<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Partner With Us';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partyanimals">
    <h2>Partner With Us</h2>
    <p class="text-center">Club or bar? Fill the form below and we will do the rest.</p>

    <form class="PAforms">
    	<div class="row" style="margin-bottom: 15px;">
    		<div class="col-md-2 col-xs-3"><label><input type="radio" name="club" id="club" class="form-control"> Club ?</label></div>
    		<div class="col-md-2 col-xs-3"><label><input type="radio" name="bar" id="bar" class="form-control"> Bar ?</label></div>
    	</div>

    	<div class="row">
            <div class="col-md-6"><input type="text" class="form-control" placeholder="Name of Contact Person"></div>
    		<div class="col-md-6"><input type="text" class="form-control" placeholder="Name Of The Venue"></div>
    	</div>

    	<div class="row">
            <div class="col-md-6"><input type="text" class="form-control" placeholder="Official Email"></div>
    		<div class="col-md-6"><input type="text" class="form-control" placeholder="Mobile No."></div>
    	</div>

    	<div class="row">
            <div class="col-md-6"><input type="text" class="form-control" placeholder="Address"></div>
    	    <div class="col-md-6"><textarea class="form-control" placeholder="Description Of Venue"></textarea></div>
    	</div>

    	<div class="row">
    		<div class="col-md-12 text-right">
    			<input class="btn btn-primary" type="button" value="Send">
    			<input class="btn btn-primary" type="button" value="Clear">
    		</div>
    	</div>
    </form>

    <div>
    	<p class="text-center" style="margin-top: 20px;">To know more mail us at - <a href="mailto:corporate@partyanimals.in">corporate@partyanimals.in</a> </p>
    </div>

</div>
