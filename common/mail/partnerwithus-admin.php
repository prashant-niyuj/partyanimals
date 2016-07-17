<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<div class="container">
	<div class="row" style="background-color:#fff;padding:10px">
    <h3>Thank you </h3>
	<div style="padding:10px">
		<p>Your booking has been completed Successfully.</p>
		<p>Your PNR-NUMBER is <b><?php if(isset($pnr)) echo $pnr; ?></b></p>
                <p>Your Booking Date is <b><?php if(isset($booking_date)) echo $booking_date; ?></b></p>
                <p>Your Club Name is <b><?php if(isset($club_name)) echo $club_name; ?></b></p>
                 <p>Your Booking type is <b><?php if(isset($booking_type)) echo $booking_type; ?></b></p>                
		<p>For any query you can send mail @ info@partyanimals.in</p>
	</div>
</div>
</div>