<!---load bootstrap css----->
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/bootstrap-assets/css/bootstrap.css', __FILE__); ?>' />

<?php
	/*
	 * Uninstall Appointment Calendar
	 ********************************/
	 if(isset($_POST['uninstallapcal']))
	 {
		$AllPlugin = get_option('active_plugins');
		$key = array_search('appointment-calendar/appointment-calendar.php', $AllPlugin);
		unset($AllPlugin[$key]);
		update_option('active_plugins', serialize( $AllPlugin));
		include_once('uninstall-script.php');
		?>
		<div class="alert" style="width:95%; margin-top:10px;">
			<p><strong>Appointment Calendar have been successfully uninstalled. It can be re-activated from the <a href="plugins.php">Plugins Page</a></strong>.</p>
		</div>
		<?php
	 }
	 else
	 {
?>

<div style="background:#C3D9FF; margin-bottom:10px; padding-left:10px;">
  <h3>Settings </h3> 
</div>

<table width="100%" class="table">
  <tr>
    <th width="14%" scope="row">Calendar Slot Time </th>
    <td width="5%"><strong>:</strong></td>
    <td width="81%">
		<em>
		<?php $calendar_slot_time =  get_option('calendar_slot_time');
			if($calendar_slot_time)
			{
				echo $calendar_slot_time." Minute";
			}
			else echo "Not Available.";
		?>
	    </em> </td>
  </tr>
  <tr>
    <th scope="row">Day Start Time </th>
    <td><strong>:</strong></td>
    <td>
		<em>
		<?php $day_start_time =  get_option('day_start_time');
			if($day_start_time)
			{
				echo $day_start_time;
			}
			else echo "Not Available.";
		?>
	    </em> </td>
  </tr>
  <tr>
    <th scope="row">Day End Time </th>
    <td><strong>:</strong></td>
    <td>
		<em>
		<?php $day_end_time =  get_option('day_end_time');
			if($day_start_time)
			{
				echo $day_end_time;
			}
			else echo "Not Available.";
		?>
	    </em> </td>
  </tr>
  <tr>
    <th scope="row">Calendar View </th>
    <td><strong>:</strong></td>
    <td>
		<em>
		<?php $calendar_view =  get_option('calendar_view');
			if($calendar_view)
			{
				if($calendar_view == 'agendaDay') echo "Day";
				if($calendar_view == 'agendaWeek') echo "Week";
				if($calendar_view == 'month') echo "Month";
			}
			else echo "Not Available.";
		?>
	    </em> </td>
  </tr>
  <tr>
    <th scope="row">Calendar Start Day </th>
    <td><strong>:</strong></td>
    <td><em>
		<?php $calendar_start_day =  get_option('calendar_start_day');
			if($calendar_start_day)
			{
				if($calendar_start_day == 1)
					echo "Monday";
				if($calendar_start_day == 2)
					echo "Tuesday";
				if($calendar_start_day == 3)
					echo "Wednesday";
				if($calendar_start_day == 4)
					echo "Thursday";
				if($calendar_start_day == 5)
					echo "Friday";
				if($calendar_start_day == 6)
					echo "Saturday";
				if($calendar_start_day == 0)
					echo "Sunday";
			}
			else echo "Not Available.";
		?>
	    </em> </td>
  </tr>
  <tr>
    <th scope="row">&nbsp;</th>
    <td>&nbsp;</td>
    <td><a href="?page=manage-settings" class="btn btn-primary">Manage Settings</a></td>
  </tr>
</table>

<div class="alert alert-error" style="width:95%;">
	<form action="" method="post" name="uninstall-appointment-calendar">
	<h3>Uninstall Appointment Calendar</h3>
	<p>This operation wiil delete all Appointment Calendar data & settings. If you continue, You will not be able to retrieve or restore your appointments entries.</p>
	<p>	<button id="uninstallapcal" type="submit" class="btn btn-danger" name="uninstallapcal" value="<?php echo $appointmentdetails->id; ?>" onclick="return confirm('Warning! Appointment Calendar data & settings, including appointment entries will be deleted. This cannot be undone. OK to delete, CANCEL to stop')" >Uninstall Appointment Calendar</button> </p>
	
	</form>
</div>

<?php

	}//end of uninstaller else

	/*
	 * Saving Calendar Settings
	 ****************************/
	if(isset($_POST['savesettings']))
	{
		//update email settings option values
		update_option('calendar_slot_time',$_POST['calendar_slot_time']);
		update_option('day_start_time',$_POST['day_start_time']);
		update_option('day_end_time',$_POST['day_end_time']);
		update_option('calendar_view',$_POST['calendar_view']);
		update_option('calendar_start_day',$_POST['calendar_start_day']);
		echo "<script>location.href='?page=settings'</script>";
	}
	
?>