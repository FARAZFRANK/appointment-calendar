<!---load bootstrap css----->
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/bootstrap-assets/css/bootstrap.css', __FILE__); ?>' />
<link rel='stylesheet' type='text/css' href='<?php // echo plugins_url('/bootstrap-assets/css/bootstrap.min.css', __FILE__); ?>' />
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/bootstrap-assets/css/bootstrap-responsive.css', __FILE__); ?>' />
<link rel='stylesheet' type='text/css' href='<?php //echo plugins_url('/bootstrap-assets/css/bootstrap-responsive.min.css', __FILE__); ?>' />


<div style="background:#C3D9FF; margin-bottom:10px; padding-left:10px;">  <h3> Services</h3> </div>
<!--/******************************** manage service form **********************************/-->	
<div class="bs-docs-example tooltip-demo">
<?php 
	global $wpdb;
	if($_GET['sid'])
	{	
		$sid=$_GET['sid'];
		$table_name = $wpdb->prefix . "ap_services";
		$servicedetails="SELECT * FROM $table_name WHERE `id` ='$sid'";
		$servicedetails1 = $wpdb->get_row($servicedetails);
		$servicedetails1->category_id; 
	}
?>
	<form action="" method="post" name="manageservice">
			<table width="100%" class="table" >
			   <tr>
				<th scope="row">Name</th>
				<td>&nbsp;</td>
				<td><input name="name" type="text" id="name"  value="<?php echo $servicedetails1->name; ?>" class="inputheight"/>
				&nbsp;<a href="#" rel="tooltip" title="Service Name." ><i  class="icon-question-sign"></i> </a></td>
			  </tr>
			  <tr>
				<th scope="row"><strong>Description</strong></th>
				<td>&nbsp;</td>
				<td><textarea name="desc" id="desc"><?php echo $servicedetails1->desc; ?></textarea>&nbsp;<a href="#" rel="tooltip" title="Service Descritpion." ><i  class="icon-question-sign"></i> </a>
				</td>
			  </tr>
			   <tr>
				<th scope="row"><strong>Duration</strong></th>
				<td>&nbsp;</td>
				<td><input name="Duration" type="text" id="Duration"  value="<?php echo $servicedetails1->duration; ?>" class="inputheight"/>&nbsp;<a href="#" rel="tooltip" title="Service Duration, Enter Numeric Value, eg: 15, 30, 60." ><i  class="icon-question-sign"></i> </a></td>
			  </tr>
			  
			  <tr>
				<th scope="row"><strong>Duration Unit</strong></th>
				<td>&nbsp;</td>
				<td><select id="durationunit" name="durationunit">
				<option value="0">Select Duration's Unit</option>
				<option value="minute" <?php if($servicedetails1->unit == 'minute') echo "selected"; ?> >Minute(s)</option>
				</select>
				&nbsp;<a href="#" rel="tooltip" title="Duration Unit." ><i  class="icon-question-sign"></i> </a>
				</td>
			  </tr>
			  <tr>
				<th scope="row"><strong>Cost</strong></th>
				<td>&nbsp;</td>
				<td><input name="cost" type="text" id="cost" value="<?php echo $servicedetails1->cost; ?>" class="inputheight"/>
				&nbsp;<a href="#" rel="tooltip" title="Service Cost, Enter Numeric Value eg: 50, 100, 150." ><i  class="icon-question-sign"></i> </a>
				</td>
			  </tr>
			  <tr>
				<th scope="row"><strong>Availability</strong></th>
				<td>&nbsp;</td>
				<td>
				<select id="availability" name="availability">
				<option value="0">Select Service Availability</option>
				<option value="yes" <?php if($servicedetails1->availability == 'yes') echo "selected"; ?> >Yes</option>
				<option value="no" <?php if($servicedetails1->availability == 'no') echo "selected"; ?> >No</option>
				</select>
				&nbsp;<a href="#" rel="tooltip" title="Service Availability." ><i  class="icon-question-sign"></i> </a>
				</td>
			  </tr>
			  <tr>
				<th scope="row">Category</th>
				<td>&nbsp;</td>
				
				<td><select id="category" name="category">
					  <option value="0">Select Category</option>
					  <?php //get all category list					 	
					  	$table_name = $wpdb->prefix . "ap_service_category";
						$service_category = $wpdb->get_results("select * from $table_name"); 
						foreach($service_category as $gruopname) 
						{	?>
							<option value="<?php echo $gruopname->id; ?>" 
								<?php if($servicedetails1->category_id == $gruopname->id) echo "selected";  ?><?php if($_GET['gid'] == $gruopname->id) echo "selected"; ?> >
								<?php echo $gruopname->name; ?>
							</option>
						<?php } ?>
					</select>
					&nbsp;<a href="#" rel="tooltip" title="Service Category." ><i  class="icon-question-sign"></i> </a>
				</td>
			  </tr>
			  <tr>
				<th scope="row">&nbsp;</th>
				<td>&nbsp;</td>
				<td> <?php if($_GET['sid'])	{	?>
					<button id="saveservice" type="submit" class="btn btn-primary" name="updateservice">Update</button>
					<?php } else {?>
					<button id="saveservice" type="submit" class="btn btn-primary" name="saveservice">Create</button>
					<?php } ?>
					<a href="?page=service" class="btn btn-primary">Cancel</a>
				</td>
			  </tr>
		  </table>
	</form>
	
<?php //*************inserting a service ************************* 
		if(isset($_POST['saveservice']))	
		{	//print_r($_POST);
			$servicename=$_POST['name'];
			$desc=$_POST['desc'];
			$Duration=$_POST['Duration'];
			$durationunit=$_POST['durationunit'];
			$cost=$_POST['cost'];
			$availability=$_POST['availability'];
			$category=$_POST['category'];
			
			$table_name = $wpdb->prefix . "ap_services";
			$insert_service = "INSERT INTO $table_name (
								`name` ,
								`desc` ,
								`duration` ,
								`unit` ,
								`cost` ,
								`availability`,
								`category_id`
								)VALUES ('$servicename', '$desc', '$Duration', '$durationunit', '$cost', '$availability', '$category');";
			$wpdb->query($insert_service);	
			echo "<script>location.href='?page=service';</script>";		
		}

 //*************upadte a service ************************* 
		if(isset($_POST['updateservice']))	
		{
			//print_r($_POST);
			$sid=$_GET['sid']; 
			$servicename=$_POST['name'];
			$desc=$_POST['desc'];
			$Duration=$_POST['Duration'];
			$durationunit=$_POST['durationunit'];
			$cost=$_POST['cost'];
			$availability=$_POST['availability'];
			$category=$_POST['category'];
			
			$table_name = $wpdb->prefix . "ap_services";
			$update_service ="UPDATE $table_name SET `name` = '$servicename',
								`desc` = '$desc',
								`duration` = '$Duration',
								`unit` = '$durationunit',
								`cost` = '$cost',
								`availability` = '$availability',
								`category_id` = '$category' WHERE `id` ='$sid';";
								
			$wpdb->query($update_service);	
			echo "<script>location.href='?page=service';</script>";						
		}
?>					
	
<style type="text/css">
		.error{  color:#FF0000; }
		input.inputheight
		{
		height:30px;
		}
</style>
<!--validation js lib-->
<script src="<?php echo plugins_url('/js/jquery.min.js', __FILE__); ?>" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function () {
	
	$('#saveservice').click(function() 
		{
			$('.error').hide();  
			var name = $("input#name").val();  
			if (name == "")
			{  	$("#name").after('<span class="error">&nbsp;<br><strong>Name cannot be blank.</strong></span>');
				return false; 
			}
			else
			{	var name = isNaN(name);
				if(name == false) 
				{ 	
				$("#name").after('<span class="error">&nbsp;<br><strong>invalid name.</strong></span>');
				return false; 
				}
			}
			
			var desc = $("textarea#desc").val();  
			if (desc == "")
			{  	$("#desc").after('<span class="error">&nbsp;<br><strong>description cannot be blank.</strong></span>');
				return false; 
			}
			
			var Duration = $("input#Duration").val();  
			if (Duration == "")
			{  	$("#Duration").after('<span class="error">&nbsp;<br><strong>Duration cannot be blank.</strong></span>');
				return false; 
			}
			else
			{	var Duration = isNaN(Duration);
				if(Duration == true) 
				{ 	
				$("#Duration").after('<span class="error">&nbsp;<br><strong>Invalid Duration.</strong></span>');
				return false; 
				}
			}
			
			var durationunit = $('#durationunit').val();
			if(durationunit == 0)
			{
				$("#durationunit").after('<span class="error">&nbsp;<br><strong>Select Durations Unit.</strong></span>');
				return false;
			}
			
			var cost = $("input#cost").val();  
			if (cost == "")
			{  	$("#cost").after('<span class="error">&nbsp;<br><strong>cost cannot be blank.</strong></span>');
				return false; 
			}
			else
			{	var cost = isNaN(cost);
				if(cost == true) 
				{ 	
				$("#cost").after('<span class="error">&nbsp;<br><strong>Invalid cost.</strong></span>');
				return false; 
				}
			}
			
			var availability = $('#availability').val();
			if(availability == 0)
			{
				$("#availability").after('<span class="error">&nbsp;<br><strong>Select availability.</strong></span>');
				return false;
			}
			
			var category = $('#category').val();
			if(category == 0)
			{
				$("#category").after('<span class="error">&nbsp;<br><strong>Select category.</strong></span>');
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

