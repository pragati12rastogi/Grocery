<?php 
  require 'include/header.php';
  ?>
<?php 
function resizeImage($resourceType,$image_width,$image_height,$resizeWidth,$resizeHeight) {
    // $resizeWidth = 100;
    // $resizeHeight = 100;
    $imageLayer = imagecreatetruecolor($resizeWidth,$resizeHeight);
    $background = imagecolorallocate($imageLayer , 0, 0, 0);
        // removing the black from the placeholder
        imagecolortransparent($imageLayer, $background);

        // turning off alpha blending (to ensure alpha channel information
        // is preserved, rather than removed (blending with the rest of the
        // image in the form of black))
        imagealphablending($imageLayer, false);

        // turning on alpha channel information saving (to ensure the full range
        // of transparency is preserved)
        imagesavealpha($imageLayer, true);
    imagecopyresampled($imageLayer,$resourceType,0,0,0,0,$resizeWidth,$resizeHeight, $image_width,$image_height);
    return $imageLayer;
}
?>

  <body data-col="2-columns" class=" 2-columns ">
      <div class="layer"></div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="wrapper">


	<!-- main menu-->
	<!--.main-menu(class="#{menuColor} #{menuOpenType}", class=(menuShadow == true ? 'menu-shadow' : ''))-->
	<?php include('main.php'); 
	?>
	<!-- Navbar (Header) Ends-->

      	<div class="main-panel">
        	<div class="main-content">
          		<div class="content-wrapper"><!--Statistics cards Starts-->
					<?php 
						if(isset($_GET['edit'])) {
							if($username != 'admin' && $check_unit['edit'] !=1 ){
					?>
					<script>
						window.location.href="404.php";
					</script>
					<?php			
							}
							$sels = $con->query("select * from units where id=".$_GET['edit']."");
							$sels = $sels->fetch_assoc();
					?>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title" id="basic-layout-form">Edit Unit</h4>
									
								</div>
								<div class="card-body">
									<div class="px-3">
										<form class="form" method="post" enctype="multipart/form-data">
											<div class="form-body">
											
												<div class="form-group">
													<label for="cname">Unit Name</label>
													<input type="text" id="uname" value="<?php echo $sels['unit_name'];?>" class="form-control"  name="uname" required >
												</div>								
											</div>

											<div class="form-actions">
												
												<button type="submit" name="up_unit" class="btn btn-raised btn-raised btn-primary">
													<i class="fa fa-check-square-o"></i> Save
												</button>
											</div>
											
											<?php 
												if(isset($_POST['up_unit'])){
												$uname = mysqli_real_escape_string($con,$_POST['uname']);
												$uname = ucfirst($uname);				
												$con->query("update units set unit_name='".$uname."',created_by=".$admin_id." where id=".$_GET['edit']."");
				

											?>
										
											<script type="text/javascript">
												$(document).ready(function() {
													toastr.options.timeOut = 4500; // 1.5s

													toastr.info('Unit Update Successfully!!');
													setTimeout(function()
													{
														window.location.href="unitlist.php";
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
					<?php } else { if($username != 'admin' && $check_unit['create'] !=1 ){?>
						<script>
							window.location.href="404.php";
						</script>
					<?php	}	?>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title" id="basic-layout-form">Add Unit</h4>
									
								</div>
								<div class="card-body">
									<div class="px-3">
										<form class="form" method="post" enctype="multipart/form-data">
											<div class="form-body">
												<div class="form-group">
													<label for="cname">Unit Name</label>
													<input type="text" id="cname" class="form-control"  name="uname" required >
												</div>
											</div>

											<div class="form-actions">
												
												<button type="submit" name="unit" class="btn btn-raised btn-raised btn-primary">
													<i class="fa fa-check-square-o"></i> Save
												</button>
											</div>
											
											<?php 
											if(isset($_POST['unit'])){
											$uname = mysqli_real_escape_string($con,$_POST['uname']);
											$uname = ucfirst($uname);
											$con->query("insert into units(`unit_name`,created_by)values('".$uname."',".$admin_id.")");     


											?>
										
											<script type="text/javascript">
											$(document).ready(function() {
												toastr.options.timeOut = 4500; // 1.5s
												
												toastr.info('Insert Category Successfully!!!');
												
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