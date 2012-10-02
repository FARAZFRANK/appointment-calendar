<!---load full calendar js--->
<script type='text/javascript' src='<?php echo plugins_url('/bootstrap-assets/js/bootstrap-tab.js', __FILE__); ?>'></script>

<!---load bootstrap css----->
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/bootstrap-assets/css/bootstrap.css', __FILE__); ?>' />
<link rel='stylesheet' type='text/css' href='<?php //echo plugins_url('/bootstrap-assets/css/bootstrap.min.css', __FILE__); ?>' />
<link rel='stylesheet' type='text/css' href='<?php //echo plugins_url('/bootstrap-assets/css/bootstrap-responsive.css', __FILE__); ?>' />
<link rel='stylesheet' type='text/css' href='<?php //echo plugins_url('/bootstrap-assets/css/bootstrap-responsive.min.css', __FILE__); ?>' />
<div style="background:#C3D9FF; margin-bottom:10px; padding-left:10px;">
  <h3>Notification Settings</h3> 
</div>
<table width="100%" class="table">
  <tr>
    <th colspan="2" scope="row">Notification</th>
    <td width="5%"><strong>:</strong></td>
    <td width="81%">
			<em>
			<?php 
				if(get_option('emailstatus') == 'on')
					echo strtoupper(get_option('emailstatus')); 
				else
					echo "OFF";
			?>
			</em> </td>
  </tr>
  <tr>
    <th colspan="2" scope="row">Notification Type </th>
    <td><strong>:</strong></td>
    <td><em>
      <?php $emailtype =  get_option('emailtype');
			if($emailtype)
			{
				echo strtoupper($emailtype);
			}
			else echo "Not Available.";
		?>
    </em></td>
  </tr>
  <tr>
    <th colspan="2" scope="row">Details</th>
    <td>&nbsp;</td>
    <td>
		<em>
		<?php $emaildetails =  get_option('emaildetails');
			if($emaildetails)
			{
				$emaildetails = unserialize($emaildetails);
			}
			else echo "Not Available.";
		?>
		</em> </td>
  </tr>
  <?php if($emailtype == 'wpmail') {?>
  <tr>
    <th scope="row">&nbsp;</th>
    <td scope="row">WP Email</td>
    <td><strong>:</strong></td>
    <td><em><?php echo $emaildetails['wpemail']; ?></em></td>
  </tr>
  <?php } ?>
  
  <?php if($emailtype == 'phpmail') {?>
  <tr>
    <th scope="row">&nbsp;</th>
    <td scope="row">PHP Email</td>
    <td><strong>:</strong></td>
    <td><em><?php echo $emaildetails['phpemail']; ?></em></td>
  </tr>
  <?php } ?>
  
  <?php if($emailtype == 'smtp') {?>
  <tr>
    <th width="6%" scope="row">&nbsp;</th>
    <td width="8%" scope="row">Host Name </td>
    <td><strong>:</strong></td>
    <td><em><?php echo $emaildetails['hostname']; ?></em></td>
  </tr>
  <tr>
    <th scope="row">&nbsp;</th>
    <td scope="row">Port Number</td>
    <td><strong>:</strong></td>
    <td><em><?php echo $emaildetails['portno']; ?></em></td>
  </tr>
  <tr>
    <th scope="row">&nbsp;</th>
    <td scope="row">Email</td>
    <td><strong>:</strong></td>
    <td><em><?php echo $emaildetails['smtpemail']; ?></em></td>
  </tr>
  <tr>
    <th scope="row">&nbsp;</th>
    <td scope="row">Password</td>
    <td><strong>:</strong></td>
    <td><em><?php echo $emaildetails['password']; ?></em></td>
  </tr>
  <?php } ?>
  <tr>
    <th colspan="2" scope="row">&nbsp;</th>
    <td>&nbsp;</td>
    <td><a href="?page=manage-notificationsettings" class="btn btn-primary">Manage Settings</a></td>
  </tr>
</table>

<?php

	/*
	 * Saving Notification Settings
	 *******************************/
	 if(isset($_POST['savesettings']))
	 {
	 	//wp-mail
		if($_POST['emailtype'] == 'wpmail')
		{
			update_option('emailstatus', $_POST['enable']);
			update_option('emailtype', $_POST['emailtype']);
			
			$EmailDetails =  array ( 'wpemail' => $_POST['wpemail'] );
			update_option( 'emaildetails', serialize($EmailDetails));
		}
		
		//phpmail
		if($_POST['emailtype'] == 'phpmail')
		{
			update_option('emailstatus', $_POST['enable']);
			update_option('emailtype', $_POST['emailtype']);
			$EmailDetails =  array ( 'phpemail' => $_POST['phpemail']);
			update_option('emaildetails', serialize($EmailDetails));
		}
		
		//smtp mail
		if($_POST['emailtype'] == 'smtp')
		{
			update_option('emailstatus', $_POST['enable']);
			update_option('emailtype', $_POST['emailtype']);
			$EmailDetails =  array ( 'hostname' => $_POST['hostname'],
									 'portno' => 	$_POST['portno'],	
									 'smtpemail' => $_POST['smtpemail'],
									 'password' => $_POST['password'],
							);
			update_option('emaildetails', serialize($EmailDetails));
		}
		echo "<script> location.href='?page=notificationsettings'</script>";
	 }
	 
?>

