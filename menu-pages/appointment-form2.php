<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/bootstrap-assets/css/bootstrap.css', __FILE__); ?>' />

<div class="bs-docs-example tooltip-demo">

<div style="height:auto; width:600px;" id="myModalsecond"> 
	<form method="post" name="selecttimesloatappointment" id="selecttimesloatappointment">
		<div class="modal-info">
			<div class="alert alert-info">
				<a href="?page=appointment-calendar" style="float:right; margin-right:14px; margin-top:-4px;" id="close"><i class="icon-remove"></i></a>
				<h4>Schedule New Appoinmnet </h4>Setect Time & Fill up Form</div>
		</div>

		<div class="modal-body">
			<div id="timesloatbox" class="alert alert-block" style="float:left; height:auto; width:auto; border:#00CC00 0px solid;">
			<?php 	include('time-slots-calculation.php'); ?>
			</div>
			<div id="clientboxform" style="float:left; width:auto;" >
				<?php 
	if(!$Enable)
	{
		echo "<p align=center class='alert alert-error'><strong>Sorry! Today's all appointments has been booked.</strong> <a href='#' class='btn btn-primary' id='back' onclick='backtodate()'>&larr; Back</a></p>";
	}else
	{
	?>
				<div style="margin-left:0px; width:550px;">
					<input type="hidden" name="serviceid" id="serviceid" value="<?php echo $_GET['service']; ?>" />
					<input type="hidden" name="appointmentdate" id="appointmentdate"  value="<?php echo $_GET['bookdate']; ?>" />
					<input type="hidden" name="serviceduration" id="serviceduration"  value="<?php echo $ServiceDuration; ?>" />
					<table class="table">
					  <tr>
						<th scope="row" >Name</th>
						<td><strong>:</strong></td>
						<td><input type="text" name="name" id="name" class="inputwidth"/>
						&nbsp;<a href="#" rel="tooltip" title="Client Name." ><i  class="icon-question-sign"></i> </a>
						</td>
					  </tr>
					 <tr>
						<th scope="row" >Email</th>
						<td><strong>:</strong></td>
						<td><input type="text" name="email" id="email" class="inputwidth">
						&nbsp;<a href="#" rel="tooltip" title="Client Email." ><i  class="icon-question-sign"></i> </a>
						</td>
					  </tr>
					  <tr>
						<th scope="row" >Phone</th>
						<td><strong>:</strong></td>
						<td><input name="phone" type="text" class="inputwidth" id="phone" maxlength="12"/>
						<br/><label>Eg : 1234567890</label>
						&nbsp;<a href="#" rel="tooltip" title="Client Phone." ><i  class="icon-question-sign"></i> </a>
						</td>
					  </tr>
					  
					  <tr>
						<th scope="row" >Special Instruction</th>
						<td><strong>:</strong></td>
						<td><textarea name="desc" id="desc" class="inputwidth"></textarea>
						&nbsp;<a href="#" rel="tooltip" title="Appointments Description." ><i  class="icon-question-sign"></i> </a>
						</td>
					  </tr>
					  <tr>
					  	<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>
						<a href="#"class="btn btn-primary" id="back" onclick="backtodate()">&larr; Back</a>
						<button name="booknowapp" class="btn btn-primary" type="button" id="booknowapp" onclick="hari()">Book Now</button>
						
						</td>
					  </tr>
				  </table>
				 </div> 
			</div>
		</div>
	<?php } //end else?>
	</form>
</div>
	

<!---Tooltip js ---------->
	<script src="<?php echo plugins_url('/bootstrap-assets/js/bootstrap-tooltip.js', __FILE__); ?>" type="text/javascript"></script>
	<script src="<?php echo plugins_url('/bootstrap-assets/js/bootstrap-affix.js', __FILE__); ?>" type="text/javascript"></script>
    <script src="<?php echo plugins_url('/bootstrap-assets/js/application.js', __FILE__); ?>" type="text/javascript"></script>
</div>
