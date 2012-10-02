<!---load bootstrap css----->
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/bootstrap-assets/css/bootstrap.css', __FILE__); ?>' />

<div class="bs-docs-example tooltip-demo">

<div style="background:#C3D9FF; margin-bottom:10px; padding-left:10px;">
  <h3>Manage Settings</h3> 
</div>

<form method="post" action="?page=settings">
  <table width="100%" class="table">
  <tr>
    <th align="right" scope="row">Calendar Slot Time </th>
    <td align="center">:</td>
    <td>
	<?php $calendar_slot_time = get_option('calendar_slot_time'); ?>
      <select name="calendar_slot_time" id="calendar_slot_time">
        <option value="0">Select Time</option>
        <option value="15" <?php if($calendar_slot_time && $calendar_slot_time == '15') echo "selected"; ?>>15 Minute</option>
        <option value="30" <?php if($calendar_slot_time && $calendar_slot_time == '30') echo "selected"; ?>>30 Minute</option>
        <option value="60" <?php if($calendar_slot_time && $calendar_slot_time == '60') echo "selected"; ?>>60 Minute</option>
      </select> 
	 &nbsp;<a href="#" rel="tooltip" title="Calendar Time Slot." ><i  class="icon-question-sign"></i> </a> 
	 </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="right" scope="row">Day Start Time </th>
    <td align="center">:</td>
    <td>
		<?php $day_start_time = get_option('day_start_time'); ?>
		<select name="day_start_time" id="day_start_time">
			<option value="0">Select Start Time</option>
			<?php
				$biz_start_time = strtotime("01:00 AM");
				$biz_end_time = strtotime("11:00 PM");
				for( $i = $biz_start_time; $i <= $biz_end_time; $i += (60*(60))) //making 60min slots
				{
					if( $day_start_time && $day_start_time == date('g:i A', $i) ) $selected = 'selected'; else $selected='';
					echo "<option $selected value='". date('g:i A', $i)."'>". date('g:i A', $i) ."</option>";
				}
			?>
		</select>
	&nbsp;<a href="#" rel="tooltip" title="Calendar Day Start Time." ><i  class="icon-question-sign"></i> </a>
	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="right" scope="row">Day End Time </th>
    <td align="center">:</td>
    <td>
		<?php $day_end_time = get_option('day_end_time'); ?>
		<select name="day_end_time" id="day_end_time">
			<option value="0">Select End Time</option>
			<?php
				for( $i = $biz_start_time; $i <= $biz_end_time; $i += (60*(60))) //making 60min slots
				{
					if( $day_end_time && $day_end_time == date('g:i A', $i) ) $selected = 'selected'; else $selected='';
					echo "<option $selected value='". date('g:i A', $i)."'>". date('g:i A', $i) ."</option>";
				}
			?>
		</select>
		&nbsp;<a href="#" rel="tooltip" title="Calendar Day End Time." ><i  class="icon-question-sign"></i> </a>
	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="right" scope="row">Calendar View </th>
    <td align="center">:</td>
    <td>
		<?php $calendar_view = get_option('calendar_view'); ?>
		<select id="calendar_view" name="calendar_view">
			<option value="0">Select View</option>
			<option value="agendaDay" <?php if($calendar_view && $calendar_view == 'agendaDay') echo "selected"; ?>>Day</option>
			<option value="agendaWeek" <?php if($calendar_view && $calendar_view == 'agendaWeek') echo "selected"; ?>>Week</option>
			<option value="month" <?php if($calendar_view && $calendar_view == 'month') echo "selected"; ?>>Month</option>
		</select>
		&nbsp;<a href="#" rel="tooltip" title="Calendar View." ><i  class="icon-question-sign"></i> </a>
	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="right" scope="row">Calendar First Day </th>
    <td align="center">:</td>
    <td>
	<?php $calendar_start_day = get_option('calendar_start_day'); ?>
	<select name="calendar_start_day" id="calendar_start_day">
      <option value="-1">Select Start Day</option>
      <option value="1" <?php if($calendar_start_day == 1) echo "selected";  ?>>Monday</option>
      <option value="2" <?php if($calendar_start_day == 2) echo "selected";  ?>>Tuesday</option>
      <option value="3" <?php if($calendar_start_day == 3) echo "selected";  ?>>Wednesday</option>
      <option value="4" <?php if($calendar_start_day == 4) echo "selected";  ?>>Thursday</option>
      <option value="5" <?php if($calendar_start_day == 5) echo "selected";  ?>>Friday</option>
      <option value="6" <?php if($calendar_start_day == 6) echo "selected";  ?>>Saturday</option>
      <option value="0" <?php if($calendar_start_day == 0) echo "selected";  ?>>Sunday</option>
    </select>
	&nbsp;<a href="#" rel="tooltip" title="Calendar First Day." ><i  class="icon-question-sign"></i> </a>
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th scope="row">&nbsp;</th>
    <td>&nbsp;</td>
    <td>
		<?php if($calendar_slot_time && $day_start_time && $day_end_time && $calendar_view ) { ?>
		<button name="savesettings" class="btn btn-primary" type="submit" id="savesettings" data-loading-text="Saving Settings" >Update Settings</button>
		<?php } else { ?>
		<button name="savesettings" class="btn btn-primary" type="submit" id="savesettings" data-loading-text="Saving Settings" >Save Settings</button>		
		<?php } ?>
		<a href="?page=settings" class="btn btn-primary">Cancel</a>
		
	  
	  <!--<button type="submit" class="btn btn-primary" data-loading-text="Loading...">Loading state</button>-->	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>



<style type="text/css">
.error{  color:#FF0000; }
</style>

<!--validation js lib-->
<script src="<?php echo plugins_url('/js/jquery.min.js', __FILE__); ?>" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function () {
	
		$('#savesettings').click(function(){
			$(".error").hide();
			
			//slot time
			var calendar_slot_time = $('#calendar_slot_time').val();
			if(calendar_slot_time == 0)
			{
				$("#calendar_slot_time").after('<span class="error">&nbsp;<br><strong>Select Slot Time.</strong></span>');
				return false;
			}
			
			var day_start_time = $('#day_start_time').val();
			if(day_start_time == 0)
			{
				$("#day_start_time").after('<span class="error">&nbsp;<br><strong>Select Start Time.</strong></span>');
				return false;
			}
			
			var day_end_time = $('#day_end_time').val();
			if(day_end_time == 0)
			{
				$("#day_end_time").after('<span class="error">&nbsp;<br><strong>Select End Time.</strong></span>');
				return false;
			}
			
			var calendar_view = $('#calendar_view').val();
			if(calendar_view == 0)
			{
				$("#calendar_view").after('<span class="error">&nbsp;<br><strong>Select Calendar View.</strong></span>');
				return false;
			}
			
			var calendar_start_day = $('#calendar_start_day').val();
			if(calendar_start_day == -1)
			{
				$("#calendar_start_day").after('<span class="error">&nbsp;<br><strong>Select Calendar View.</strong></span>');
				return false;
			}
				
		});
	});
</script>
<!---Tooltip js ---------->
	<script src="<?php echo plugins_url('/bootstrap-assets/js/bootstrap-tooltip.js', __FILE__); ?>" type="text/javascript"></script>
	<script src="<?php echo plugins_url('/bootstrap-assets/js/bootstrap-affix.js', __FILE__); ?>" type="text/javascript"></script>
    <script src="<?php echo plugins_url('/bootstrap-assets/js/application.js', __FILE__); ?>" type="text/javascript"></script>
</div>

