<?php 
  require 'include/header.php';
  ?>

  <body data-col="2-columns" class=" 2-columns ">
      <div class="layer"></div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="wrapper">     
      <?php include('main.php'); ?>
      <!-- Navbar (Header) Ends-->

      <div class="main-panel">
        <div class="main-content">
          <div class="content-wrapper"><!--Statistics cards Starts-->
          	<?php if(isset($_GET['edit'])) {      
				  if($username != 'admin' && $check_menu_agent['edit'] !=1 ){?>
					<script>
						window.location.href="404.php";
					</script>
				<?php	}    		
				$sels = $con->query("select * from agents where id=".$_GET['edit']."");
				$sels = $sels->fetch_assoc();
				?>
				<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-form">Edit Agent</h4>
					
				</div>
				<div class="card-body">
					<div class="px-3">
						<form class="form" method="post" enctype="multipart/form-data">
							<div class="form-body">

								

								<div class="form-group">
									<label for="cname">Agent Name</label>
									<input type="text" id="aname" class="form-control" placeholder="Enter Agent Name"  name="cname" value="<?php echo $sels['name'];?>" required >
								</div>
								
								<div class="form-group">
									<label for="cname">Agent Mobile Number(Only Digit)</label>
									<input type="text" id="dcharge" class="form-control" pattern="[0-9]+"  placeholder="Enter Agent Mobile Number" name="mobile" value="<?php echo $sels['mobile'];?>" required >
								</div>
								
									<div class="form-group">
									<label for="cname">Agent Email Address</label>
									<input type="email" class="form-control" placeholder="Enter Agent Email Address" name="email" value="<?php echo $sels['email'];?>" required >
								</div>
								
								<div class="form-group">
									<label for="cname">Agent Password</label>
									<input type="text" class="form-control" placeholder="Enter Agent Password" name="password" value="<?php echo $sels['password'];?>" required >
								</div>
								
 									<div class="form-group">
									<label for="cname">Select A Area</label>
									<select name="area_id" class="form-control" required>
									    <option value="">Select A Area</option>
									    <?php
										if($username == 'admin' || $check_menu_agent['view_g'] ==1){
											$sr = $con->query("select * from area_db");
										}else{
											$sr = $con->query("select * from area_db where created_by =".$admin_id);
										}
									    
									    while($r = $sr->fetch_assoc())
									    {
									    ?>
									    <option value="<?php echo $r['id'];?>" <?php if($r['id'] == $sels['area_id']){ echo "selected";} ?> ><?php echo $r['name'];?></option>
									    <?php } ?>
									</select>
								</div>
								
									<div class="form-group">
									<label for="cname">Agent Address</label>
								<textarea style="resize: none;" class="form-control" name="raddress"><?php echo $sels['address'];?></textarea>
								</div>
								
								<div class="form-group">
									<label for="total">Set Agent Profit Type<br>
								   	  <input type="radio" id="fix_profit" name="profit_type" value="fixed" <?php if($sels['profit_type'] == "fixed"){ echo "checked";} ?>>
									  <label for="fix_profit">Fix</label><br>
									  <input type="radio" id="percent_profit" name="profit_type" value="percentage" <?php if($sels['profit_type'] == "percentage"){ echo "checked";} ?> >
									  <label for="percent_profit">Percentage</label></label>						
									
								</div>
								<div class="form-group">
									<label for="cname">Status</label>
									<select name="status" class="form-control">
									    <option value="1" <?php if($sels['status'] == 1){ echo "selected";} ?> >Active</option>
									    <option value="0" <?php if($sels['status'] == 0 ){ echo "selected";}?> >Deactive</option>
									</select>
								</div>			
							</div>

							<div class="form-actions">								
								<button type="submit" name="edit_agent" class="btn btn-raised btn-raised btn-primary">
									<i class="fa fa-user"></i> Save
								</button>
							</div>

							<?php 
							if(isset($_POST['edit_agent'])){
							$cname = mysqli_real_escape_string($con,$_POST['cname']);
							$status = $_POST['status'];
							$mobile = $_POST['mobile'];
							$password = $_POST['password'];
							$email = $_POST['email'];
							$agnt_address = $_POST['raddress'];
							$area_id = $_POST['area_id'];
							$agprofit_type = $_POST['profit_type'];			
					
						
							$con->query("update agents set name='".$cname."',email='".$email."',mobile='".$mobile."',password='".$password."', area_id='".$area_id."',address='".$agnt_address."',profit_type='".$agprofit_type."', status='".$status."',created_by = ".$admin_id." where id='".$_GET['edit']."'");
							
							?>
													
							<script type="text/javascript">
							  $(document).ready(function() {
							    toastr.options.timeOut = 4500; // 1.5s

							    toastr.info('Insert Agent Successfully!!!');

							   setTimeout(function()
								{
									window.location.href="agentslist.php";
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
	<?php }else{
		if($username != 'admin' && $check_menu_agent['create'] !=1 ){?>
			<script>
				window.location.href="404.php";
			</script>
		<?php	}
?>


	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-form">Add Agent</h4>
					
				</div>
				<div class="card-body">
					<div class="px-3">
						<form class="form" method="post" enctype="multipart/form-data">
							<div class="form-body">

								

								<div class="form-group">
									<label for="cname">Agent Name</label>
									<input type="text" id="aname" class="form-control" placeholder="Enter Agent Name"  name="cname" required >
								</div>
								
								<div class="form-group">
									<label for="cname">Agent Mobile Number(Only Digit)</label>
									<input type="text" id="dcharge"   class="form-control" pattern="[0-9]+"  placeholder="Enter Agent Mobile Number" name="dcharge" required >
								</div>
								
									<div class="form-group">
									<label for="cname">Agent Email Address</label>
									<input type="email" class="form-control"   placeholder="Enter Agent Email Address" name="email" required >
								</div>
								
								<div class="form-group">
									<label for="cname">Agent Password</label>
									<input type="text" class="form-control"   placeholder="Enter Agent Password" name="password" required >
								</div>
								
 									<div class="form-group">
									<label for="cname">Select A Area</label>
									<select name="area_id" class="form-control" required>
									    <option value="">Select A Area</option>
									    <?php
									    if($username == 'admin' || $check_menu_agent['view_g'] ==1){
											$sr = $con->query("select * from area_db");
										}else{
											$sr = $con->query("select * from area_db where created_by =".$admin_id);
										}
									    while($r = $sr->fetch_assoc())
									    {
									    ?>
									    <option value="<?php echo $r['id'];?>"><?php echo $r['name'];?></option>
									    <?php } ?>
									</select>
								</div>
								
									<div class="form-group">
									<label for="cname">Agent Address</label>
								<textarea style="resize: none;" class="form-control" name="raddress"></textarea>
								</div>
								
								<div class="form-group">
									<label for="total">Set Agent Profit Type<br>
								   	  <input type="radio" id="fix_profit" name="profit_type" value="fixed">
									  <label for="fix_profit">Fix</label><br>
									  <input type="radio" id="percent_profit" name="profit_type" value="percentage">
									  <label for="percent_profit">Percentage</label></label>						
									
								</div>
								<div class="form-group">
									<label for="cname">Status</label>
									<select name="status" class="form-control">
									    <option value="1">Active</option>
									    <option value="0">Deactive</option>
									</select>
								</div>					

								
							</div>

							<div class="form-actions">
								
								<button type="submit" name="sub_cat" class="btn btn-raised btn-raised btn-primary">
									<i class="fa fa-user"></i> Save Agent
								</button>
							</div>
							
							<?php 
							if(isset($_POST['sub_cat'])){
							$cname = mysqli_real_escape_string($con,$_POST['cname']);
							$status = $_POST['status'];
							$dcharge = $_POST['dcharge'];
							$password = $_POST['password'];
							$email = $_POST['email'];
							$raddress = $_POST['raddress'];
							$area_id = $_POST['area_id'];
							$agprofit_type = $_POST['profit_type'];

						$check_email = $con->query("select * from agents where email='".$email."'")->num_rows;
						$check_mobile = $con->query("select * from agents where mobile='".$dcharge."'")->num_rows;
						if($check_email != 0)
						{
							?>
							<script type="text/javascript">
								  $(document).ready(function() {
								    toastr.options.timeOut = 4500; // 1.5s

								    toastr.info('Email Address Already Used.');

								   setTimeout(function()
									{
										window.location.href="add_agent.php";
									},1500);
									
								  });
							</script>
														<?php 
						}
						else if($check_mobile != 0)
						{
							?>
						<script type="text/javascript">
							  $(document).ready(function() {
							    toastr.options.timeOut = 4500; // 1.5s

							    toastr.error('Mobile Number Already Used.');

							   setTimeout(function()
								{
									window.location.href="add_agent.php";
								},1500);
								
							  });
							  </script>	
							<?php 
						}
						else 
						{
							$con->query("insert into agents(`name`,`mobile`,`email`,`area_id`,`status`,`address`,`profit_type`,`password`,`created_by`)values('".$cname."','".$dcharge."','".$email."',".$area_id.",".$status.",'".$raddress."','".$agprofit_type."','".$password."',".$admin_id.")");
							?>
													
							<script type="text/javascript">
							  $(document).ready(function() {
							    toastr.options.timeOut = 4500; // 1.5s

							    toastr.info('Insert Agent Successfully!!!');

							   setTimeout(function()
								{
									window.location.href="agentslist.php";
								},1500);
								
							  });
							  </script>
							 <?php 
							}
							}
							?>
						</form>
					</div>
				</div>
			</div>
		</div>		
	</div>
<?php }?>
          </div>
        </div>

        

      </div>
    </div>
    
   <?php 
  require 'include/js.php';
  ?>
    

  </body>


</html>