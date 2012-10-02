<!--date-picker css -->
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/datepicker-assets/css/jquery-ui-1.8.23.custom.css', __FILE__); ?>' />

<!-----bootstrap css----->
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/bootstrap-assets/css/bootstrap.css', __FILE__); ?>' />
<link rel='stylesheet' type='text/css' href='<?php //echo plugins_url('/bootstrap-assets/css/bootstrap.min.css', __FILE__); ?>' />
<link rel='stylesheet' type='text/css' href='<?php //echo plugins_url('/bootstrap-assets/css/bootstrap-responsive.css', __FILE__); ?>' />
<link rel='stylesheet' type='text/css' href='<?php //echo plugins_url('/bootstrap-assets/css/bootstrap-responsive.min.css', __FILE__); ?>' />

<div style="background:#C3D9FF; margin-bottom:10px; padding-left:10px;">
  <h3>Update Time Off</h3> 
</div>

<!--load timeoff modal for update -->

<?php 
	if(isset($_GET['update_timeoff']))
	{
		$update_id = $_GET['update_timeoff'];
		global $wpdb;
		$EeventTable = $wpdb->prefix."ap_events";
		$timeoff_sql = "select * from `$EeventTable` where `id` = '$update_id'";
		$TimeOffData = $wpdb->get_row($timeoff_sql, OBJECT);
	?>
	<form action="" method="post" name="AddNewTimeOff-From" id="AddNewTimeOff-From">
			<input name="update_id" id="update_id" type="hidden" value="<?php echo $update_id; ?>" />
			<table width="100%" class="table">
			  <tr>
				<th width="21%" scope="row">All Day Event</th>
				<td width="4%">:</td>
				<td width="75%"><input name="allday" id="allday" type="checkbox" value="1" <?php if($TimeOffData->allday) echo "checked=checked"; ?> /></td>
			  </tr>
			  <tr>
				<th scope="row">Name</th>
				<td>:</td>
				<td><input name="name" id="name" type="text" value="<?php echo $TimeOffData->name; ?>" /></td>
			  </tr>
			  <tr>
				<th scope="row">Start Time</th>
				<td>:</td>
				<td><input name="start_time" id="start_time" type="text" value="<?php if(!$TimeOffData->allday) echo $TimeOffData->start_time; ?>" /></td>
			  </tr>
			  <tr>
				<th scope="row">End Time</th>
				<td>:</td>
				<td><input name="end_time" id="end_time" type="text" value="<?php if($TimeOffData->allday == 0) echo $TimeOffData->end_time; ?>" /></td>
			  </tr>
			  <tr>
				<th scope="row">Repeat</th>
				<td>:</td>
				<td><select name="repeat" id="repeat">
						<option value="N" <?php if($TimeOffData->repeat == 'N') echo "selected=selected"; ?>>No</option>
						<option value="PD"<?php if($TimeOffData->repeat == 'PD') echo "selected=selected"; ?>>Particular Date(s)</option>
						<option value="D" <?php if($TimeOffData->repeat == 'D') echo "selected=selected"; ?>>Daily</option>
						<option value="W" <?php if($TimeOffData->repeat == 'W') echo "selected=selected"; ?>>Weekly</option>
						<option value="M" <?php if($TimeOffData->repeat == 'M') echo "selected=selected"; ?>>Monthly</option>
					</select>
				</td>
			  </tr>
			  <tr>
				<th scope="row">Start Date</th>
				<td>:</td>
				<td><input name="start_date" id="start_date" type="text" value="<?php echo $TimeOffData->start_date; ?>" /></td>
			  </tr>
			  <tr>
				<th scope="row">End Date</th>
				<td>:</td>
				<td><input name="end_date" id="end_date" type="text" value="<?php if($TimeOffData->repeat == 'PD')echo $TimeOffData->end_date; ?>" /></td>
			  </tr>
			  <tr>
				<th scope="row">Note</th>
				<td>:</td>
				<td><textarea name="note" id="note"><?php echo $TimeOffData->note; ?></textarea></td>
			  </tr>
			  <tr>
				<th scope="row">&nbsp;</th>
				<td>&nbsp;</td>
				<td><button name="create" id="create" class="btn btn-primary" type="submit">Update</button>
				<a href="?page=timeoff" class="btn btn-primary">Cancel</a>
				</td>
			  </tr>
			</table>
	</form>
		<?php
	}
?>

<!--------update time-off in db------------->
<?php 
	if(isset($_POST['create']))
	{
		$update_id = $_POST['update_id'];
		if($_POST['allday'])	// all day event
		{
			$allday = 1;
			$start_time = '12:00 AM';
			$end_time = '11:00 PM';
		}
		else
		{
			$allday = 0;
			$start_time = $_POST['start_time'];
			$end_time = $_POST['end_time'];
		}
		$name = $_POST['name'];
			
		$repeat = $_POST['repeat'];
		$start_date = $_POST['start_date'];
		$start_date = date("Y-m-d", strtotime($start_date)); //convert format
		
			
		//not repaet
		if($repeat == 'N')
		{
			$end_date =  date("Y-m-d", strtotime($start_date)); //convert format
		}
		
		//purticularday
		if($repeat == 'PD')
		{
			$end_date = $_POST['end_date'];
			$end_date =  date("Y-m-d", strtotime($end_date)); //convert format
		}
		
		//daily event will be  90 days
		if($repeat == 'D')
		{
			$end_date = strtotime($start_date); 
			$end_date = date("Y-m-d", strtotime("+3 months", $end_date)); 	//add 3 month 
		}
		//weekly event add 1 week
		if($repeat == 'W')
		{
			$end_date = strtotime($start_date); 
			$end_date = date("Y-m-d", strtotime("+1 week", $end_date)); 	//add 1 week
		}
		//monthly event add 1 month
		if($repeat == 'M')
		{
			$end_date = strtotime($start_date); 
			
			$end_date = date("Y-m-d", strtotime("+1 months", $end_date)); 	//add 1 month 
		}
		$note = $_POST['note'];
		if( date('d-m-Y') == $start_date )
			$status = "Running";
		else
			$status = "Up-Comming";
		
		global $wpdb;
		$EeventTable = $wpdb->prefix."ap_events";
		$eventupdate_sql = "UPDATE `$EeventTable` SET 
							`name` = '$name',
							`allday` = '$allday',
							`start_time` = '$start_time',
							`end_time` = '$end_time',
							`repeat` = '$repeat',
							`start_date` = '$start_date',
							`end_date` = '$end_date',
							`note` = '$note',
							`status` = '$status'
							WHERE `id` = $update_id;";

			
		if($wpdb->query($eventupdate_sql))
			echo "<script>location.href='?page=timeoff';</script>";
		else 
			echo "<script>location.href='?page=timeoff';</script>";
	}
?>


<style type='text/css'>

.error{ 
	color:#FF0000; 
}
</style>

<!--validation js lib-->
<script src="<?php echo plugins_url('/js/jquery.min.js', __FILE__); ?>" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function () {
	
		//select all checkbox for multiple delete
		$('#checkbox').click(function(){
			if($('#checkbox').is(':checked'))
			{
				$(":checkbox").prop("checked", true);
			}
			else
			{
				$(":checkbox").prop("checked", false);
			}
		});
		
		


		<!-------------Launch Modal Form-------------------->
		//hide modal
		$('#close').click(function(){
			
			$('#TimeOffModal').hide();
		});
		
		//show modal
		$('#addnewtimeoff').click(function(){
			$('#TimeOffModal').show();
		});
		
		
	
		
	<!------------------Validation---------------------->
		var repeatVal = $("#repeat").val();
		if(repeatVal == 'PD')
		{
			$('#end_date').attr("disabled", false);
		}
		else
		{
			$('#end_date').attr("disabled", true);
		}
		
		$(".error").hide();
		var eqflag = 0;
		var sflag = 0;
		var eflag = 0;
		var hasName = 0;
		var hasST = 0;
		var hasET = 0;
		var hasSD = 0;
		var hasED = 0;
	
	//when load for update time-off
	if ($('#allday').is(':checked'))
	{
		/*$('#name').attr("disabled", true);
		 hasName = 1;*/
		$('#start_time').attr("disabled", true);
		 hasST = 1;
		$('#end_time').attr("disabled", true);
		 hasET = 1;
		 $('#end_date').attr("disabled", true);
	}

	
	// all day event check
	$('#allday').click(function(){
		if ($(this).is(':checked'))
		{
			//$('#name').attr("disabled", true);
			// hasName = 1;
			$('#start_time').attr("disabled", true);
			 hasST = 1;
			$('#end_time').attr("disabled", true);
			 hasET = 1;
			 $('#end_date').attr("disabled", true);
			 

		} else {
			$('#name').attr("disabled", false);
			 hasName = 0;
			$('#start_time').attr("disabled", false);
			 hasST = 0;
			$('#end_time').attr("disabled", false);
			 hasET = 0;
			 $('#end_date').attr("disabled", true);
		}
	});
	
	
	//select repeat then enable disable
	$('#repeat').change(function(){
		var repeatVal = $("#repeat").val();
		if(repeatVal == 'PD')
		{
			$('#end_date').attr("disabled", false);
		}
		else
		{
			$('#end_date').attr("disabled", true);
		}
	});
	
	
	/*************************ON-FORM SUBMIT********************************/
	
	// start/end times and dates
	$('#create').click(function() { 

		$(".error").hide();
		if ($('#allday').is(':checked'))
		{ 
			//name
			var nameVal = $("#name").val();
			if(nameVal == ''){
				$("#name").after('<span class="error"><br><strong>This field required.</strong></span>');
				hasName = 0;
			} else hasName = 1;
			
			//start-date
			var startDateVal = $("#start_date").val();
			if(startDateVal == ''){
				$("#start_date").after('<span class="error"><br><strong>This field required.</strong></span>');
				hasSD = 0;
			} else hasSD = 1;
			
			var repeatVal = $("#repeat").val();
			if(repeatVal == 'PD')
			{
				var endDateVal = $("#end_date").val();
				if(endDateVal == '')
				{
					$("#end_date").after('<span class="error"><br><strong>This field required.</strong></span>');
					hasED = 0;
				}else hasED = 1;
				
				if(hasSD && hasED) 
				return true; 
				else
				return false;
			}
			else
			{
				if(hasSD) 
					return true; 
				else
					return false;
			}
			
		}
		else
		{
		
			//name
			var nameVal = $("#name").val();
			if(nameVal == ''){
				$("#name").after('<span class="error"><br><strong>This field required.</strong></span>');
				hasName = 0;
			} else hasName = 1;
			
			if(nameVal) {
				if(!isNaN(nameVal)) {
					$("#name").after('<span class="error"><br><strong>Invalid field value.</strong></span>');
					hasName = 0;
				}else hasName = 1;
			}
			
			
			//start-time
			var st = $('#start_time').val();
			if(st == ''){
				$("#start_time").after('<span class="error"><br><strong>This field required.</strong></span>');
				hasST = 0;
			} else hasST = 1;
			
			
			//end-time
			var et = $('#end_time').val();
			if(et == ''){
				$("#end_time").after('<span class="error"><br><strong>This field required.</strong></span>');
				hasET = 0;
			} else hasET = 1;


			//start-end time compare			
			if(hasST && hasET)
			{
				console.log(Date.parse("1-1-2000 " + st) + " " + Date.parse("1-1-2000 " + et));
				//equal check
				if(st == et && st !='' && et != '') 
				{
					alert("Start-time and End-time can't be equal"); 
					$("#start_time").after("<span class=error><br><strong>Start-time and End-time can't be equal</strong></span>");
				$("#end_time").after("<span class=error><br><strong>End-time and Start-time can't be equal</strong></span>");
						eqflag = 0;
				}else eqflag = 1;
						
				st = Date.parse("1-1-2000 " + st);
				et = Date.parse("1-1-2000 " + et);
		
				if(st > et) 
				{
					$("#start_time").after('<span class="error"><br><strong>Start-time must be smaller then End-time</strong></span>');
					//alert("Start-time must be smaller then End-time."); 
					sflag = 0;
				}else  sflag = 1;
						
				if(et < st) 
				{
					$("#end_time").after('<span class="error"><br><strong>End-time must be bigger then Start-time</strong></span>');
					//alert("End-time must be bigger then Start-time"); 
					eflag = 0;
				}else  eflag = 1;
			}
			
			
			
			//start-date
			var startDateVal = $("#start_date").val();
			if(startDateVal == ''){
				$("#start_date").after('<span class="error"><br><strong>This field required.</strong></span>');
				hasSD = 0;
			} else hasSD = 1;
			
			
			var repeatVal = $("#repeat").val();
			if(repeatVal == 'PD')
			{
				//end-date
				var endDateVal = $("#end_date").val();
				if(endDateVal == ''){
					$("#end_date").after('<span class="error"><br><strong>This field required.</strong></span>');
					hasED = 0;
				} else hasED = 1;
			} else hasED = 1;

			
			/*alert(hasName);
			alert(hasST);
			alert(hasET);
			alert(eqflag);
			alert(sflag);
			alert(eflag);
			alert(hasSD);
			alert(hasED);*/
	
					
			if( hasName && hasST && hasET && eqflag && sflag && eflag && hasSD && hasED ) 
				return true; 
			else
				return false;
		} // end of checked else
				
	});//end of click function condition
		
	
		
});
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
			dateFormat: 'dd-mm-yy',
			
		});
		
		$('#end_date').datepicker({
			dateFormat: 'dd-mm-yy',
			
		});
		
});
</script>

<!--time-picker js -->
<script src="<?php echo plugins_url('/timepicker-assets/js/jquery-1.7.2.min.js', __FILE__); ?>" type="text/javascript"></script>
<script src="<?php echo plugins_url('/timepicker-assets/js/jquery-ui.min.js', __FILE__); ?>" type="text/javascript"></script>
<script src="<?php echo plugins_url('/timepicker-assets/js/jquery-ui-timepicker-addon.js', __FILE__); ?>" type="text/javascript"></script>