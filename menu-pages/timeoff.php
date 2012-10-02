<!--date-picker css -->
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/datepicker-assets/css/jquery-ui-1.8.23.custom.css', __FILE__); ?>' />

<!-----bootstrap css----->
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/bootstrap-assets/css/bootstrap.css', __FILE__); ?>' />
<link rel='stylesheet' type='text/css' href='<?php //echo plugins_url('/bootstrap-assets/css/bootstrap.min.css', __FILE__); ?>' />
<link rel='stylesheet' type='text/css' href='<?php //echo plugins_url('/bootstrap-assets/css/bootstrap-responsive.css', __FILE__); ?>' />
<link rel='stylesheet' type='text/css' href='<?php //echo plugins_url('/bootstrap-assets/css/bootstrap-responsive.min.css', __FILE__); ?>' />
<div class="bs-docs-example tooltip-demo">

<div style="background:#C3D9FF; margin-bottom:10px; padding-left:10px;">
  <h3>Time Off</h3> 
</div>

<table width="100%" border="0" class="table">
  <tr>
    <th scope="col">No.</th>
    <th scope="col">Name</th>
    <th scope="col">Date</th>
    <th scope="col">Time</th>
    <th scope="col">Total Day(s) </th>
    <th scope="col">Status</th>
    <th scope="col">Action</th>
    <th scope="col"><a rel="tooltip" title="Check To Select All Time Off"><input type="checkbox" id="checkbox" name="checkbox[]" value="checkbox" /></a></th>
  </tr>
  <?php
  		global $wpdb;
		$EeventTable = $wpdb->prefix."ap_events";
		$FindAllevents = "SELECT * FROM `$EeventTable`";
		$AllEvents = $wpdb->get_results($FindAllevents, OBJECT);
		$no = 1; 
		if($AllEvents)
		{
			foreach($AllEvents as $Event)
			{
  ?>
  <tr>
    <td><em><?php echo $no.".";  ?></em></td>
    <td><em><?php echo $Event->name; ?></em></td>
    <td><em><?php echo date("jS M.", strtotime($Event->start_date))." To ".date("jS M. Y", strtotime($Event->end_date)); ?></em></td>
    <td><em><?php echo $Event->start_time." To ".$Event->end_time; ?></em></td>
    <td>
	  <em>
	  <?php 
					$diff = ( strtotime($Event->end_date) - strtotime($Event->start_date)  ) /60/60/24; 
					if($diff > 0)
					{	echo ($diff)." Days(s) Event"; 	}
					else
					{	echo "1 Day(s) Event"; 			}
	?>
      </em> </td>
    <td>
	  <em>
	  <?php 
	  		if(strtotime("$Event->end_date") < strtotime(date('Y-m-d')))
			{
			   echo "Gone";
			}
			else
			{
			   $diff = ( strtotime($Event->end_date) - strtotime($Event->start_date)  ) /60/60/24;
				if($diff == 0)
				{	echo "Running"; 	}
				else if($diff > 0)
				{	echo "Up-Comming"; 	}
			}
	  ?>
      </em> 
	</td>
    <td>
		<a href="?page=update-timeoff&update_timeoff=<?php echo $Event->id; ?>" title="Update This Time-Off" rel="tooltip"><i class="icon-pencil"></i></a> &nbsp;
		<a href="?page=timeoff&delete_timeoff=<?php echo $Event->id; ?>" title="Delete This Time-Off" rel="tooltip"><i class="icon-remove"></i>	</td>
    <td><a rel="tooltip" title="Check To Select This Time Off"><input type="checkbox" id="checkbox[]" name="checkbox[]" value="<?php echo $Event->id; ?>" /></a></td>
  </tr>
  <?php
  			$no++;
  			} // foreach
  		} // if
  ?>
  <tr>
    <td colspan="2"><button name="addnewtimeoff" id="addnewtimeoff" class="btn btn-primary" type="submit" >Add New Time Off</button></a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><button name="deleteall" class="btn btn-primary" type="submit" id="deleteall">Delete</button></td>
  </tr>
</table>


<style type='text/css'>

.error{ 
	color:#FF0000; 
}

.modal{
	top: 40%;
}
.modal-body {
	max-height: 535px;
}

</style>

<!--------TimeOff For Add New TimeOff-->
<div id="TimeOffModal" style="display:none;">

	<div class="modal" id="myModal">
	<form action="" method="post" name="AddNewTimeOff-From" id="AddNewTimeOff-From">
		<div class="modal-info">
			<div class="alert alert-info"><h4>Add New Time Off</h4></div>
		</div>
		<div class="modal-body">
			<table width="100%" class="table">
			  <tr>
				<th scope="row">All Day Event</th>
				<td>:</td>
				<td><input name="allday" id="allday" type="checkbox" value="1" />
				&nbsp;<a href="#" rel="tooltip" title="All Day Time Off." ><i  class="icon-question-sign"></i> </a>
				</td>
			  </tr>
			  <tr>
				<th scope="row">Name</th>
				<td>:</td>
				<td><input name="name" id="name" type="text" />
				&nbsp;<a href="#" rel="tooltip" title="Time Off Name." ><i  class="icon-question-sign"></i> </a>
				</td>
			  </tr>
			  <tr>
				<th scope="row">Start Time</th>
				<td>:</td>
				<td><input name="start_time" id="start_time" type="text" />
				&nbsp;<a href="#" rel="tooltip" title="Time Off Start Time." ><i  class="icon-question-sign"></i> </a>
				</td>
			  </tr>
			  <tr>
				<th scope="row">End Time</th>
				<td>:</td>
				<td><input name="end_time" id="end_time" type="text" />
				&nbsp;<a href="#" rel="tooltip" title="Time Off End Time." ><i  class="icon-question-sign"></i> </a>
				</td>
			  </tr>
			  <tr>
				<th scope="row">Repeat</th>
				<td>:</td>
				<td><select name="repeat" id="repeat">
						<option value="N">No</option>
						<option value="PD">Particular Date(s)</option>
						<option value="D">Daily</option>
						<option value="W">Weekly</option>
						<option value="M">Monthly</option>
					</select>
					&nbsp;<a href="#" rel="tooltip" title="Time Off Repeat Days." ><i  class="icon-question-sign"></i> </a>
				</td>
			  </tr>
			  <tr>
				<th scope="row">Start Date</th>
				<td>:</td>
				<td><input name="start_date" id="start_date" type="text" />
				&nbsp;<a href="#" rel="tooltip" title="Time Off Start Date." ><i  class="icon-question-sign"></i> </a>
				</td>
			  </tr>
			  <tr>
				<th scope="row">End Date</th>
				<td>:</td>
				<td><input name="end_date" id="end_date" type="text" />
				&nbsp;<a href="#" rel="tooltip" title="Time Off End Date." ><i  class="icon-question-sign"></i> </a>
				</td>
			  </tr>
			  <tr>
				<th scope="row">Note</th>
				<td>:</td>
				<td><textarea name="note" id="note"></textarea>
				&nbsp;<a href="#" rel="tooltip" title="Time Off Note." ><i  class="icon-question-sign"></i> </a>
				</td>
			  </tr>
			  <tr>
				<th scope="row">&nbsp;</th>
				<td>&nbsp;</td>
				<td><a href="#"class="btn btn-primary" id="close">Close</a>
				<button name="create" id="create" class="btn btn-primary" type="submit">Create</button></td>
				
			  </tr>
			</table>
	  </div>
		</div>
	</form>
	
</div>
</div>


<!------Insert Time-off in db -------->
<?php 
	if(isset($_POST['create']))
	{
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
		
		$status = "Up-Comming";
		
		global $wpdb;
		$EeventTable = $wpdb->prefix."ap_events";
		$eventinsert_sql = "INSERT INTO `$EeventTable` ( `id` , `name` , `allday` , `start_time` , `end_time` , `repeat` ,
			`start_date` , `end_date` , `note` , `status` ) VALUES (
			NULL , '$name', '$allday', '$start_time', '$end_time', '$repeat', '$start_date', '$end_date', '$note', '$status');";
			
		if($wpdb->query($eventinsert_sql))
			echo "<script>location.href='?page=timeoff';</script>";
		else
			echo "<script>location.href='?page=timeoff';</script>";
		

	}
?>


<!--------Delete time off single row------------>
<?php 
	if(isset($_GET['delete_timeoff']))
	{
		global $wpdb;
		$EeventTable = $wpdb->prefix."ap_events";
		$del_id = $_GET['delete_timeoff'];
		$timeoffdelete_sql = "delete from `$EeventTable` where `id` = '$del_id'";
		if($wpdb->query($timeoffdelete_sql))
			echo "<script>location.href='?page=timeoff';</script>";
		else
			echo "<script>location.href='?page=timeoff';</script>";
	}

?>


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
		$(".error").hide();
		var eqflag = 0;
		var sflag = 0;
		var eflag = 0;
		var hasName = 0;
		var hasST = 0;
		var hasET = 0;
		var hasSD = 0;
		var hasED = 0;
	
	$('#end_date').attr("disabled", true);
		
	//when load for update time-off
	if ($('#allday').is(':checked'))
	{
		$('#name').attr("disabled", true);
		 hasName = 1;
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
<!---Tooltip js ---------->
	<script src="<?php echo plugins_url('/bootstrap-assets/js/bootstrap-tooltip.js', __FILE__); ?>" type="text/javascript"></script>
	<script src="<?php echo plugins_url('/bootstrap-assets/js/bootstrap-affix.js', __FILE__); ?>" type="text/javascript"></script>
    <script src="<?php echo plugins_url('/bootstrap-assets/js/application.js', __FILE__); ?>" type="text/javascript"></script>
</div>
