<?php 
require 'include/header.php';
?>

<body data-col="2-columns" class=" 2-columns ">
	<div class="layer"></div>
	<!-- ////////////////////////////////////////////////////////////////////////////-->
	<div class="wrapper">

		<?php include('main.php'); 
		
		
			?>
		<!-- Navbar (Header) Ends-->

		<div class="main-panel">
			<div class="main-content">
				<div class="content-wrapper"><!--Statistics cards Starts-->
					<?php if(isset($_GET['edit'])) {
								if($username != 'admin' && $check_menu_area['edit'] !=1 ){
									?>
									<script>
										window.location.href="404.php";
									</script>
									<?php			
											}
						$sels = $con->query("select * from area_db where id=".$_GET['edit']."");
						$sels = $sels->fetch_assoc();
						?>
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-header">
										<h4 class="card-title" id="basic-layout-form">Edit Area</h4>

									</div>
									<div class="card-body">
										<div class="px-3">
											<form class="form" method="post" enctype="multipart/form-data">
												<div class="form-body">
													<div class="form-group">
														<label for="cname">Area Name</label>
														<input type="text" id="aname" value="<?php echo $sels['name'];?>" class="form-control"  name="cname" required >
													</div>

													<div class="form-group">
														<label for="cname">Delivery Charge(Only Digit)</label>
														<input type="number" id="dcharge" value="<?php echo $sels['dcharge'];?>" class="form-control"  name="dcharge" step="any"  required >
													</div>

													<div class="form-group">
														<label for="total">Verification Required ?<br>
														   	  <input type="radio" id="yes" name="verfication" value="1" <?php if($sels['verfication_status'] == 1 ){ echo 'checked'; } ?>>
															  <label for="yes">Yes</label>
															  <input type="radio" id="no" name="verfication" value="0" <?php if($sels['verfication_status'] == 0 ){ echo 'checked'; } ?>>
															  <label for="no">No</label></label>						
														
													</div>


													<div class="form-group">
														<label for="cname">Status</label>
														<select name="status" class="form-control">
															<option value="1" <?php if($sels['status'] == 1){echo 'selected';}?>>Publish</option>
															<option value="0" <?php if($sels['status'] == 0){echo 'selected';}?>>Unpublish</option>
														</select>
													</div>
												</div>

												<div class="form-actions">

													<button type="submit" name="up_cat" class="btn btn-raised btn-raised btn-primary">
														<i class="fa fa-check-square-o"></i> Save
													</button>
												</div>

<?php 
if(isset($_POST['up_cat'])){
$cname = mysqli_real_escape_string($con,$_POST['cname']);
$dcharge = $_POST['dcharge'];
$verfication = $_POST['verfication'];
$status = $_POST['status'];

$con->query("update area_db set name='".$cname."',status=".$status.",dcharge=".$dcharge.",verfication_status=".$verfication.",created_by=".$admin_id." where id=".$_GET['edit']."");
?>

<script type="text/javascript">
	$(document).ready(function() {
    toastr.options.timeOut = 4500; // 1.5s

    toastr.info('Area Update Successfully!!');
    setTimeout(function()
    {
    	window.location.href="alist.php";
    },1500);
    
});
</script>
<?php
}
?>
</form>
</div>
</div>
</div>
</div>


</div>
<?php } else { 
	if($username != 'admin' && $check_menu_area['create'] !=1 ){?>
		<script>
			window.location.href="404.php";
		</script>
	<?php	}	?>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-form">Add Area</h4>					
				</div>
				<div class="card-body">
					<div class="px-3">
						<form class="form" method="post" enctype="multipart/form-data">
							<div class="form-body">
								<div class="form-group">
									<label for="cname">Area Name</label>
									<input type="text" id="aname" class="form-control"  name="cname" required >
								</div>
								
								<div class="form-group">
									<label for="cname">Delivery Charge(Only Digit)</label>
									<input type="text" id="dcharge"  class="form-control" pattern="[0-9]+"  name="dcharge" required >
								</div>

								<div class="form-group">
									<label for="total">Verification Required ?<br>
									   	  <input type="radio" id="yes" name="verfication" value="1">
										  <label for="yes">Yes</label>
										  <input type="radio" id="no" name="verfication" value="0">
										  <label for="no">No</label></label>
											<!-- <input type="text" id="edit_fix_price" class="form-control"  value="" name="prc_wd_profit" style="display:none;" placeholder="enter fix value">
											<input type="text" id="edit_percentage_price" class="form-control"  value="" name="prc_wd_profit" style="display:none;" placeholder="Enter percentage"> -->
									
								</div>

								<div class="form-group">
									<label for="cname">Status</label>
									<select name="status" class="form-control">
										<option value="1">Publish</option>
										<option value="0">Unpublish</option>
									</select>
								</div>				
							</div>

							<div class="form-actions">
								
								<button type="submit" name="sub_cat" class="btn btn-raised btn-raised btn-primary">
									<i class="fa fa-check-square-o"></i> Save
								</button>
							</div>
							
<?php 
	if(isset($_POST['sub_cat'])){
	$cname = mysqli_real_escape_string($con,$_POST['cname']);
	$dcharge = mysqli_real_escape_string($con,$_POST['dcharge']);
	$verfication = mysqli_real_escape_string($con,$_POST['verfication']);
	$status = mysqli_real_escape_string($con,$_POST['status']);

	// echo "insert into area_db(`name`,`status`,`dcharge`,`verfication_status`)values('".$cname."',".$status.",".$dcharge.",".$verfication.")";
	$con->query("insert into area_db(`name`,`status`,`dcharge`,`verfication_status`,`created_by`)values('".$cname."',".$status.",".$dcharge.",".$verfication.",".$admin_id.")");
	?>

	<script type="text/javascript">
		$(document).ready(function() {
	toastr.options.timeOut = 4500; // 1.5s

	toastr.info('Insert Area Successfully!!!');

});
</script>
<?php 
}
?>
</form>
</div>
</div>
</div>
</div>

</div>
<?php } ?>
</div>
</div>
</div>
</div>

<?php 
require 'include/js.php';
?>


</body>


</html>