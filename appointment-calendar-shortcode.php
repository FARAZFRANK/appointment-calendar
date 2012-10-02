<?php

add_shortcode( 'APCAL', 'appointment_calendar_shortcode' );

function appointment_calendar_shortcode()
{
	//wp_mail( 'farazfrank777@gmail.com', 'jksdahfash','hjghjghghjg' );
	?>
	
	<!---load full calendar js--->
	<script type='text/javascript' src='<?php echo plugins_url('/menu-pages/fullcalendar-assets/js/jquery-1.7.1.min.js', __FILE__); ?>'></script>
	<script type='text/javascript' src='<?php echo plugins_url('/menu-pages/fullcalendar-assets/js/jquery-ui-1.8.17.custom.min.js', __FILE__); ?>'></script>
	<script type='text/javascript' src='<?php echo plugins_url('/menu-pages/fullcalendar-assets/js/fullcalendar.min.js', __FILE__); ?>'></script>
	
	<!---load full calendar css--->
	<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/menu-pages/fullcalendar-assets/css/fullcalendar.css', __FILE__); ?>' />
	<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/menu-pages/fullcalendar-assets/css/fullcalendar.print.css', __FILE__); ?>' media='print' />
	
	
	<!--date-picker css -->
	<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/menu-pages/datepicker-assets/css/jquery-ui-1.8.23.custom.css', __FILE__); ?>' />
	
	
	<!---load bootstrap css----->
	<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/menu-pages/bootstrap-assets/css/shortcode-bootstrap.css', __FILE__); ?>' />
	
	<?php
		//save appointment and email admin & client/customer
	if(isset($_POST['booknowapp']))
	{
		global $wpdb;
		$name = $_POST['clientname'];
		$email = $_POST['clientemail'];
		$phone = $_POST['clientphone'];
		$note = $_POST['clientnote'];
		$appointmentdate= date("Y-m-d", strtotime($_POST['appointmentdate']));
		$serviceid = $_POST['serviceid'];
		$serviceduration = $_POST['serviceduration'];
		$start_time = $_POST['start_time'];
			
		$start_time_timestamp = strtotime($start_time);
		//calculate end time according to service duration
		$calculate_time = strtotime("+$serviceduration minutes", $start_time_timestamp);
		$end_time =  date('h:i A', $calculate_time ); 

			
		$appointment_key = md5(date("F j, Y, g:i a"));
		$status = "pending";
		$appointment_by = "user";
			
		$table_name = $wpdb->prefix . "ap_appointments";
		$AddAppointment_sql ="INSERT INTO $table_name (
														`id` ,
														`name` ,
														`email` ,
														`service_id` ,
														`phone` ,
														`start_time` ,
														`end_time` ,
														`date` ,
														`note` ,
														`appointment_key` ,
														`status` ,
														`appointment_by`
													)
		VALUES (NULL , '$name', '$email', '$serviceid', '$phone', '$start_time', '$end_time', '$appointmentdate', '$note', '$appointment_key', '$status', '$appointment_by');";
			
			if($wpdb->query($AddAppointment_sql))
			{
				echo "<div class='alert alert-success'><strong>Thank you for scheduling appointment with us.<br>A confirmation mail will be forward to you soon after admin approval.</strong></div>";
				
				$MangeAppointmentUrl = site_url().'/wp-admin/admin.php?page=manage-appointments';
				$BlogUrl = site_url().'/wp-admin';
				$BlogName = get_bloginfo();
				
				$ServiceTable = $wpdb->prefix."ap_services";
				$ServiceData = $wpdb->get_row("SELECT * FROM `$ServiceTable` WHERE `id` = '$serviceid'", OBJECT);
			
				
				
				$subject_to_recipent = "$BlogName: Your Appointment Confirmation Mail.";
				$body_for_recipent = "<p>Dear <b>".ucwords($name).".</b></p>
					<p>Thank you for scheduling appointment with <strong>$BlogName</strong>.</p>
					Your Appointment Details As:<br>
					<hr>
					<strong>Appointment For:</strong> ".ucwords($ServiceData->name)." <br>
					<strong>Appointment Note:</strong> $note <br>
					<strong>Appointment Status:</strong> Pending <br>
					<strong>Appointment Date:</strong> $appointmentdate <br>
					<strong>Appointment Time:</strong> $start_time To $end_time <br>
					<strong>Appointment Key:</strong> $appointment_key <br>
					<hr>
					<p>You will get a confirmation mail once admin accepts the appointment.</p>
					<p>Thank You!!!</p>
					";
					
				$subject_to_admin = "$BlogName: One New Appointment Has Been Arrived.";
				$body_for_admin = "Dear <b>Admin</b>,<br>
					<p>One New Appointment Scheduled By '<strong>".ucwords($name)."'</strong>.</p>
					<p>Appointment Details As:</p>
					<hr>
					<strong>Appointment By:</strong> ".ucwords($name)." <br>
					<strong>Appointment For:</strong> ".ucwords($ServiceData->name)." <br>
					<strong>Appointment Status:</strong> Pending <br>
					<strong>Appointment Date:</strong> $appointmentdate <br>
					<strong>Appointment Time:</strong> $start_time To $end_time <br>
					<strong>Appointment Note:</strong> $note <br>
					<strong>Appointment Key:</strong> $appointment_key <br>
					<strong>Take Action:</strong>
					<a href='$MangeAppointmentUrl' target=_blank>Approve Appointment</a> OR 
					<a href='$MangeAppointmentUrl' target=_blank>Cancel Appointment</a> <br>
					<hr>
					Login to manage appointment at $BlogName dashboard: <a href='$BlogUrl' target='_blank'>Login</a>
					<p>Thank You!!!</p>
					";
				$AdminEmailDetails = unserialize(get_option('emaildetails'));
				$recipent_email = $email;
				
				//send notification & chech mail type
				if(get_option('emailtype') == 'wpmail')
				{
					$wpmail_body_for_recipent = "
					Dear ".ucwords($name).",
					Thank you for scheduling appointment with $BlogName.

					Your Appointment Details As:
					Appointment For: ".ucwords($ServiceData->name)."
					Appointment Note: $note
					Appointment Status: Pending
					Appointment Date: $appointmentdate
					Appointment Time: $start_time To $end_time
					Appointment Key: $appointment_key
					
					Your appointment will be appove by admin. And approval mail will be sent to you soon.
					Thank You!!!
					";
					
					$wpmail_body_for_admin = "
					Dear Admin,
					One New Appointment Scheduled By '".ucwords($name)."'.
					
					Appointment Details As:
					Appointment By: ".ucwords($name)."
					Appointment For: ".ucwords($ServiceData->name)."
					Appointment Status: Pending
					Appointment Date: $appointmentdate
					Appointment Time: $start_time To $end_time
					Appointment Note: $note
					Appointment Key: $appointment_key
					Take Action:
					Approve Appointment: $MangeAppointmentUrl
					OR 
					Cancel Appointment: $MangeAppointmentUrl
					
					Login to manage appointment at $BlogName dashboard: $BlogUrl
					Thank You!!!
					";
					$admin_email = $AdminEmailDetails['wpemail'];
					$headers[] = "From: Admin <$admin_email>";
					//recipent mail
					wp_mail( $recipent_email, $subject_to_recipent, $wpmail_body_for_recipent, $headers, $attachments = '' );
					// admin mail
					wp_mail( $admin_email, $subject_to_admin, $wpmail_body_for_admin, $headers, $attachments = '' );
				}
				
				if(get_option('emailtype') == 'phpmail')
				{
					$phpmail_body_for_recipent = "
					Dear ".ucwords($name).",
					Thank you for scheduling appointment with $BlogName.

					Your Appointment Details As:
					Appointment For: ".ucwords($ServiceData->name)."
					Appointment Note: $note
					Appointment Status: Pending
					Appointment Date: $appointmentdate
					Appointment Time: $start_time To $end_time
					Appointment Key: $appointment_key
					
					Your appointment will be appove by admin. And approval mail will be sent to you soon.
					Thank You!!!
					";
					
					$phpmail_body_for_admin = "
					Dear Admin,
					One New Appointment Scheduled By '".ucwords($name)."'.
					
					Appointment Details As:
					Appointment By: ".ucwords($name)."
					Appointment For: ".ucwords($ServiceData->name)."
					Appointment Status: Pending
					Appointment Date: $appointmentdate
					Appointment Time: $start_time To $end_time
					Appointment Note: $note
					Appointment Key: $appointment_key
					Take Action:
					Approve Appointment: $MangeAppointmentUrl
					OR 
					Cancel Appointment: $MangeAppointmentUrl
					
					Login to manage appointment at $BlogName dashboard: $BlogUrl
					Thank You!!!
					";
					
					$admin_email = $AdminEmailDetails['phpemail'];
					$headers = "From: Admin <$admin_email>" .
					//client mail
					mail($recipent_email, $subject_to_recipent, $phpmail_body_for_recipent, $headers);
					// admin mail
					mail( $admin_email, $subject_to_admin, $phpmail_body_for_admin, $headers);
				}
				
				if(get_option('emailtype') == 'smtp')
				{
					$admin_email = $AdminEmailDetails['smtpemail'];
					include('menu-pages/notification/Email.php');
					$admin_email 	= $AdminEmailDetails['smtpemail'];
					$hostname 		= $AdminEmailDetails['hostname'];
					$portno 		= $AdminEmailDetails['portno'];
					$smtpemail 		= $AdminEmailDetails['smtpemail'];
					$password 		= $AdminEmailDetails['password'];
					$recipent_email = $email;
					
					$Email = new Email;
					$Email->notifyadmin($hostname, $portno, $smtpemail, $password, $admin_email, $subject_to_admin, $body_for_admin, $BlogName);
					$Email->notifyclient($hostname, $portno, $smtpemail, $password, $admin_email, $recipent_email, $subject_to_recipent, $body_for_recipent, $BlogName);
				}
			}
			
	}
	?>
	
	
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
			timeFormat: 'h:mm{-h:mmtt }',
			firstDay: <?php echo get_option('calendar_start_day'); ?>,
			slotMinutes: <?php echo get_option('calendar_slot_time'); ?>,
			minTime: <?php  echo date("G", strtotime(get_option('day_start_time')));?>,
			defaultView: '<?php echo get_option('calendar_view'); ?>',
			maxTime: <?php  echo date("G", strtotime(get_option('day_end_time')));?>,
			
			
			selectable: true,
			selectHelper: false,
			select: function(start, end, allDay) {
					$('#AppFirstModal').show();
				},
			
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
				
								title: 'Booked',
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

			],
		});
		
<!------------- Modal Form Works -------------------->
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
				$("#service").after('<span class="error"><br><strong>Select Any Service.</strong><br></span>');
				return false;
			}
			
		});
		
		<!-------Second Modal form validation--------------->
		$('#booknowapp').click(function(){
			$(".error").hide();

			var start_time = $('input[name=start_time]:radio:checked').val();
			if(!start_time)
			{
				$("#timesloatbox").after("<span class='error'><strong>Select any time.</strong></span>");
				return false;  
			}
			
			if( !$('#clientname').val() )
			{
				$("#clientname").after('<span class="error"><br><strong>This field required.</strong></span>');
				return false;
			}
			else if(!isNaN( $('#clientname').val() )) 
			{
				$("#clientname").after("<span class='error'><p><strong>Invalid field value.</strong></p></span>");
				return false;  
			}
			
			var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if( !$('#clientemail').val() )
			{
				$("#clientemail").after('<span class="error"><br><strong>This field required.</strong></span>');
				return false;
			}
			else
			{	if(regex.test($('#clientemail').val()) == false )
				{	
					$("#clientemail").after("<span class='error'><p><strong>Invalid field value.</strong></p></span>");  
					return false; 
				}
			}	

			if( !$('#clientphone').val() )
			{
				$("#clientphone").after('<span class="error"><br><strong>This field required.</strong></span>');
				return false;
			}
			else if(isNaN( $('#clientphone').val() )) 
			{
				$("#clientphone").after("<span class='error'><p><strong>Invalid field value.</strong></p></span>");
				return false;  
			}
		});
		
		//back button show first modal
		$('#back').click(function(){
			$('#AppFirstModal').show();
			$('#AppSecondModal').hide();
		});
		
		
			
});	
		

<!------------- Modal Form Works -------------------->
		

	</script>
	
	<style type='text/css'>
	.error{ 
		color: #FF0000; 
	}
	</style>
	
	<!----- Add New Appointment Button -------->
	<div id=bkbtndiv align="center" style="padding:10px;">
		<button name="addappointment" class="btn btn-primary" type="submit" id="addappointment">Schedule An Appointment</button>
	</div>
	
	<!---------Show appointment calendar ------------>
	<div id='calendar'>
			<div align="right">Appointments powered by: <a href="http://appointzilla.com/" title="Appointment Scheduling plugin for Wordpress" target="_blank">AppointZilla</a></div>
	</div>
	
	
	<!--------AppFirstModal For Schedule New Appointment-->
	<div id="AppFirstModal" style="display:none;">
		<div class="modal" id="myModal" style="z-index:9999;">
			<form action="" method="post" name="addnewappointment" id="addnewappointment">
				<div class="modal-info">
					<div class="alert alert-info">
						<div align="center"><a href="#" style="float:right; margin-right:-4px; margin-top:12px;" id="close"><i class="icon-remove"></i></a>
					  </div>
						<h4 align="center" >Schedule New Appointment</h4>
						<div align="center">Setect Time & Service</div>
					</div>
				</div>
				
				<div class="modal-body">
					<div id="firdiv" style="float:left;">
						<div id="datepicker"></div>
					</div>
					
					<div id="secdiv" style="float:right;" >
						<h5><strong>Your Appointment Date:</strong></h5>
						<input name="appdate" id="appdate" type="text" readonly="" />
					<?php
						global $wpdb;
						$ServiceTable = $wpdb->prefix."ap_services";
						$findservice_sql = "SELECT * FROM `$ServiceTable` WHERE `availability` = 'yes'";
						$AllService = $wpdb->get_results($findservice_sql, OBJECT);
					?><br><br>
						  <h5><strong>Select Service:</strong></h5>
							<select name="service" id="service">
								<option value="0">Select Service</option>
								<?php
								foreach($AllService as $Service)
									echo "<option value='$Service->id'>".ucwords($Service->name)." (".$Service->duration."min/$$Service->cost)</option>";
								?>
							</select>
						<br>
						<!--<a href="#"class="btn btn-primary" id="close">Close</a>-->
						<button name="next1" class="btn btn-primary" type="submit" id="next1">Next &rarr;</button>
					</div>
				</div>
			
			</form>
		  </div>
	</div>
	<!--------AppSecondModal For Schedule New Appointment-->
	


	
	
	<!--date-picker js -->
	<script src="<?php echo plugins_url('/menu-pages/datepicker-assets/js/jquery.ui.datepicker.js', __FILE__); ?>" type="text/javascript"></script>
	



<?php
	if(isset($_POST['next1']))
	{
	?>
	<div id="AppSecondModal">
	<div class="modal" id="myModal" style="z-index:9999;">
		<form method="post" name="appointment-form2" id="appointment-form2" action="">
		<div class="modal-info">
		  <div class="alert alert-info">
				<a href="" style="float:right; margin-right:-4px; margin-top:12px;" id="close"><i class="icon-remove"></i></a>
				<h4 align="center">Schedule New Appointment</h4>
				<div align="center">Setect Time & Fill Up Form </div>
			</div>
		</div>

		<div class="modal-body">
			<div id="timesloatbox" class="alert alert-block" style="float:left; height:auto; width:auto; border:#00CC00 0px solid;">
			<!-------slots time calulation-------->
			<?php
				/*
				 * time-slots calculation
				 *************************/
				
					global $wpdb;
					$ServiceId =  $_POST['service']; //2;	echo "<br>";
					
					$ServiceTableName = $wpdb->prefix."ap_services";
					$FindService_sql = "SELECT `name`, `duration` FROM `$ServiceTableName` WHERE `id` = '$ServiceId'";	
					$ServiceData = $wpdb->get_row($FindService_sql, OBJECT);
					$ServiceDuration = $ServiceData->duration;
					
					$AppointmentDate = date("Y-m-d", strtotime($_POST['appdate'])); //date("Y-m-d"); echo "<br>"; //assign selected date by user	
					
					$Biz_start_time = get_option('day_start_time');
					$Biz_end_time = get_option('day_end_time');
					
					$AllSlotTimesList = array();
					
					$AppPreviousTimes = array();
					$AppNextTimes = array();
					$AppBetweenTimes = array();
					
					$EventBetweenTimes = array();
					
					$DisableSlotsTimes = array();
					
					$TimeOffTableName = $wpdb->prefix."ap_events";
					//if today is any allday timeoff then show msg no time avilable today
					$TodaysAllDayFetchEvents_sql = "SELECT `start_time`, `end_time` FROM `$TimeOffTableName` WHERE date('$AppointmentDate') between `start_date` AND `end_date` AND `allday` = '1'";
					
					$TodaysAllDayEventData = $wpdb->get_results($TodaysAllDayFetchEvents_sql, OBJECT);
					
					if($TodaysAllDayEventData)
					{	
						echo "<div class='alert alert-error'><strong>Sorry! No Time Available Today.</strong></div><hr size='5' />";
					}
					else
					{
						echo "<div class='alert alert-info'>Available Time For <strong>'$ServiceData->name'</strong> On <strong>'".date("l, jS M.", strtotime($AppointmentDate))."'</strong></div><hr size='5' />";
						
						//Caluculate all time slots according to today's biz hours
						$start = strtotime($Biz_start_time);
						$end = strtotime($Biz_end_time);
						
						for( $i = $start; $i <= $end; $i += (60*$ServiceDuration)) 
						{
							$AllSlotTimesList[] = date('h:i A', $i);
						} 
						
						//Fetch All today's appointments and calculate disable slots
						$AppointmentTableName = $wpdb->prefix."ap_appointments";
						$AllAppointments_sql = "SELECT `start_time`, `end_time` FROM `$AppointmentTableName` WHERE `date`= '$AppointmentDate'"; 
						
						$AllAppointmentsData = $wpdb->get_results($AllAppointments_sql, OBJECT);
						//print_r(count($AllAppointmentsData)); echo "<br>";
						if($AllAppointmentsData)
						{
							foreach($AllAppointmentsData as $Appointment)
							{
								$AppStartTimes[] = date('h:i A', strtotime( $Appointment->start_time ) );
								$AppEndTimes[] = date('h:i A', strtotime( $Appointment->end_time ) );
								
								
								//now calculate 5min slots between appointment's start_time & end_time
								$start_et = strtotime($Appointment->start_time);
								$end_et = strtotime($Appointment->end_time);
								for( $i = $start_et; $i < $end_et; $i += (60*(5))) //make 15-10=5min slot
								{
									$AppBetweenTimes[] = date('h:i A', $i);
								}
							}
						
								//calculating  Next & Previous time of booked appointments
								foreach($AllSlotTimesList as $single)
								{
									if(in_array($single, $AppStartTimes))
									{
										//get next time
										$time = $single; 												
										$event_length = $ServiceDuration-5; 	// Service duration time	-  slot time							
										$timestamp = strtotime("$time"); 								
										$endtime = strtotime("+$event_length minutes", $timestamp); 	
										$next_time = date('h:i A', $endtime);				//echo "<br>";
										//calculate next time				
										$start = strtotime($single);
										$end = strtotime($next_time);
										for( $i = $start; $i <= $end; $i += (60*(5))) //making 5min diffrance slot
										{
											$AppNextTimes[] = date('h:i A', $i);
										}
										
										//get previous time
										$time1 = $single; 												
										$event_length1 = $ServiceDuration-5; 	// 60min Service duration time - 15 slot time 								
										$timestamp1 = strtotime("$time1"); 								
										$endtime1 = strtotime("-$event_length1 minutes", $timestamp1); 	
										$next_time1 = date('h:i A', $endtime1); 						
										//calculate previous time
										$start1 = strtotime($next_time1);
										$end1 = strtotime($single);
										for( $i = $start1; $i <= $end1; $i += (60*(5))) //making 5min diff slot
										{
											$AppPreviousTimes[] = date('h:i A', $i);
										}
									}
								}
								//end calculating Next & Previous time of booked appointments
							
						} // end if $AllAppointmentsData
						
				
							//Fetch All today's timeoff and calculate disable slots
							$EventTableName = $wpdb->prefix."ap_events";
							$AllEventts_sql = "SELECT `start_time`, `end_time` FROM `$EventTableName` WHERE date('$AppointmentDate') between `start_date` AND `end_date` AND `allday` = '0'";
							$AllEventsData = $wpdb->get_results($AllEventts_sql, OBJECT);
							if($AllEventsData)
							{
								foreach($AllEventsData as $Event)
								{
									$start_et = strtotime($Event->start_time);
									$end_et = strtotime($Event->end_time);
									for( $i = $start_et; $i < $end_et; $i += (60*(5))) //making 5min slot
									{
										$EventBetweenTimes[] = date('h:i A', $i);
									}
									//echo $Event->start_time; echo "<br>";
								}
							}
							
							$DisableSlotsTimes = array_merge($AppBetweenTimes, $AppPreviousTimes, $AppNextTimes, $EventBetweenTimes);
							//print_r($AppNextTimes);
							unset($AppBetweenTimes);
							unset($AppPreviousTimes);
							unset($AppNextTimes);
							unset($EventBetweenTimes);
						
							foreach($AllSlotTimesList as $Single)
							{
								if(in_array($Single, $DisableSlotsTimes))
								{
									// disable slots
									?>
									
									<div style="width:100px; float:left; padding:2px;">
										<input name="start_time" id="start_time" type="radio" disabled="disabled"  value="<?php echo $Single; ?>"/>&nbsp;<?php echo $Single; ?>
									</div>
									<?php
									$Disable[] = $Single;
								}
								else
								{
									// enable slots
									?>
									<div style="width:100px; float:left; padding:2px;">
										<input name="start_time" id="start_time" type="radio" style="margin: 0 0 0;" value="<?php echo $Single; ?>"/>&nbsp;<?php echo $Single; ?>
									</div>
									<?php
									$Enable[] = $Single;
								}
							}// end foreach
							
							unset($DisableSlotsTimes);
							
					} // end else
					
			?>
			</div>
			<?php
			if(!$Enable)
			{
				echo "<br><p align=center class='alert alert-error'><strong>Sorry! Today's all appointments has been booked.</strong></p>";
				echo '<a href="#"class="btn btn-primary" id="back" >&larr; Back</a>';
			}
			else
			{
			?>
			<hr size='5' />
				
					<input type="hidden" name="serviceid" id="serviceid" value="<?php echo $_POST['service']; ?>" />
					<input type="hidden" name="appointmentdate" id="appointmentdate"  value="<?php echo $_POST['appdate']; ?>" />
					<input type="hidden" name="serviceduration" id="serviceduration"  value="<?php echo $ServiceDuration; ?>" />
					<table>
					  <tr>
						<td width="15%" align="left" scope="row"><strong>Name</strong></td>
						<td align="center"><strong>:</strong></td>
						<td><input type="text" name="clientname" id="clientname"/></td>
					  </tr>
					 <tr>
						<td align="left" scope="row"><strong>Email</strong></td>
						<td align="center"><strong>:</strong></td>
						<td><input type="text" name="clientemail" id="clientemail"></td>
					  </tr>
					  <tr>
						<td align="left" scope="row"><strong>Phone</strong></td>
						<td align="center"><strong>:</strong></td>
						<td><input name="clientphone" type="text" id="clientphone" maxlength="12"/>
						<br/><label>Eg : 1234567890 </label></td>
					  </tr>
					  <tr>
						<td align="left" valign="middle" scope="row"><strong>Special Instruction</strong></td>
						<td align="center" valign="middle"><br><strong>:</strong></td>
						<td valign="top"><textarea name="clientnote" id="clientnote"></textarea></td>
					  </tr>
					  <tr>
					  	<td>&nbsp;</td>
						<td>&nbsp;</td>
					    <td><a href="#"class="btn btn-primary" id="back" >&larr; Back</a>
                          <button name="booknowapp" class="btn btn-primary" type="submit" id="booknowapp">Book Now</button></td>
					  </tr>
		  </table>
		  <?php
		  }
		  ?>
		  </div>
		 </div>
	</form>
	</div>
</div>
	<?php
	}// end of isset next1
	
}//end of short code function
?>
