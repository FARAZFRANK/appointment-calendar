<!---load full calendar js--->
<script type='text/javascript' src='<?php echo plugins_url('/fullcalendar-assets/js/jquery-1.7.1.min.js', __FILE__); ?>'></script>
<script type='text/javascript' src='<?php echo plugins_url('/fullcalendar-assets/js/jquery-ui-1.8.17.custom.min.js', __FILE__); ?>'></script>
<script type='text/javascript' src='<?php echo plugins_url('/fullcalendar-assets/js/fullcalendar.min.js', __FILE__); ?>'></script>

<!---load full calendar css--->
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/fullcalendar-assets/css/fullcalendar.css', __FILE__); ?>' />
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/fullcalendar-assets/css/fullcalendar.print.css', __FILE__); ?>' media='print' />


<!--date-picker css -->
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/datepicker-assets/css/jquery-ui-1.8.23.custom.css', __FILE__); ?>' />


<!---load bootstrap css----->
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/bootstrap-assets/css/bootstrap.css', __FILE__); ?>' />




<!---render fullcalendar----->
<script type='text/javascript'>

$(document).ready(function() {
	
			
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			editable: false,
			weekends: true,
			timeFormat: 'h:mmtt{-h:mmtt }',
			firstDay: <?php echo get_option('calendar_start_day'); ?>,
			slotMinutes: <?php echo get_option('calendar_slot_time'); ?>,
			minTime: <?php  echo date("G", strtotime(get_option('day_start_time')));?>,
			defaultView: '<?php echo get_option('calendar_view'); ?>',
			maxTime: <?php  echo date("G", strtotime(get_option('day_end_time')));?>,
			events: [

/*------------------------------- Loading Appointments On Calendar Start --------------------------------------*/
<?php

			global $wpdb;
			$AppointmentTableName = $wpdb->prefix."ap_appointments";
			$FetchAllApps_sql = "select `name`, `start_time`, `end_time`, `date` FROM `$AppointmentTableName`";
			$AllAppointments = $wpdb->get_results($FetchAllApps_sql, OBJECT);
				if($AllAppointments)
				{
						foreach($AllAppointments as $single)
						{
							$title = $single->name;
							$start = date("H, i", strtotime($single->start_time));
							$end= date("H, i", strtotime($single->end_time));
							
							// subtract 1 from month digit coz calendar work on month 0-11
							
							$y = date ( 'Y' , strtotime( $single->date ) );
							$m = date ( 'n' , strtotime( $single->date ) ) - 1;
							$d = date ( 'd' , strtotime( $single->date ) );
							$date = "$y-$m-$d";

							$date = str_replace("-",", ", $date);
							$url = ""; //"?r=manage-appointments/view&id=".$single->id."&cal=cal";
							?>
							{
				
								title: 'Booked By: <?php echo $title; ?>',
								start: new Date(<?php echo "$date, $start"; ?>),
								end: new Date(<?php echo "$date, $end"; ?>),
								url: '<?php echo $url; ?>',
								allDay: false,
								backgroundColor : 'green',
								textColor: 'black',
								
							},
							<?php
						}
				}
?>
/*------------------------------- Loading Appointments On Calendar End --------------------------------------*/



/*------------------------------- Loading Events On Calendar Start --------------------------------------*/						
<?php
					
			global $wpdb;
			$EventTableName = $wpdb->prefix."ap_events";
			$FetchAllEvent_sql = "select `name`, `start_time`, `end_time`, `start_date`, `end_date`, `repeat` FROM `$EventTableName` where `repeat` = 'N'";
			$AllEvents = $wpdb->get_results($FetchAllEvent_sql, OBJECT);
				if($AllEvents)
				{
							foreach($AllEvents as $Event)
							{
								//convert time foramt H:i:s
								$starttime = date("H:i", strtotime($Event->start_time));
								$endtime = date("H:i", strtotime($Event->end_time));
								//change time format according to calendar
								$starttime = str_replace(":",", ", $starttime);
								$endtime = str_replace(":", ", ", $endtime);
								
								$startdate = $Event->start_date;
								// subtract 1 from $startdate month digit coz calendar work on month 0-11
								$y = date ( 'Y' , strtotime( $startdate ) );
								$m = date ( 'n' , strtotime( $startdate ) ) - 1;
								$d = date ( 'd' , strtotime( $startdate ) );
								$startdate = "$y-$m-$d";
								$startdate = str_replace("-",", ", $startdate);		//changing date format
								
								$enddate = $Event->end_date;
								// subtract 1 from $startdate month digit coz calendar work on month 0-11
								$y2 = date ( 'Y' , strtotime( $enddate ) );
								$m2 = date ( 'n' , strtotime( $enddate ) ) - 1;
								$d2 = date ( 'd' , strtotime( $enddate ) );
								$enddate = "$y2-$m2-$d2";

								$enddate = str_replace("-",", ", $enddate);		//changing date format
								$url = "";//"?r=acevents/view&id=".$Event->id."&cal=cal";
								
								?>
								{
									title: '<?php echo $Event->name; ?>',
									start: new Date(<?php echo "$startdate, $starttime"; ?>),
									end: new Date(<?php echo "$enddate, $endtime"; ?>),
									url: '<?php echo $url; ?>',
									allDay: false,
									backgroundColor : 'red',
									textColor: 'black',
								},
								<?php
							}
				}
?>
/*------------------------------- Loading Events On Calendar End --------------------------------------*/



/*------------------------------- Loading Recurring Events On Calendar Start --------------------------------------*/
<?php
					
			global $wpdb;
			$EventTableName = $wpdb->prefix."ap_events";
			$FetchAllREvent_sql = "select `name`, `start_time`, `end_time`, `start_date`, `end_date`, `repeat` FROM `$EventTableName` where `repeat` != 'N'";
			$AllREvents = $wpdb->get_results($FetchAllREvent_sql, OBJECT);
			
						if($AllREvents)	//dont show event on filtering
						{
							foreach($AllREvents as $Event)
							{
								//convert time foramt H:i:s
								$starttime = date("H:i", strtotime($Event->start_time));
								$endtime = date("H:i", strtotime($Event->end_time));
								//change time format according to calendar
								$starttime = str_replace(":",", ", $starttime);
								$endtime = str_replace(":", ", ", $endtime);
								
								
								$startdate = $Event->start_date;
								$enddate = $Event->end_date;
								
								$Alldates = array();
								$st_dateTS = strtotime($startdate);
								$ed_dateTS = strtotime($enddate);
								for ($currentDateTS = $st_dateTS; $currentDateTS <= $ed_dateTS; $currentDateTS += (60 * 60 * 24)) 
								{
									$currentDateStr = date("Y-m-d",$currentDateTS);
									$AlldatesArr[] = $currentDateStr;
								
									// subtract 1 from $startdate month digit coz calendar work on month 0-11
									$y = date ( 'Y' , strtotime( $currentDateStr ) );
									$m = date ( 'n' , strtotime( $currentDateStr ) ) - 1;
									$d = date ( 'd' , strtotime( $currentDateStr ) );
									$startdate = "$y-$m-$d";
									$startdate = str_replace("-",", ", $startdate);		//changing date format
									
									
									// subtract 1 from $startdate month digit coz calendar work on month 0-11
									$y2 = date ( 'Y' , strtotime( $currentDateStr ) );
									$m2 = date ( 'n' , strtotime( $currentDateStr ) ) - 1;
									$d2 = date ( 'd' , strtotime( $currentDateStr ) );
									$enddate = "$y2-$m2-$d2";
	
									$enddate = str_replace("-",", ", $enddate);		//changing date format
									$url = ""; 
									
									?>
									{
										title: '<?php echo $Event->name; ?>',
										start: new Date(<?php echo "$startdate, $starttime"; ?>),
										end: new Date(<?php echo "$enddate, $endtime"; ?>),
										url: '<?php echo $url; ?>',
										allDay: false,
										backgroundColor : 'red',
										textColor: 'black',
									},
								<?php
								}
							}
						}
					?>
/*------------------------------- Loading Recurring Events On Calendar End --------------------------------------*/	



				
			]
		});
		
		
		<!-------------Launch Modal Form-------------------->
		//show frist modal
		$('#addappointment').click(function(){
			$('#AppFirstModal').show();
		});
		//hide modal
		$('#close').click(function(){
			$('#AppFirstModal').hide();
		});
		
		<!----load date picekr on modal for---->
		document.addnewappointment.appdate.value = $.datepicker.formatDate('dd-mm-yy', new Date());
		//$( "#datepicker" ).datepicker();
		$(function(){ 
						$("#datepicker").datepicker({
							inline: true,
							minDate: 0,
							altField: '#alternate',
							onSelect: function(dateText, inst) { 
								var dateAsString = dateText; 
								var seleteddate = $.datepicker.formatDate('dd-mm-yy', new Date(dateAsString));
								document.addnewappointment.appdate.value = seleteddate;
							}
						});
		});
		
		<!---AppFirstModal Validation---->
		$('#next1').click(function(){
					$(".error").hide();
					if($('#service').val() == 0)
					{
						$("#service").after('<span class="error"><p><strong>Select Any Service.</strong></p></span>');
						return false;
					}
					//// get date and service and send request to clinet form
					var bookdate = $("input#appdate").val();
					var service = $("select#service").val();
					var dataStringfirst = 'bookdate='+ bookdate + '&service=' + service;
					var url = "?page=time_sloat";
					
					$.ajax({
								dataType : 'html',
								type: 'GET',
								url : url,
								cache: false,
								data : dataStringfirst,
								complete : function() { /*alert('complete'); */ },
								success: function(data) 
										{
											$('#time_sloat').show();
											$('#myfristmodel').hide();
											data=$(data).find('div#myModalsecond');
											$('#time_sloat').html(data);
										}
					});
		});
			
});
	
		
		

	
	function backtodate()
	{
		$('#myfristmodel').show();
		$('#time_sloat').hide();
	}
	
	function hari()
	{			
			$(".error").hide();
			
			var start_time = $('input[name=start_time]:radio:checked').val();
			if(!start_time)
			{
				$("#clientboxform").before("<span class='error'><p align=center><strong>Select any time.</strong></p></span>");
				return false;  
			}
			
			var name = $("#name").val();
			if(name == '')
				{	$("#name").after("<span class='error'><p><strong>Name cannot be blank.</strong></p></span>");
					return false;  
				}
				else
				 {		var name = isNaN(name);
						if(name == false) 
						{ 	
							$("#name").after("<span class='error'><p><strong>Invalid name.</strong></p></span>");
							return false;  
						}
				}
				var email = $("#email").val();
				var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				if(email == '')
					{	$("#email").after("<span class='error'><p><strong>Email cannot be blank.</strong></p></span>");
						return false;  
					}
					else
					{	if(regex.test(email) == false )
							{	
								$("#email").after("<span class='error'><p><strong>Invalid email.</strong></p></span>");  
								return false; 
							}
					}		
					
				var phone = $("#phone").val();
				if(phone == '')
					{	$("#phone").after("<span class='error'><p><strong>Phone cannot be blank.</strong></p></span>");
						return false;  
					}
					else
					{
						var phone = isNaN(phone);
						if(phone == true) 
						{ 	
							$("#phone").after("<span class='error'><p><strong>Invalid phone number.</strong></p></span>");
							return false;  
						}
					}
				
				
				var start_time = $('input[name=start_time]:radio:checked').val();
				var name = $("input#name").val();	
				var email = $("input#email").val();	
				var phone = $("input#phone").val();
				var desc = $("textarea#desc").val();
				var bookdate = $("input#appointmentdate").val();
				var serviceduration = $("input#serviceduration").val();
				var serviceid = $("input#serviceid").val();
				
				var dataStringfirst = 'bookdate='+ bookdate + '&serviceid=' + serviceid + '&name='+ name +'&email=' + email +'&phone='  + phone + '&desc=' +desc+ '&start_time=' + start_time + '&serviceduration=' + serviceduration;
					var url = "?page=data_save";
						$.ajax({
								dataType : 'html',
								type: 'GET',
								url : url,
								//cache: false,
								data : dataStringfirst,
								complete : function() { /*alert('complete'); */ },
								success: function(data) 
										{
											///alert(data);
											//$('#time_sloat').hide();
											//$('#myfristmodel').hide();
											data=$(data).find('div#maliya');
											$('#kkk').html(data);
											window.location = '?page=appointment-calendar';
											//window.location.reload( true); 
										}
								});
											
				
								
	}	
</script>
<style type='text/css'>

.error{ 
	color:#FF0000; 
}

#calendar {
	width: auto;
	margin: 4px 4px;;
}
#bkbtndiv{
	margin: 5px;
}
tr th 
{
text-align:left;
}
.inputwidth
{
width:300px;
}

</style>

<div id=bkbtndiv align="center" style="padding:5px;">
	<button name="addappointment" class="btn btn-primary" type="submit" id="addappointment">Add New Appointment</button>
</div>
<!--------show fullcalendar-->
<div id='calendar'></div>

<!--------AppFirstModal For Schedule New Appointment-->
<div id="AppFirstModal" style="display:none;">
	<div class="modal" id="myModal" >
	 <div id="myfristmodel">
		<form action="" method="post" name="addnewappointment" id="addnewappointment">
			<div class="modal-info">
					<div style="float:right; margin-top:5px; margin-right:10px;">
						<a id="close" ><i class="icon-remove"></i></a>
					</div>
				<div class="alert alert-info">
					
					<h4>Schedule New Appointment</h4>Setect Date & Service 
				</div>
				
			</div>
			
			<div class="modal-body">
				<div id="firdiv" style="float:left;">
					<div id="datepicker"></div>
				</div>
				
				<div id="secdiv" style="float:right;" >
					<h5>Your Appointment Date:</h5>
					<input name="appdate" id="appdate" type="text" disabled="disabled" />
				<?php
					global $wpdb;
					$ServiceTable = $wpdb->prefix."ap_services";
					$findservice_sql = "SELECT * FROM `$ServiceTable` WHERE `availability` = 'yes'";
					$AllService = $wpdb->get_results($findservice_sql, OBJECT);
				?>
					  <h5>Select Service:</h5>
						<select name="service" id="service">
							<option value="0">Select Service</option>
							<?php
							foreach($AllService as $Service)
								echo "<option value='$Service->id'>".ucwords($Service->name)." (".$Service->duration."min/$$Service->cost)</option>";
							?>
						</select>
					<br>
					<!--<a href="#"class="btn btn-primary" id="close">Close</a>-->
					<button name="next1" class="btn btn-primary" type="button" id="next1">Next &rarr;</button>
					
				</div>
			</div>
		</form>
		</div>
		<div id="time_sloat" style="display:" > <!--------------- time_sloat start  moadel  2 -------------------></div>
	</div>
	<div id="kkk" style="display:"></div>
	
</div>


<!--------AppSecondModal For Schedule New Appointment-->
<div id="AppSecondModal" style="display:none;">

</div>



<!--date-picker js -->
<script src="<?php //echo plugins_url('/datepicker-assets/js/jquery-1.8.0.js', __FILE__); ?>" type="text/javascript"></script>
<script src="<?php //echo plugins_url('/datepicker-assets/js/jquery.ui.core.js', __FILE__); ?>" type="text/javascript"></script>
<script src="<?php echo plugins_url('/datepicker-assets/js/jquery.ui.datepicker.js', __FILE__); ?>" type="text/javascript"></script>
<script src="<?php //echo plugins_url('/datepicker-assets/js/jquery.ui.widget.js', __FILE__); ?>" type="text/javascript"></script>

<script src="<?php //echo plugins_url('/bootstrap-assets/js/bootstrap.js', __FILE__); ?>" type="text/javascript"></script>
<script src="<?php //echo plugins_url('/bootstrap-assets/js/bootstrap.min.js', __FILE__); ?>" type="text/javascript"></script>

<?php //include('time-slots-calculation.php'); ?>