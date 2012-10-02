<div id="maliya"> 
<?php  
	global $wpdb;
	//http://localhost/wordpress-appointpress/wp-admin/admin.php?page=data_save&bookdate=08-09-2012&service=17&name=silver%20paint&email=hsmaliya15888@gmail.com&phone=87613413&desc=k&time04:30PM
			
			$appointmentdate = date("Y-m-d", strtotime($_GET['bookdate']));
			
			$serviceid = $_GET['serviceid'];
			$serviceduration = $_GET['serviceduration'];
			
			$name = $_GET['name'];
			$email = $_GET['email'];
			$phone = $_GET['phone'];
			$note = $_GET['desc'];
			
			
			$start_time = $_GET['start_time'];
			$start_time_timestamp = strtotime($start_time);
			//calculate end time according to service duration
			$calculate_time = strtotime("+$serviceduration minutes", $start_time_timestamp);
			$end_time =  date('h:i A', $calculate_time ); 

			
			$appointment_key = md5(date("F j, Y, g:i a"));
			$status = "pending";
			$appointment_by = "admin";
			
			$table_name = $wpdb->prefix . "ap_appointments";
			$insert_appointment = "INSERT INTO $table_name (
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
			
			if($wpdb->query($insert_appointment))
			{
				
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
					<p>Your appointment will be appove by admin. And approval mail will be sent to you soon.</p>
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
					

					$admin_email = $AdminEmailDetails['wpemail'];
					$headers[] = "From: Admin <$admin_email>";
					//recipent mail
					wp_mail( $recipent_email, $subject_to_recipent, $wpmail_body_for_recipent, $headers, $attachments = '' );
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
					
					$admin_email = $AdminEmailDetails['phpemail'];
					$headers = "From: Admin <$admin_email>" .
					//client mail
					mail($recipent_email, $subject_to_recipent, $phpmail_body_for_recipent, $headers);
				}
				
				if(get_option('emailtype') == 'smtp')
				{
					$admin_email = $AdminEmailDetails['smtpemail'];
					include('notification/Email.php');
					$admin_email 	= $AdminEmailDetails['smtpemail'];
					$hostname 		= $AdminEmailDetails['hostname'];
					$portno 		= $AdminEmailDetails['portno'];
					$smtpemail 		= $AdminEmailDetails['smtpemail'];
					$password 		= $AdminEmailDetails['password'];
					$recipent_email = $email;
					
					$Email = new Email;
					
					$Email->notifyclient($hostname, $portno, $smtpemail, $password, $admin_email, $recipent_email, $subject_to_recipent, $body_for_recipent, $BlogName);
				}
				
			}

			

?>
 </div>

 