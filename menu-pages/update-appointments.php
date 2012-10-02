
<!--date-picker css -->
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/datepicker-assets/css/jquery-ui-1.8.23.custom.css', __FILE__); ?>' />

<!---load bootstrap css----->
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/bootstrap-assets/css/bootstrap.css', __FILE__); ?>' />

<style type='text/css'>

.error{ 
	color:#FF0000; 
}
</style>

	
<?php 
	global $wpdb;
	if($_GET['updateid'])
	{	
		$appointmentid=$_GET['updateid'];
		$table_name = $wpdb->prefix . "ap_appointments";
		$appointmentdetails="SELECT * FROM $table_name WHERE `id` ='$appointmentid'";
		$appointmentdetails = $wpdb->get_row($appointmentdetails);
		//echo  
	
?>
<div class="bs-docs-example tooltip-demo">

<div style="background:#C3D9FF; margin-bottom:10px; padding-left:10px;">  <h3> Update Appointment(s)</h3> </div>
<!--/******************************** update appointment form **********************************/-->
	<form action="" method="post" name="manageservice">
			<table width="100%" class="table" >
			   <tr>
				<th width="16%" scope="row">Name</th>
				<td width="5%"><strong>:</strong></td>
				<td width="79%"><input name="appname" type="text" id="appname"  value="<?php echo $appointmentdetails->name; ?>" 
				class="inputheight"/>
				&nbsp;<a href="#" rel="tooltip" title="Client Name." ><i  class="icon-question-sign"></i> </a>
				</td>
			  </tr>
			  <tr>
				<th scope="row"><strong>Email</strong></th>
				<td><strong>:</strong></td>
				<td><input name="appemail" type="text" id="appemail"  value="<?php echo $appointmentdetails->email; ?>" 
				class="inputheight"/>
				&nbsp;<a href="#" rel="tooltip" title="Client Email." ><i  class="icon-question-sign"></i> </a>
				</td>
			  </tr>
			   <tr>
				<th scope="row"><strong>Service</strong></th>
				<td><strong>:</strong></td>
				<td><select id="serviceid" name="serviceid">
					  <!--<option value="0">Select service</option>-->
					  <?php //get all service list	
					  	global $wpdb;				 	
					  	$table_name = $wpdb->prefix . "ap_services";
						$service_list = $wpdb->get_results("select * from $table_name"); 
						foreach($service_list as $service) 
						{	?>
							<option value="<?php echo $service->id; ?>" 
								<?php if($appointmentdetails->service_id == $service->id) echo "selected";  ?> >
								<?php echo $service->name; ?>							</option>
						<?php } ?>
			  </select>
			  &nbsp;<a href="#" rel="tooltip" title="Service Name." ><i  class="icon-question-sign"></i> </a>			  
			  </tr>
			  <tr>
				<th scope="row"><strong>Phone</strong></th>
				<td><strong>:</strong></td>
				<td><input name="appphone" type="text" id="appphone"  value="<?php echo $appointmentdetails->phone; ?>" class="inputheight"/ maxlength="12">
				&nbsp;<a href="#" rel="tooltip" title="Client Phone Number." ><i  class="icon-question-sign"></i> </a>
				</td>
			  </tr>
			 <tr>
				<th scope="row"><strong>Star Time</strong></th>
				<td><strong>:</strong></td>
				<td><input name="start_time" type="text" id="start_time"  value="<?php echo $appointmentdetails->start_time; ?>" class="inputheight"/>
				&nbsp;<a href="#" rel="tooltip" title="Appointment Start Time." ><i  class="icon-question-sign"></i> </a>
				</td>
			  </tr>
			  <tr>
				<th scope="row"><strong>End Time</strong></th>
				<td><strong>:</strong></td>
				<td><input name="end_time" type="text" id="end_time"  value="<?php echo $appointmentdetails->end_time; ?>" class="inputheight"/>
				&nbsp;<a href="#" rel="tooltip" title="Appointment End Time." ><i  class="icon-question-sign"></i> </a>
				</td>
			  </tr>
			  
			 
			  <tr>
				<th scope="row"><strong>Date</strong></th>
				<td><strong>:</strong></td>
				<td><input name="start_date" type="text" id="start_date" value="<?php echo $appointmentdetails->date; ?>" class="inputheight"/>
				&nbsp;<a href="#" rel="tooltip" title="Appointment Date." ><i  class="icon-question-sign"></i> </a>
				</td>
			  </tr>
			  <tr>
				<th scope="row"><strong>Description</strong></th>
				<td><strong>:</strong></td>
				<td><textarea name="app_desc" id="app_desc"><?php echo $appointmentdetails->note; ?></textarea>
				&nbsp;<a href="#" rel="tooltip" title="Appointment Description." ><i  class="icon-question-sign"></i> </a>
				</td>
			  </tr>
			   <tr>
				<th scope="row"><strong>Status</strong></th>
				<td><strong>:</strong></td>
				<td><select id="app_status" name="app_status">
				<!--<option value="0">Select Status</option>-->
				<option value="pending" <?php if($appointmentdetails->status == 'pending') echo "selected"; ?> >Pending</option>
				<option value="approved" <?php if($appointmentdetails->status == 'approved') echo "selected"; ?> >Approved</option>
				<option value="cancelled" <?php if($appointmentdetails->status == 'cancelled') echo "selected"; ?> >Cancelled</option>
				<option value="done" <?php if($appointmentdetails->status == 'done') echo "selected"; ?> >Done</option>
				</select>
				&nbsp;<a href="#" rel="tooltip" title="Appointment Status" ><i  class="icon-question-sign"></i> </a>
				</td>
			  </tr>
			  <tr>
				<th scope="row"><strong>Appointment By</strong></th>
				<td><strong>:</strong></td>
				<td><select id="app_appointment_by" name="app_appointment_by">
				<!--<option value="0">Select Status</option>-->
				<option value="admin" <?php if($appointmentdetails->appointment_by == 'admin') echo "selected"; ?> >Admin</option>
				<option value="user" <?php if($appointmentdetails->appointment_by == 'user') echo "selected"; ?> >User</option>
				</select>
				&nbsp;<a href="#" rel="tooltip" title="Appointment Booked By." ><i  class="icon-question-sign"></i> </a>
				</td>
			  </tr>
			  
			  <tr>
				<th scope="row">&nbsp;</th>
				<td>&nbsp;</td>
				<td> <?php if($_GET['updateid'])	{	?>
					<button id="updateppointments" type="submit" class="btn btn-primary" name="updateppointments" value="<?php echo $appointmentdetails->id; ?>">Update</button>
					<?php } else {?>
					<!--<button id="saveservice" type="submit" class="btn btn-primary" name="saveservice">Create</button>-->
					<?php } ?>
					<a href="?page=manage-appointments" class="btn btn-primary">Cancel</a>				</td>
			  </tr>
		  </table>
	</form>
	<?php } ?>
	
	<!--validation js lib-->
<script src="<?php echo plugins_url('/js/jquery.min.js', __FILE__); ?>" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function () {
	
	$(function(){
		
		<!---------------load date and time picker ------------------>
		$('#start_time').timepicker({
			ampm: true,
			timeFormat: 'hh:mm TT',
		});
		
		$('#end_time').timepicker({
			ampm: true,
			timeFormat: 'hh:mm TT',
		});
		
		$('#start_date').datepicker({
			minDate: 0,
			dateFormat: 'dd-mm-yy',
			
		});
		
		/*$('#end_date').datepicker({
			minDate: 0,
			dateFormat: 'dd-mm-yy',
			
		});*/
	});	
	
	// update appointment validation
	$('#updateppointments').click(function() { 

				$(".error").hide();
			//start-date appname appemail serviceid appphone start_time end_time start_date
			var appname = $("#appname").val();
			if(appname == ''){
				$("#appname").after('<span class="error"><br><strong>Name cannot be blank.</strong></span>');
				return false;
			}
			var appemail = $("input#appemail").val();  
			var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if (appemail == "")
			 { 
			 	$("#appemail").after('<span class="error"><br><strong>Eamil field cannot be blank.</strong></span>');
				return false;  
			 }  
			else
			{	if(regex.test(appemail) == false )
				{
					$("#appemail").after('<span class="error"><br><strong>Invalid email address</strong></span>');
					return false; 
				}
											
			}
			//start-date
			var appphone = $("#appphone").val();
			if(appphone == ''){
				$("#appphone").after('<span class="error"><br><strong>Phone field cannot be blank.</strong></span>');
				return false;
			}
			else
			{	var appphone = isNaN(appphone);
				if(appphone == true) 
				{ 	$("#appphone").after('<span class="error"><br><strong>Invalid Phone number.</strong></span>');  
					return false;  
				}
			}  
			
			var start_time = $("#start_time").val();
			if(start_time == ''){
				$("#start_time").after('<span class="error"><br><strong>Start Time  cannot be blank.</strong></span>');
				return false;
			}
			var end_time = $("#end_time").val();
			if(end_time == ''){
				$("#end_time").after('<span class="error"><br><strong>End Time cannot be blank.</strong></span>');
				return false;
			}
			var start_date = $("#start_date").val();
			if(start_date == ''){
				$("#start_date").after('<span class="error"><br><strong>Start Date cannot be blank.</strong></span>');
				return false;
			}
			
		
		});
		
});
</script>

<!--time-picker js -->
<script src="<?php echo plugins_url('/timepicker-assets/js/jquery-1.7.2.min.js', __FILE__); ?>" type="text/javascript"></script>
<script src="<?php echo plugins_url('/timepicker-assets/js/jquery-ui.min.js', __FILE__); ?>" type="text/javascript"></script>
<script src="<?php echo plugins_url('/timepicker-assets/js/jquery-ui-timepicker-addon.js', __FILE__); ?>" type="text/javascript"></script>
<?php //include(plugins_url('/timepicker-assets/timepickercss.php', __FILE__));?>
<?php 
	
	if(isset($_POST['updateppointments']))
	{
			//print_r($_POST);
			global $wpdb;
			$up_app_id = $_POST['updateppointments'];
			$name = $_POST['appname'];
			$email = $_POST['appemail'];
			$serviceid = $_POST['serviceid'];
			$phone = $_POST['appphone'];
			$start_time = $_POST['start_time'];
			$end_time = $_POST['end_time'];
			//$bookdate= $_POST['start_date'];
			$appointmentdate = date("Y-m-d", strtotime($_POST['start_date']));
			$note = $_POST['app_desc'];
			
			//$appointment_key = md5(date("F j, Y, g:i a"));
			$status =  $_POST['app_status'];
			$appointment_by = $_POST['app_appointment_by'];
			
			$appointmentstable_name = $wpdb->prefix . "ap_appointments";
			$update_appointment="UPDATE `$appointmentstable_name` SET `name` = '$name',
								`email` = '$email',
								`service_id` = '$serviceid',
								`phone` = '$phone',
								`start_time` = '$start_time',
								`end_time` = '$end_time',
								`date` = '$appointmentdate',
								`note` = '$note',
								`status` = '$status',
								`appointment_by` = '$appointment_by' WHERE `id` ='$up_app_id';";
			
			if($wpdb->query($update_appointment))
			{
			
				//send notification to client if appointment approved or cancelled
				if($status == 'approved' || $status == 'cancelled' )
				{
					$GetAppKey = $wpdb->get_row("SELECT * FROM `$appointmentstable_name` WHERE `id` = '$up_app_id' ", OBJECT);
					
					$MangeAppointmentUrl = site_url().'/wp-admin/admin.php?page=manage-appointments';
					$BlogUrl = site_url().'/wp-admin';
					$BlogName = get_bloginfo();
					
					$ServiceTable = $wpdb->prefix."ap_services";
					$ServiceData = $wpdb->get_row("SELECT * FROM `$ServiceTable` WHERE `id` = '$serviceid'", OBJECT);
				
					$subject_to_recipent = "$BlogName: Your appointment has been $status.";
					$body_for_recipent = "<p>Dear <b>".ucwords($name).".</b></p>
					<p>Your appointment has been $status by admin.</strong>.</p>
					Your Appointment Details As:<br>
					<hr>
					<strong>Appointment For:</strong> ".ucwords($ServiceData->name)." <br>
					<strong>Appointment Note:</strong> $note <br>
					<strong>Appointment Status:</strong> $status <br>
					<strong>Appointment Date:</strong> $appointmentdate <br>
					<strong>Appointment Time:</strong> $start_time To $end_time <br>
					<strong>Appointment Key:</strong> $GetAppKey->appointment_key <br>
					<hr>
					<p>Thank You!!!</p>
					";
					
					
					$AdminEmailDetails = unserialize(get_option('emaildetails'));
					$recipent_email = $email;
					
					//send notification & chech mail type
					if(get_option('emailtype') == 'wpmail')
					{
						$wpmail_body_for_recipent = "
			Dear ".ucwords($name).",
			Your appointment has been $status by admin.

			Your Appointment Details As:
			Appointment For: ".ucwords($ServiceData->name)."
			Appointment Note: $note
			Appointment Status: $status
			Appointment Date: $appointmentdate
			Appointment Time: $start_time To $end_time
			Appointment Key: $GetAppKey->appointment_key
					
			Thank You!!!
			";
						
						$admin_email = $AdminEmailDetails['wpemail'];
						$headers[] = "From: Admin <$admin_email>";
						//recipent mail
						wp_mail( $recipent_email, $subject_to_recipent, $wpmail_body_for_recipent, $headers, $attachments = '' );
					}
					
					if(get_option('emailtype') == 'phpmail')
					{
						$phpmail_body_for_recipent = "
			Dear ".ucwords($name).",
			Your appointment has been $status by admin.

			Your Appointment Details As:
			Appointment For: ".ucwords($ServiceData->name)."
			Appointment Note: $note
			Appointment Status: $status
			Appointment Date: $appointmentdate
			Appointment Time: $start_time To $end_time
			Appointment Key: $GetAppKey->appointment_key
					
			Thank You!!!
			";
						
						$admin_email = $AdminEmailDetails['phpemail'];
						$headers = "From: Admin <$admin_email>" .
						//client mail
						mail($recipent_email, $subject_to_recipent, $phpmail_body_for_recipent, $headers);
					}
					
					if(get_option('emailtype') == 'smtp')
					{
						$admin_email = $AdminEmailDetails['smtpemail'];
						include('notification/Email.php');
						echo $admin_email 	= $AdminEmailDetails['smtpemail'];
						echo $hostname 		= $AdminEmailDetails['hostname'];
						echo $portno 		= $AdminEmailDetails['portno'];
						echo $smtpemail 	= $AdminEmailDetails['smtpemail'];
						echo $password 		= $AdminEmailDetails['password'];
						echo $recipent_email = $email;
						
						$Email = new Email;
						
						$Email->notifyclient($hostname, $portno, $smtpemail, $password, $admin_email, $recipent_email, $subject_to_recipent, $body_for_recipent, $BlogName);
					}
					
				}// end of update check
				
				//redirect to updated appointment details page
				echo "<script>location.href='?page=update-appointment&viewid=$up_app_id';</script>";	
				
			}// end of if query
					
	}// end of isset
  ?>
  <!--------------------- appoitnemnt view page--------------------------------->
  <?php if(isset($_GET['viewid']))
  	{	
		$appid=$_GET['viewid'];
		$table_name = $wpdb->prefix . "ap_appointments";
		$appdetails="SELECT * FROM $table_name WHERE `id` ='$appid'";
		$appdetails = $wpdb->get_row($appdetails);
		  
	
	?>
	
<div style="background:#C3D9FF; margin-bottom:10px; padding-left:10px;">  <h3> View Appointment(s) : <?php echo ucwords($appdetails->name); ?> 
	</h3> 	 </div>
	<!--/******************************** update appointment form **********************************/-->
				<table width="100%" class="table" >
				  <tr>
					<th width="16%" scope="row">Name</th>
					<td width="5%"><strong>:</strong></td>
					<td width="79%"><em><?php echo ucwords($appdetails->name); ?></em></td>
				  </tr>
				  <tr>
					<th scope="row">Email</th>
					<td><strong>:</strong></td>
					<td><em><?php echo $appdetails->email; ?></em></td>
				  </tr>
				  <tr>
					<th scope="row">Service</th>
					<td><strong>:</strong></td>
					<td><em>
				    <?php // $appdetails->service_id;
						$table_name = $wpdb->prefix . "ap_services";
						$servicedetails= $wpdb->get_row("SELECT * FROM $table_name WHERE `id` ='$appdetails->service_id'");	
						echo ucwords($servicedetails->name);	
						 ?>
					</em> </td>
				  </tr>
				  <tr>
					<th scope="row">Phone</th>
					<td><strong>:</strong></td>
					<td><em><?php echo $appdetails->phone; ?></em></td>
				  </tr>
				  <tr>
					<th scope="row">Start Time</th>
					<td><strong>:</strong></td>
					<td><em><?php echo $appdetails->start_time; ?></em></td>
				  </tr>
				  <tr>
					<th scope="row">End Time</th>
					<td><strong>:</strong></td>
					<td><em><?php echo $appdetails->end_time; ?></em></td>
				  </tr>
				  <tr>
					<th scope="row">Date</th>
					<td><strong>:</strong></td>
					<td><em><?php echo $appdetails->date; ?></em></td>
				  </tr>
				  <tr>
					<th scope="row">Description</th>
					<td><strong>:</strong></td>
					<td><em><?php echo ucfirst($appdetails->note); ?></em></td>
				  </tr>
				   <tr>
					<th scope="row">Appointment Key</th>
					<td><strong>:</strong></td>
					<td><em><?php echo $appdetails->appointment_key; ?></em></td>	
				  </tr>
				   <tr>
					<th scope="row">Status</th>
					<td><strong>:</strong></td>
					<td><em><?php echo ucfirst($appdetails->status); ?></em></td>	
				  </tr>
				   <tr>
					<th scope="row">Appointment By</th>
					<td><strong>:</strong></td>
					<td><em><?php echo ucfirst($appdetails->appointment_by); ?></em></td>	
				  </tr>
				   <tr>
				     <th scope="row">&nbsp;</th>
				     <td>&nbsp;</td>
				     <td><a href="?page=manage-appointments" class="btn btn-primary">Back</a></td>
			      </tr>
				</table>


	
<?php 	}  ?>
<!---Tooltip js ---------->
	<script src="<?php echo plugins_url('/bootstrap-assets/js/bootstrap-tooltip.js', __FILE__); ?>" type="text/javascript"></script>
	<script src="<?php echo plugins_url('/bootstrap-assets/js/bootstrap-affix.js', __FILE__); ?>" type="text/javascript"></script>
    <script src="<?php echo plugins_url('/bootstrap-assets/js/application.js', __FILE__); ?>" type="text/javascript"></script>
</div>
