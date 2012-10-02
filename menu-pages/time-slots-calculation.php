<?php
/*
 * time-slots calculation
 *************************/

	global $wpdb;
	$ServiceId =  $_GET['service']; //2;	echo "<br>";
	
	$ServiceTableName = $wpdb->prefix."ap_services";
	$FindService_sql = "SELECT `name`, `duration` FROM `$ServiceTableName` WHERE `id` = '$ServiceId'";	
	$ServiceData = $wpdb->get_row($FindService_sql, OBJECT);
	$ServiceDuration = $ServiceData->duration;
	
	$AppointmentDate = date("Y-m-d", strtotime($_GET['bookdate'])); //date("Y-m-d"); echo "<br>"; //assign selected date by user	
	
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
		echo "<div class='alert alert-error'>Sorry! No Time Available Today.</div>";
	}
	else
	{
		echo "<div class='alert alert-info'>Available Time For <strong>'$ServiceData->name'</strong> On <strong>".date("l, jS F", strtotime($AppointmentDate))."</strong></div><hr size='5' />";
		
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
						<input name="start_time" id="start_time" type="radio" value="<?php echo $Single; ?>"/>&nbsp;<?php echo $Single; ?>
					</div>
					<?php
					$Enable[] = $Single;
				}
			}// end foreach
			
			unset($DisableSlotsTimes);
			
	} // end else


?>