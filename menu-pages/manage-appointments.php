<!---load bootstrap css----->
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/bootstrap-assets/css/bootstrap.css', __FILE__); ?>' />

<?php global $wpdb; ?>
<div class="bs-docs-example tooltip-demo">
<div style="background:#C3D9FF; margin-bottom:10px; padding-left:10px;">
  <h3>Manage Appointment(s)</h3>
</div>
<form action="" method="post" name="manage-appointments">
<table width="100%" border="0" class="table">
  <tr>
    <td colspan="8" scope="col">
	<div style="float:left;">
	<select name="filtername">
		<option value="All" <?php if($_POST['filtername'] == 'All') echo "selected"; ?>>All Appointments</option>
		<option value="pending" <?php if($_POST['filtername'] == 'pending') echo "selected"; ?> >Pending Appointments</option>
		<option value="approved"  <?php if($_POST['filtername'] == 'approved') echo "selected"; ?> >Apporved Appointments</option>
		<option value="cancelled"  <?php if($_POST['filtername'] == 'cancelled') echo "selected"; ?> >Cancelled Appointments</option>
		<option value="done"  <?php if($_POST['filtername'] == 'done') echo "selected"; ?> >Done Appointments</option>
		<option value="today"  <?php if($_POST['filtername'] == 'today') echo "selected"; ?>  >Today's  Appointments</option>
	</select>
	
	</div>&nbsp;<button id="filter" class="btn btn-small" type="submit" name="filter">Filter Appointments</button>
	&nbsp;<a href="#" rel="tooltip" title="Filter Appointments." ><i  class="icon-question-sign"></i> </a>
  </tr>
  </table>
  </form>
  <?php 
  
	include('ps_pagination.php');
			$conn = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
			if(!$conn) die("Failed to connect to database!");
			$status = mysql_select_db(DB_NAME, $conn);
			if(!$status) die("Failed to select database!");
			
	
	if(isset($_POST['filter']))
  			{
					$filterdata =$_POST['filtername'];
					if($filterdata=='today')
					{
				 	$filterappointments = date('Y-m-d');
					$table_name = $wpdb->prefix . "ap_appointments";
					$sql = "SELECT * FROM `$table_name` WHERE `date` ='$filterappointments'";
					$pager = new PS_Pagination($conn, $sql, 10);
					$pager->setDebug(true);
					$all_appointments = $pager->paginate(); 
					
					}
					else
					{
					$filterappointments =$filterdata;
					$table_name = $wpdb->prefix . "ap_appointments";
					$sql = "SELECT * FROM `$table_name` WHERE `status` ='$filterappointments'";
					$pager = new PS_Pagination($conn, $sql, 10);
					$pager->setDebug(true);
					$all_appointments = $pager->paginate(); 
					
					}
					if($filterdata =='All')
					{
					$table_name = $wpdb->prefix . "ap_appointments";
					$sql = "SELECT * FROM `$table_name`";
					$pager = new PS_Pagination($conn, $sql, 10);
					$pager->setDebug(true);
					$all_appointments = $pager->paginate(); 
					}
				
					
			}
			else
			{
			/////////// wordpress  database user name and password
			$table_name = $wpdb->prefix . "ap_appointments";
			$sql = "SELECT * FROM `$table_name`";
			$pager = new PS_Pagination($conn, $sql, 10);
			$pager->setDebug(true);
			$all_appointments = $pager->paginate();
			}
   ?>
 <form action="" method="post" name="manage-appointments"> 
  <table width="100%" border="0" class="table">
  <tr>
    <th scope="col">No.</th>
    <th scope="col">Name</th>
    <th scope="col">Date</th>
    <th scope="col">Time</th>
    <th scope="col">Service</th>
    <th scope="col">Status</th>
    <th scope="col">Action</th>
    <th scope="col"><a href="#" rel="tooltip" title="Check To Select All Appointments." ><input type="checkbox" id="checkbox" name="checkbox[]" value="0" /></a>
	
	</th>
  </tr>
  <?php 
  
   //get all category list
   $i=1;
   
if($all_appointments)
{
	 while($appointment = mysql_fetch_assoc($all_appointments)) 
				{
				
	  ?>
  <tr>
  	<td><em><?php echo $i."."; ?></em></td>
    <td><em><?php echo ucfirst($appointment['name']); ?></em></td>
    <td><em><?php echo date("M. dS  Y", strtotime($appointment['date'])); ?></em></td>
    <td><em><?php echo $appointment['start_time']." To ".$appointment['end_time']; ?></em></td>
    <td><em>
      <?php $apppid=$appointment['service_id'];
		$table_name = $wpdb->prefix . "ap_services";
		$servicedetails= $wpdb->get_row("SELECT * FROM $table_name WHERE `id` ='$apppid'");	
		echo ucfirst($servicedetails->name);	
		 ?>
    </em> </td>
    <td><em><?php echo ucfirst($appointment['status']); ?></em></td>
    <td>
		<a href="?page=update-appointment&viewid=<?php echo $appointment['id']; ?>" title="View This Appointment" rel="tooltip"><i class="icon-eye-open"></i></a>
		 &nbsp;
		<a href="?page=update-appointment&updateid=<?php echo $appointment['id']; ?>" title="Update This Appointment" rel="tooltip"><i class="icon-pencil"></i></a> &nbsp;
		<a href="?page=manage-appointments&delete=<?php echo $appointment->id; ?>" rel="tooltip" title="Delete This Appointment" 
		onclick="return confirm('Do you want to delete this appointment')"><i class="icon-remove" ></i></td>
    <td><a rel="tooltip" title="Check To Select This Appointment"><input type="checkbox" id="checkbox" name="checkbox[]" value="<?php echo $appointment['id']; ?>" /> </a></td>
  </tr>
  <?php $i++; }   ?>
  <tr>
    <td colspan="5"><span  id="pagination-digg" ><?php echo $pager->renderFullNav(); ?> </span ></td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
    <td><button name="deleteall" class="btn btn-primary" type="submit" id="deleteall" onclick="return confirm('Do you want to delete this appointment')" >Delete</button></td>
  </tr>
  <?php } else { ?>
  <tr ><td colspan="8"><strong> Sorry no appointments</strong></td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
	</tr>
  <?php } ?>
</table>
</form>
<style type="text/css">
.error{  color:#FF0000; }
#pagination-digg {
background:#FFFFFF; 
color:#2e6ab1;
font-weight:bold;
padding:6px;
width:auto;
border: 0px solid #6699FF;

}
#pagination-digg .page_link
{
border:solid 1px #2e6ab1;
color:#888888;
font-weight:bold;
margin-right:2px;
padding:3px 4px;

}


</style>

<!--validation js lib-->
<script src="<?php echo plugins_url('/js/jquery.min.js', __FILE__); ?>" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function ()
 {
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
			
	});
</script>

 <?php
//********************* Delete appointnment *******************************	
			if(isset($_GET['delete']))
			{
				$deleteid= $_GET['delete'];
				$table_name = $wpdb->prefix . "ap_appointments";
				$delete_app_query="DELETE FROM `$table_name` WHERE `id` = '$deleteid';";
				//$wpdb->query($delete_app_query); 
				echo "<script>location.href='?page=manage-appointments';</script>";	
			}	
		
/********************Delete all appointment  with ckeckbox *****************************************/
if(isset($_POST['deleteall']))
 {
 		$table_name = $wpdb->prefix . "ap_appointments";
  		for($i=0;$i<=count($_POST['checkbox'])-1;$i++)
  			{
				$res=$_POST['checkbox'][$i];
				$deleteid= $res;
				$delete_app_query="DELETE FROM `$table_name` WHERE `id` = '$deleteid';";
				$wpdb->query($delete_app_query); 
			}
	}
?>

<!---Tooltip js ---------->
	<script src="<?php echo plugins_url('/bootstrap-assets/js/bootstrap-tooltip.js', __FILE__); ?>" type="text/javascript"></script>
	<script src="<?php echo plugins_url('/bootstrap-assets/js/bootstrap-affix.js', __FILE__); ?>" type="text/javascript"></script>
    <script src="<?php echo plugins_url('/bootstrap-assets/js/application.js', __FILE__); ?>" type="text/javascript"></script>
</div>
