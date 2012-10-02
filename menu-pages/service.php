<!--validation js lib-->
<script src="<?php echo plugins_url('/js/jquery.min.js', __FILE__); ?>" type="text/javascript"></script>

<!---load bootstrap css----->
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/bootstrap-assets/css/bootstrap.css', __FILE__); ?>' />
<link rel='stylesheet' type='text/css' href='<?php // echo plugins_url('/bootstrap-assets/css/bootstrap.min.css', __FILE__); ?>' />
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/bootstrap-assets/css/bootstrap-responsive.css', __FILE__); ?>' />
<link rel='stylesheet' type='text/css' href='<?php //echo plugins_url('/bootstrap-assets/css/bootstrap-responsive.min.css', __FILE__); ?>' />
<div class="bs-docs-example tooltip-demo">
<div style="background:#C3D9FF; margin-bottom:10px; padding-left:10px;">  <h3> Services</h3> </div>
<?php 
	global $wpdb;
	//get all category list
	$table_name = $wpdb->prefix . "ap_service_category";
	$service_category = $wpdb->get_results("select * from $table_name"); 
	foreach($service_category as $gruopname) 
		{?>					
			<table class="table">
				<thead>
				  	<tr style="background:#C3D9FF; margin-bottom:10px; padding-left:10px;">
					<th id="yw7_c1" colspan="3">
						 <div id="gruopnamedivbox<?php echo $gruopname->id; ?>"><?php echo ucfirst($gruopname->name); ?>  </div> 
						 <div id="gruopnameedit<?php echo $gruopname->id; ?>" style="display:none; height:25px;">
						 <form method="post">
								<input type="text" id="editgruopname" class="inputheight" name="editgruopname" value="<?php echo $gruopname->name; ?>"/>
								<button  id="editgruop" value="<?php echo $gruopname->id; ?>" name="editgruop" type="submit" class="btn btn-primary"  >Save </button>
								<button  id="editgruopcancel" type="button" class="btn btn-primary"  onclick="canceleditgrup(<?php echo $gruopname->id; ?>)">Cancel </button>
							</form>		 
						</div>					</th>
					<th id="yw7_c1" colspan="3"> <!--- header rename and delete button right box-->
						<div align="right">
							<?php if($gruopname->id !='1') { ?>
								<a rel="tooltip" href="#" id="<?php echo $gruopname->id; ?>" onclick="editgruop(<?php echo $gruopname->id; ?>)" title="Rename This Category">Rename</a>	 | 
								<a rel="tooltip" href="?page=service&gid=<?php echo $gruopname->id; ?>"  onclick="return confirm('Do you want to delete this catagory')" title="Delete This Category" >Delete</a>
							<?php } ?>
					</div>					</th></tr>
					<tr>
					<!--<th id="yw7_c0">#</th>-->
					<td ><strong> name </strong></td>
					<td ><strong>Description</strong></th>
					<td ><strong> Duration </strong></th>
					<td ><strong>Cost </strong></th>
					<td ><strong>Availability</strong></th>
					<td ><strong> Action</strong></th>					</tr>
					</thead>
					<tbody>
					<?php
						// get service list group wise
						$table_name = $wpdb->prefix . "ap_services";
						$servicedetails= $wpdb->get_results("SELECT * FROM $table_name WHERE `category_id` ='$gruopname->id'");					
						foreach($servicedetails as $service)
						{
					?><tr class="odd" style="border-bottom:1px;">
							<td><em><?php echo $service->name; ?></em></td>
							<td> <em><?php echo $service->desc; ?></em> </td>
							<td><em><?php echo $service->duration. " ".$service->unit; ?></em></td>
							<td><em><?php echo $service->cost; ?></em></td>
							<td><em><?php echo $service->availability; ?></em></td>
							<td class="button-column">
<a rel="tooltip" href="?page=manage-service&sid=<?php echo $service->id; ?>" title="Update This Service"><i class="icon-pencil"></i></a> &nbsp;
<a rel="tooltip" href="?page=service&sid=<?php echo $service->id; ?>" onclick="return confirm('Do you want to delete this service')" title="Delete This Service" ><i class="icon-remove"></i>							</td>
						</tr>
						<?php } ?>
						<tr><td colspan="6">
							<a href="?page=manage-service&gid=<?php echo $gruopname->id; ?>" rel="tooltip" title="Add New Service to this Category">+ Add New Service to this Category</a></td>
						</tr>
						</tbody>
			</table>
			<?php  } ?>
<!------------------------------ New category div box  -------------------------------------->	
			<div id="gruopbuttonbox"> 
				<a class="btn btn-primary"  href="#" rel="tooltip" class="Create Gruop" onclick="creategruopname()">Create New Service Category</a></u>
			</div>
		
			<div style="display:none;" id="gruopnamebox">
			<form method="post">
				Service Category name : <input type="text" id="gruopname" name="gruopname" class="inputheight" />
				<button style="margin-bottom:10px;" id="CreateGruop" type="submit" class="btn btn-primary" name="CreateGruop">Create Category</button>
				<button style="margin-bottom:10px;" id="CancelGruop" type="button" class="btn btn-primary" name="CancelGruop" onclick="cancelgrup()">Cancel</button>
			</form>
			</div>
<!------------------------------ New category div box end -------------------------------------->	


<?php 
 //********************* insert new service category *******************************
 		if(isset($_POST['CreateGruop']))
			{	//print_r($_POST);
				global $wpdb;
				$groupename=$_POST['gruopname'];
				$table_name = $wpdb->prefix . "ap_service_category";
				$service_category = "INSERT INTO $table_name (
									`name` 
									)VALUES ('$groupename');";
				$wpdb->query($service_category);	
				echo "<script>location.href='?page=service';</script>";	
			}
//********************* update service category *******************************	
		if(isset($_POST['editgruop']))
			{
				$table_name = $wpdb->prefix . "ap_service_category";
 				$update_id = $_POST['editgruop'];
				$update_name = $_POST['editgruopname'];
				echo $tt = !is_numeric($update_name);
				if($update_name)
				{
					if(!is_numeric($update_name))
					{
					$update_app_query = "UPDATE $table_name SET `name` = '$update_name' WHERE `id` ='$update_id';";
					$wpdb->query($update_app_query);
					echo "<script>location.href='?page=service';</script>";	
					}
					else
					{
					echo "<script>alert('invalid gruop name');</script>";
					}
				}
				else
				{
				echo "<script>alert('Gruop name cannot be blank..');</script>";
								
				}
			}
//********************* Delete service category *******************************	
			if(isset($_GET['gid']))
			{
				$deleteid= $_GET['gid'];
				$table_name = $wpdb->prefix . "ap_service_category";
				$delete_app_query="DELETE FROM $table_name WHERE `id` = '$deleteid';";
				$wpdb->query($delete_app_query); 
				
//*******************update all service category id *************************				
				$table_name = $wpdb->prefix . "ap_services";
				$update_app_query_service = "UPDATE $table_name SET `category_id` = '1' WHERE `category_id` ='$deleteid';";
				$wpdb->query($update_app_query_service); // update category 
				
				echo "<script>location.href='?page=service';</script>";	
			}

//**********************************Delete service*****************************************
			if(isset($_GET['sid']))
			{
				$deletesid= $_GET['sid'];
				$table_name = $wpdb->prefix . "ap_services";
				$delete_app_query="DELETE FROM $table_name WHERE `id` = '$deletesid';";
				$wpdb->query($delete_app_query);
				echo "<script>location.href='?page=service';</script>";	
			}
			
		
 ?>
<!--js work-->					
<style type="text/css">
.error{  color:#FF0000; }
input.inputheight
{
height:30px;
}
#editgruop
{
margin-bottom:10px;
}
#editgruopcancel
{
margin-bottom:10px;
}
</style>

<script type="text/javascript">
// edit gruop hide and show div box
	function editgruop(id)
			{	var gneb='#gruopnamedivbox'+id;
				var gne='#gruopnameedit'+id;
				$(gneb).hide();
				$(gne).show();
			} 
			
	function canceleditgrup(id)
			{	var gneb='#gruopnamedivbox'+id;
				var gne='#gruopnameedit'+id;
				$(gneb).show();
				$(gne).hide();			
			}
			
/************ gruop create and  hide  or show div box ajax post data  ******************/
	function creategruopname()
		{	$('#gruopnamebox').show();
			$('#gruopbuttonbox').hide();
		}
	function cancelgrup()
		{	$('#gruopnamebox').hide();
			$('#gruopbuttonbox').show();
		}
			
</script>
<script type="text/javascript">
$(document).ready(function () {
	/***************** create new gruop js  *******************************/
	$('#CreateGruop').click(function() 
		{
			$('.error').hide();  
			var gruopname = $("input#gruopname").val();  
			if (gruopname == "")
			{  	$("#CancelGruop").after('<span class="error">&nbsp;<br><strong>Category name cannot be blank.</strong></span>');
				return false; 
			}
			else
			{	var gruopname = isNaN(gruopname);
				if(gruopname == false) 
				{ 	
				$("#CancelGruop").after('<span class="error">&nbsp;<br><strong>invalid Category name.</strong></span>');
				return false; 
				
				}
			}
			
			$('#gruopnamebox').hide();
			$('#gruopbuttonbox').show();
			
		});

});
</script>

<!---Tooltip js ---------->
	<script src="<?php echo plugins_url('/bootstrap-assets/js/bootstrap-tooltip.js', __FILE__); ?>" type="text/javascript"></script>
	<script src="<?php echo plugins_url('/bootstrap-assets/js/bootstrap-affix.js', __FILE__); ?>" type="text/javascript"></script>
    <script src="<?php echo plugins_url('/bootstrap-assets/js/application.js', __FILE__); ?>" type="text/javascript"></script>
</div>