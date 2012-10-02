<!---load full calendar js--->
<script type='text/javascript' src='<?php echo plugins_url('/bootstrap-assets/js/bootstrap-tab.js', __FILE__); ?>'></script>

<!---load bootstrap css----->
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/bootstrap-assets/css/bootstrap.css', __FILE__); ?>' />

<div class="bs-docs-example tooltip-demo">

<div style="background:#C3D9FF; margin-bottom:10px; padding-left:10px;">
  <h3>Manage Notification Settings</h3> 
</div>
<form name="emailsettings" action="?page=notificationsettings"  method="post">
  <table width="100%" class="table">
  <tr>
    <th colspan="2" scope="row">Enable</th>
    <td width="3%"><strong>:</strong></td>
    <td width="69%"><input name="enable" type="checkbox" id="enable" <?php if(get_option('emailstatus') == 'on') echo 'checked'; ?> />
	&nbsp;<a href="#" rel="tooltip" title="Enable Notification." ><i  class="icon-question-sign"></i> </a>
	</td>
    <td width="3%">&nbsp;</td>
    <td width="3%">&nbsp;</td>
    <td width="3%">&nbsp;</td>
  </tr>
  <?php
   $emailtype = get_option('emailtype');
  ?>
  <tr>
    <th colspan="2" scope="row">Email Type</th>
    <td><strong>:</strong></td>
    <td>
      <select name="emailtype" id="emailtype">
        <option value="0">Select Type</option>
        <option value="wpmail" <?php if($emailtype == 'wpmail') echo 'selected';?>>WP Mail</option>
        <option value="phpmail" <?php if($emailtype == 'phpmail') echo 'selected';?>>PHP Mail</option>
        <option value="smtp" <?php if($emailtype == 'smtp') echo 'selected';?>>SMTP Mail</option>
      </select>   
	&nbsp;<a href="#" rel="tooltip" title="Notification Type." ><i  class="icon-question-sign"></i> </a>
	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
	<?php 
		$emaildetails =  get_option('emaildetails');
		if($emaildetails)
		{
			$emaildetails = unserialize($emaildetails);
		}
	?>
<!--wp mail-->
  <tr id="wpmaildetails1" style="display:none;">
    <th colspan="2" scope="row">WP Mail Details </th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr id="wpmaildetails2" style="display:none;">
    <th scope="row">&nbsp;</th>
    <th scope="row">Email</th>
    <td><strong>:</strong></td>
    <td><input name="wpemail" type="text" id="wpemail"  value="<?php echo $emaildetails['wpemail']; ?>" />
		&nbsp;<a href="#" rel="tooltip" title="Admin Email." ><i  class="icon-question-sign"></i> </a>
	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</div>


	<!--php mail-->
  <tr id="phpmaildetails1" style="display:none;">
    <th colspan="2" scope="row">PHPMail Details </th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr id="phpmaildetails2" style="display:none;">
    <th scope="row">&nbsp;</th>
    <th scope="row">Email</th>
    <td><strong>:</strong></td>
    <td><input name="phpemail" type="text" id="phpemail" value="<?php echo $emaildetails['phpemail']; ?>" />
		&nbsp;<a href="#" rel="tooltip" title="Admin Email." ><i  class="icon-question-sign"></i> </a>
	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>


<!--smtp-->
  <tr id="smtpdetails1" style="display:none;">
    <th colspan="2" scope="row">SMTP Mail Details </th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr id="smtpdetails2" style="display:none;">
    <th width="9%" scope="row">&nbsp;</th>
    <td width="10%" scope="row">Host Name </td>
    <td><strong>:</strong></td>
    <td><input name="hostname" type="text" id="hostname" class="inputhieght" value="<?php echo $emaildetails['hostname']; ?>" />
		&nbsp;<a href="#" rel="tooltip" title="Host Name Like eg: smtp.gmail.com, smtp.yahoo.com." ><i  class="icon-question-sign"></i> </a>
	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr id="smtpdetails3" style="display:none;">
    <th scope="row">&nbsp;</th>
    <td scope="row">Port Number </td>
    <td><strong>:</strong></td>
    <td><input name="portno" type="text" id="portno" value="<?php echo $emaildetails['portno']; ?>" />
		&nbsp;<a href="#" rel="tooltip" title="Smtp Post Number Like eg: Gmail & Yahoo Port Number = 465." ><i  class="icon-question-sign"></i> </a>
	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr id="smtpdetails4" style="display:none;">
    <th scope="row">&nbsp;</th>
    <td scope="row">Email</td>
    <td><strong>:</strong></td>
    <td><input name="smtpemail" type="text" id="smtpemail" value="<?php echo $emaildetails['smtpemail']; ?>" />
		&nbsp;<a href="#" rel="tooltip" title="Admin SMTP Email." ><i  class="icon-question-sign"></i> </a>
	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr id="smtpdetails5" style="display:none;">
    <th scope="row">&nbsp;</th>
    <td scope="row">Password</td>
    <td><strong>:</strong></td>
    <td><input name="password" type="password" id="password" value="<?php echo $emaildetails['password']; ?>" />
		&nbsp;<a href="#" rel="tooltip" title="Admin SMTP Email Password." ><i  class="icon-question-sign"></i> </a>
	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>



  <tr>
    <th colspan="2" scope="row">&nbsp;</th>
    <td>&nbsp;</td>
    <td>
	
<?php if($emailtype && $emaildetails ) { ?>
		<button name="savesettings" class="btn btn-primary" type="submit" id="savesettings">Update Settings</button>
		<?php } else { ?>
		<button name="savesettings" class="btn btn-primary" type="submit" id="savesettings">Save Settings</button>		
		<?php } ?>
		<a href="?page=notificationsettings" class="btn btn-primary">Cancel</a>
		</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>




<style type="text/css">
.error{  color:#FF0000; 
}
</style>

<!--validation js lib-->
<script src="<?php echo plugins_url('/js/jquery.min.js', __FILE__); ?>" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	
	//-------onload if check enable--------
	var emailtype = $('#emailtype').val();
	if($('#enable').is(':checked'))
	{	
		$('#emailtype').attr("disabled", false);	//enable
		if(emailtype == 'wpmail')
			{
				$('#smtpdetails1').hide();
				$('#smtpdetails2').hide();
				$('#smtpdetails3').hide();
				$('#smtpdetails4').hide();
				$('#smtpdetails5').hide();
				
				$('#phpmaildetails1').hide();
				$('#phpmaildetails2').hide();
					
				$('#wpmaildetails1').show();
				$('#wpmaildetails2').show();
			}

			if(emailtype == 'phpmail')
			{
				$('#smtpdetails1').hide();
				$('#smtpdetails2').hide();
				$('#smtpdetails3').hide();
				$('#smtpdetails4').hide();
				$('#smtpdetails5').hide();
				
				$('#phpmaildetails1').show();
				$('#phpmaildetails2').show();
					
				$('#wpmaildetails1').hide();
				$('#wpmaildetails2').hide();
			}
			if(emailtype == 'smtp')
			{
				$('#smtpdetails1').show();
				$('#smtpdetails2').show();
				$('#smtpdetails3').show();
				$('#smtpdetails4').show();
				$('#smtpdetails5').show();
				
				$('#phpmaildetails1').hide();
				$('#phpmaildetails2').hide();
					
				$('#wpmaildetails1').hide();
				$('#wpmaildetails2').hide();
			}
	}
	else
	{
		$('#emailtype').attr("disabled", true);
	}
	
	
	
	
	<!------------on-click------------->
	$('#enable').click(function(){
	
		$(".error").hide();
		
		if ($(this).is(':checked'))
		{
			$('#emailtype').attr("disabled", false);
		}
		else
		{
			$('#emailtype').attr("disabled", true);
		}
	});
	
	<!------onchange email type-------->
	$('#emailtype').change(function(){
		var emailtype = $('#emailtype').val();
		if($('#enable').is(':checked') && emailtype)
		{	
			if(emailtype=='wpmail')
			{
				$('#smtpdetails1').hide();
				$('#smtpdetails2').hide();
				$('#smtpdetails3').hide();
				$('#smtpdetails4').hide();
				$('#smtpdetails5').hide();
				
				$('#phpmaildetails1').hide();
				$('#phpmaildetails2').hide();
					
				$('#wpmaildetails1').show();
				$('#wpmaildetails2').show();
			}

			if(emailtype == 'phpmail')
			{
				$('#smtpdetails1').hide();
				$('#smtpdetails2').hide();
				$('#smtpdetails3').hide();
				$('#smtpdetails4').hide();
				$('#smtpdetails5').hide();
				
				$('#phpmaildetails1').show();
				$('#phpmaildetails2').show();
					
				$('#wpmaildetails1').hide();
				$('#wpmaildetails2').hide();
			}
			if(emailtype == 'smtp')
			{
				$('#smtpdetails1').show();
				$('#smtpdetails2').show();
				$('#smtpdetails3').show();
				$('#smtpdetails4').show();
				$('#smtpdetails5').show();
				
				$('#phpmaildetails1').hide();
				$('#phpmaildetails2').hide();
					
				$('#wpmaildetails1').hide();
				$('#wpmaildetails2').hide();
			}
		}
	});
});
</script>

<!---Tooltip js ---------->
	<script src="<?php echo plugins_url('/bootstrap-assets/js/bootstrap-tooltip.js', __FILE__); ?>" type="text/javascript"></script>
	<script src="<?php echo plugins_url('/bootstrap-assets/js/bootstrap-affix.js', __FILE__); ?>" type="text/javascript"></script>
    <script src="<?php echo plugins_url('/bootstrap-assets/js/application.js', __FILE__); ?>" type="text/javascript"></script>
</div>

