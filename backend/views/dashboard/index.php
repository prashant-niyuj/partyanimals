
<?php
$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
$urltotalbooking = \Yii::$app->urlManager->createUrl(['/club-booking/index']);
$urltodaysbooking= \Yii::$app->urlManager->createUrl(['/club-booking/index','ClubBookingSearch[booking_date]'=>date("Y-m-d")]);
$urluserregistration= \Yii::$app->urlManager->createUrl(['/user/admin/index']);

?>
<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['annotationchart']}]}"></script>
    <script type='text/javascript'>
      google.load('visualization', '1', {'packages':['annotationchart']});
      
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Date');
        data.addColumn('number', 'Booking');
       statdata=<?PHP echo  json_encode($bookingdata, JSON_PRETTY_PRINT)?>;
       for(i=0;i<statdata.length;i++)
		 {
			var arr=statdata[i].booking_date.split(" ");
			
			var date=arr[0].split("-");
			var booking=Number(statdata[i].booking_no);
			
	
		//	console.log(new Date(date[0],date[1]-1,date[2]), CPU,Memory);
			data.addRows([
				[new Date(date[0],date[1]-1,date[2]),booking],
			]);
		 }

        var chart = new google.visualization.AnnotationChart(document.getElementById('chart_div'));

        var options = {
          displayAnnotations: true,
           zoomButtonsOrder: ["1-week", "1-month", "3-months", "6-months"],
           dateFormat:"MMMM dd, yyyy",
           displayAnnotationsFilter:true,
           displayRangeSelector:false,
           title:'booking',
	//  zoomStartTime: new Date(weekDate.getFullYear(),weekDate.getMonth(),weekDate.getDate()),
	
	thickness: 2
        };

        chart.draw(data, options);
      }
    </script>

<!-- Main content 
     
        <section class="content">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?php echo $total?></h3>
                  <p>Total Booking.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="<?php echo $urltotalbooking?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo $todaybookingtotal?></h3>
                  <p>Today's Booking</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="<?php echo $urltodaysbooking?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?php echo count($totaluser);?></h3>
                  <p>User Registrations</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="<?php echo $urluserregistration?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
           
          </div><!-- /.row -->
          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <section class="col-lg-7 connectedSortable">
                <div class="col-sm-5">
            <div id='chart_div' style='width: 900px; height: 500px;'></div>

              </div>
             


     

            </section>
          </div><!-- /.row (main row) -->
