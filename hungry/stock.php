<?php 
  require 'include/header.php';
  ?>
<?php 
$getkey = $con->query("select * from setting")->fetch_assoc();
define('ONE_KEY',$getkey['one_key']);
define('ONE_HASH',$getkey['one_hash']);
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

function sendMessage($title){
		$content = array(
			"en" => 'New Product-'.$title
			);
		
		$fields = array(
			'app_id' => ONE_KEY,
			'included_segments' => array('Active Users'),
			'data' => array('type' =>1),
			'contents' => $content
		);
		
		$fields = json_encode($fields);
    	//print("\nJSON sent:\n");
    	//print($fields);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
												   'Authorization: Basic '.ONE_HASH));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$response = curl_exec($ch);
		curl_close($ch);
		
		return $response;
	}
	
	function sendMessages($title){
		$content = array(
			"en" => 'Product-'.$title.'Updated'
			);
		
		$fields = array(
			'app_id' => ONE_KEY,
			'included_segments' => array('Active Users'),
			'data' => array('type' =>1),
			'contents' => $content
		);
		
		$fields = json_encode($fields);
    	//print("\nJSON sent:\n");
    	//print($fields);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
												   'Authorization: Basic '.ONE_HASH));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$response = curl_exec($ch);
		curl_close($ch);
		
		return $response;	
	}

	$stock_item = $con->query("select product_name from inventory_stock order by id desc")->fetch_all(MYSQLI_ASSOC);
	$stock_item = array_column($stock_item,'product_name');
                                            
?>

  <body data-col="2-columns" class=" 2-columns ">
       <div class="layer"></div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="wrapper">


      <!-- main menu-->
      <!--.main-menu(class="#{menuColor} #{menuOpenType}", class=(menuShadow == true ? 'menu-shadow' : ''))-->
      <?php include('main.php'); ?>
      <!-- Navbar (Header) Ends-->

      <div class="main-panel">
        <div class="main-content">
          <div class="content-wrapper"><!--Statistics cards Starts-->
<?php 
if(isset($_GET['edit']))
{
	if($username != 'admin' && $check_menu_stock['edit'] !=1 ){
		?>
		<script>
			window.location.href="404.php";
		</script>
		<?php			
	}
    $selk = $con->query("select * from inventory_stock where id=".$_GET['edit']."")->fetch_assoc();
?>
	<script>
		
		$(document).ready(function(){
			$("input[name='fix']:checked").trigger('click');
			
		});
		function profit_input_fn(inp){
			
			if(inp.value == 'Fixed'){
				$('#edit_fix_price').show(200);
				$('#edit_percentage_price').hide(200);
			}else{
				$('#edit_percentage_price').show(200);
				$('#edit_fix_price').hide(200);
			}
		}	
	</script>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-form">Edit Stock</h4>
					
				</div>
				<div class="card-body">
					<div class="px-3">
						<form class="form" autocomplete="off" method="post" enctype="multipart/form-data">
							<div class="form-body">
								

								<div class="form-group">
									<label for="cname">Product Name</label>
									<input type="text" id="vname" list="products" class="form-control"  value="<?php echo $selk['product_name'];?>" name="pname" required>
								</div>
								                           
                               <!--  <div class="form-group">
									<label for="gurl">Seller Name / Shop Name</label>
									<input type="text" id="gurl" class="form-control"  placeholder="Enter Seller Name" value="<?php echo $selk['sname'];?>" name="sname" required>
									
								</div> -->
								
								<div class="form-group">
											<label for="projectinput6">Select Category</label>
											<select id="cat_change" name="catname" class="form-control">
												
												<?php 
												$j = mysqli_fetch_assoc(mysqli_query($con,"select * from category where id=".$selk['cat_id'].""));
												?>
												<option value="<?php echo $j['id'];?>"><?php echo $j['catname'];?></option>
												<?php 
												$sk = mysqli_query($con,"select * from category where id !=".$selk['cat_id']."");
												while($h = mysqli_fetch_assoc($sk))
												{
												?>
												<option value="<?php echo $h['id'];?>"><?php echo $h['catname'];?></option>
												<?php } ?>
												
											</select>
										</div>
										
										<div class="form-group">
											<label for="projectinput6">Select SubCategory</label>
											<select id="sub_list" name="subcatname" class="form-control">
												
												<?php 
												$j = mysqli_fetch_assoc(mysqli_query($con,"select * from subcategory where id=".$selk['subcat_id']." and cat_id=".$selk['cat_id'].""));
												?>
												<option value="<?php echo $j['id'];?>"><?php echo $j['name'];?></option>
												<?php 
												$sk = mysqli_query($con,"select * from subcategory where id !=".$selk['subcat_id']." and cat_id=".$selk['cat_id']."");
												while($h = mysqli_fetch_assoc($sk))
												{
												?>
												<option value="<?php echo $h['id'];?>"><?php echo $h['name'];?></option>
												<?php } ?>
												
											</select>
										</div>
								
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="gurl">Quantity</label>
											<input type="text" id="editQty" class="form-control"  name="editQty"  value="<?php echo $selk['prod_quantity'];?>">									
										</div>									
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label for="projectinput6">Select Unit</label>
											<select id="edit_unit_change" name="prod_unit" class="form-control" required>
												<option value="" selected="" disabled="">Select Unit</option>
												<?php 
												if($username == 'admin' || $check_menu_stock['view_g'] ==1){
													$sk = mysqli_query($con,"select * from units");
												}else{
													$sk = mysqli_query($con,"select * from units where created_by =".$admin_id);
												}

												while($h = mysqli_fetch_assoc($sk))
												{
												?>
												<option value="<?php echo $h['unit_name'];?>" <?php if($h['unit_name'] == $selk['unit']){ echo "selected";}?> ><?php echo $h['unit_name'];?></option>
												<?php } ?>
												
											</select>
										</div>	
									</div>
								</div>
								<div class="form-group">
									<label for="gurl">Product Price/ <span id="edit_chng_unt"><?=$selk['unit'];?></span></label>
									<input type="text" id="edit_prod_price" class="form-control"  name="pprice"  value="<?php echo $selk['prod_price'];?>" required>
									
								</div>
								
								<div class="form-group">
									<label for="gurl">Total Buying Price</label>
									<input type="text" id="edit_total_price" class="form-control"  name="edit_total_price" value="<?php echo $selk['total_buying_price'];?>" required>									
								</div>	

									<div class="form-group"> 
									<label for="total">Set your profit
									   	  <input type="radio" id="fix" value="Fixed" onclick="profit_input_fn(this)" name="fix" <?php if($selk['profit_type']=='Fixed'){ echo"Checked";}else{echo'';} ?> >
										  <label for="fix">Fix</label>
										  <input type="radio" id="fix" value="Percent" onclick="profit_input_fn(this)" name="fix" <?php if($selk['profit_type']=='Percent'){ echo"Checked";}else{echo'';} ?> >
										  <label for="fix1">Percentage</label></label>
											<input type="text" id="edit_fix_price" class="form-control" value="<?php if($selk['profit_type']=='Fixed'){ echo $selk['profit_value'];}else{echo'';} ?>" name="prc_wd_profit_fix" style="display:none;" placeholder="enter fix value">
											<input type="text" id="edit_percentage_price" class="form-control"  value="<?php if($selk['profit_type']=='Percent'){ echo $selk['profit_value'];}else{echo'';} ?>" name="prc_wd_profit_perc" style="display:none;" placeholder="Enter percentage">
									
									</div>


								<div class="form-group">
									<label for="total">Selling Price with Profit</label>
									<input type="text" id="edit_perKg_profit" class="form-control"  value="<?php echo $selk['selling_price_wth_prft'];?>" name="edit_slng_prc_wd_profit">
									
								</div>

								<div class="form-group">
									<label for="total">Total Selling Price with Profit</label>
									<input type="text" id="edit_prc_wd_profit" class="form-control"  value="<?php echo $selk['total_price_with_profit'];?>" name="edit_prc_wd_profit">
									
								</div>
								
							</div>

							<div class="form-actions">
								<button type="submit" name="edit_product" class="btn btn-raised btn-raised btn-primary">
									<i class="fa fa-check-square-o"></i> Edit Product
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<?php
		if(isset($_POST['edit_product']))
		{
			$con->begin_transaction();

			$current_stock = $con->query("select * from inventory_stock where id=".$_GET['edit']."")->fetch_assoc();

			$pname = mysqli_real_escape_string($con,$_POST['pname']);	
			
			$catname = $_POST['catname'];
			$subcatname = $_POST['subcatname'];
			$pquantity = $_POST['editQty'];		
			$profit_type = $_POST['fix'];
			if($profit_type == 'Fixed'){
				$profit_value = $_POST['prc_wd_profit_fix'];
			}else{
				$profit_value = $_POST['prc_wd_profit_perc'];
			}
			
			
			$pprice = str_replace(',','$;',$_POST['pprice']);
			$total_buying_price = mysqli_real_escape_string($con,$_POST['edit_total_price']);
			$selling_price_wth_prft = mysqli_real_escape_string($con,$_POST['edit_slng_prc_wd_profit']);
			$total_price_with_profit = mysqli_real_escape_string($con,$_POST['edit_prc_wd_profit']);
			$product_unit = mysqli_real_escape_string($con,$_POST['prod_unit']);
			$status = ($pquantity>0)?1:0;

			
			$insert_old =$con->query('INSERT INTO `inventory_stock_history`(`product_name`, `cat_id`, `subcat_id`, `prod_quantity`, `prod_price`, `total_buying_price`, `selling_price_wth_prft`, `total_price_with_profit`, `unit`,`created_by`, `is_changeable`, `status`,`profit_type`,`profit_value`) VALUES ("'.$current_stock['product_name'].'",'.$current_stock['cat_id'].','.$current_stock['subcat_id'].','.$current_stock['prod_quantity'].','.$current_stock['prod_price'].','.$current_stock['total_buying_price'].','.$current_stock['selling_price_wth_prft'].','.($current_stock['total_price_with_profit']?$current_stock['total_price_with_profit']:0).',"'.$current_stock['unit'].'",'.$current_stock['created_by'].','.$current_stock['is_changeable'].',"Old","'.$current_stock['profit_type'].'",'.$current_stock['profit_value'].')');
		
			// updating stock
			$updating =$con->query("UPDATE inventory_stock set product_name='".$pname."',cat_id='".$catname."',subcat_id='".$subcatname."',prod_quantity='".$pquantity."',prod_price=".$pprice.",total_buying_price=".$total_buying_price.",selling_price_wth_prft=".$selling_price_wth_prft.",total_price_with_profit=".$total_price_with_profit.",unit='".$product_unit."',status=".$status.",created_by=".$admin_id.",profit_type='".$profit_type."',profit_value=".$profit_value." where id='".$_GET['edit']."'");
			
			if($updating == 0 || $insert_old == 0){
				$con->rollback();
				echo '<script>alert("Some Error Occured")</script>';
				die();
			}

			$added_qty = $pquantity - $current_stock['prod_quantity'];
			$qty_buy_price = $total_buying_price - $current_stock['total_buying_price'];
			$qty_sell_price = $total_price_with_profit - $current_stock['total_price_with_profit'];

		   	$new_update = $con->query('INSERT INTO `inventory_stock_history`(`product_name`, `cat_id`, `subcat_id`, `prod_quantity`, `prod_price`, `total_buying_price`, `selling_price_wth_prft`, `total_price_with_profit`, `unit`,`created_by`, `is_changeable`, `status`,`profit_type`,`profit_value`) VALUES ("'.$pname.'",'.$catname.','.$subcatname.','.$added_qty.','.$pprice.','.$qty_buy_price.','.$selling_price_wth_prft.','.$qty_sell_price.',"'.$product_unit.'",'.$admin_id.',"'.$current_stock['is_changeable'].'","Updated","'.$profit_type.'",'.$profit_value.')');

		 	if($new_update == 0 ){
				$con->rollback();
				echo '<script>alert("Some Error Occured")</script>';
				die();
			}
		   	$con->commit();
			
		?>
		<script type="text/javascript">
			$(document).ready(function() {
				toastr.options.timeOut = 4500; // 1.5s

				toastr.info('Stock Update Successfully!!');
				setTimeout(function()
				{
					window.location.href="stocklist.php";
				},1500);
				
			});
		</script>
		<?php 
		
		}
		?>
	</div>

	<?php 
} 
else 
{
	if($username != 'admin' && $check_menu_stock['create'] !=1 ){?>
		<script>
			window.location.href="404.php";
		</script>
	<?php	}	

    ?>
    
    <div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-form">Add Stock</h4>

				</div>
				<div class="card-body">
					<div class="px-3">
						<form class="form" action="#" autocomplete="off" method="post" enctype="multipart/form-data">
							<div class="form-body">
								
								<div class="form-group">
									<label for="cname">Product Name</label>
									<input type="text" id="pname" list="products" class="form-control init-autocomplete"  placeholder="Enter Product Name" name="pname" required>
								</div>

								<div class="form-group">
									<div class="all_class_details"></div>									
								</div>
								
								<div class="form-group">
									<label for="cname">Product Image</label>
									<input type="file" id="pimg_one" class="form-control"  placeholder="Enter Product Image" name="pimg" required>
								</div>
								
								<div class="form-group">
									<label for="cname">Product Related Image</label>
									<input type="file" id="pimg_three" class="form-control"  placeholder="Enter Product Related Image" name="prel[]" multiple >
								<p>Only Upload 3 Images</p>
								</div>

								<div class="form-group">
									<label for="projectinput6">Select Category</label>
									<select id="cat_change" name="catname" class="form-control" required>
										<option value="" selected="" disabled="">Select Category</option>
										<?php 
										$sk = mysqli_query($con,"select * from category");
										while($h = mysqli_fetch_assoc($sk))
										{
										?>
										<option value="<?php echo $h['id'];?>"><?php echo $h['catname'];?></option>
										<?php } ?>
										
									</select>
								</div>										
								<div class="form-group">
									<label for="projectinput6">Select SubCategory</label>
									<select id="sub_list" name="subcatname" class="form-control" required>
										<option value="" selected="" disabled="">Select SubCategory</option>
										
										
									</select>
								</div>									
										
									
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="cname">Quantity</label>
											<input type="text" id="pqty" name="pqty" value="0" class="form-control"  placeholder="Enter Product Quantity" required>
											<input type="hidden" id="hidden_pqty" name="hidden_pqty" class="form-control">
										</div>
									</div>

									<div class="col-md-4">
										<div class="form-group">
											<label for="projectinput6">Select Unit</label>
											<select id="unit_change" name="prod_unit" class="form-control" required>
												<option value="" selected="" disabled="">Select Unit</option>
												<?php 
												
												if($username == 'admin' || $check_menu_stock['view_g'] ==1){
													$sk = mysqli_query($con,"select * from units");
												}else{
													$sk = mysqli_query($con,"select * from units where created_by =".$admin_id);
												}
												
												while($h = mysqli_fetch_assoc($sk))
												{
												?>
												<option value="<?php echo $h['unit_name'];?>"><?php echo $h['unit_name'];?></option>
												<?php } ?>
												
											</select>
											<input type="hidden" id="hidden_prod_unit" name="hidden_prod_unit" class="form-control">
										</div>	
									</div>

									<div class="col-md-4">
										<div class="form-group">
											<label for="is_changeable">Is Changeable ?</label>
											<!-- <input type="text" id="pmeasure" name="pmeasure" value="0" class="form-control"  placeholder="Enter Measurement" required> -->
											<select id="is_changeable" name="is_changeable" class="form-control" required>
												<!-- <option value="" selected="" disabled="">Select</option> -->			
												<option value="0" selected>No</option>
												<option value="1">Yes</option>												
												
											</select>
										</div>
									</div>
								</div>									

								<div class="form-group">
									<label for="gurl">Product Price/<span id="chng_unt"></span></label>
									<input type="text" id="prod_price" class="form-control"  value="0" name="pprice">
									
								</div>

								<div class="form-group">
									<label for="total">Total Buying Price</label>
									<input type="text" id="total" class="form-control"  value="" name="totalprice">
									
								</div>

								<div class="form-group">
									<label for="total">Set your profit
									   	  <input type="radio" id="fix" value="Fixed" name="fix">
										  <label for="fix">Fix</label>
										  <input type="radio" id="fix1" value="Percent" name="fix">
										  <label for="fix1">Percentage</label></label>
											<input type="text" id="fix_price" class="form-control"  value="" name="prc_wd_profit_fix" style="display:none;" placeholder="enter fix value">
											<input type="text" id="percentage_price" class="form-control"  value="" name="prc_wd_profit_perc" style="display:none;" placeholder="Enter percentage">
									
								</div>

								<div class="form-group">
									<label for="total">Selling Price With Profit</label>
									<input type="text" id="perKg_profit" class="form-control"  value="" name="perKg_profit">
									
								</div>

								<div class="form-group">
									<label for="total">Total Selling Price with Profit</label>
									<input type="text" id="prc_wd_profit" class="form-control"  value="" name="prc_wd_profit">
									
								</div>

								<div class="form-group">
									<label for="gurl">Product Small Description</label>
									<textarea class="form-control" name="psdesc" placeholder="Enter Product Small Description" required></textarea>
									
								</div>
								
							</div>

							<div class="form-actions">
								
								<button type="submit" name="sub_stock" class="btn btn-raised btn-raised btn-primary">
									<i class="fa fa-check-square-o"></i> Save Product
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<?php
		if(isset($_POST['sub_stock']))
		{		
				$prod_name = mysqli_real_escape_string($con,$_POST['pname']);		


				$con->begin_transaction();
				
				$catname = $_POST['catname'];
				$subcatname = $_POST['subcatname'];

				//Product ID
				$checkprod = $con->query("select * from product where pname = '".$prod_name."' and cid=".$catname." and sid=".$subcatname."")->fetch_assoc();


				$old_stock = $con->query("select * from inventory_stock where product_name='".$prod_name."'and cat_id='".$catname."' and subcat_id='".$subcatname."'")->fetch_assoc();

				$chk_prdQnty_unit = $_POST['hidden_pqty'];
				$pquantity = "";
				if($chk_prdQnty_unit == ""){
					$pquantity = $_POST['pqty'];
				}else{
					$pquantity = $_POST['hidden_pqty'];
				}
				//$pquantity = $_POST['pqty'];		
				$pprice = str_replace(',','$;',$_POST['pprice']);
				$total_buying_price = mysqli_real_escape_string($con,$_POST['totalprice']);
				$selling_price_wth_prft = mysqli_real_escape_string($con,$_POST['perKg_profit']);
				$total_price_with_profit = mysqli_real_escape_string($con,$_POST['prc_wd_profit']);
				//$product_unit = mysqli_real_escape_string($con,$_POST['prod_unit']);
				$chk_prd_unt = $_POST['hidden_prod_unit'];
				$profit_type = $_POST['fix'];
				if($profit_type == 'Fixed'){
					$profit_value = $_POST['prc_wd_profit_fix'];
				}else{
					$profit_value = $_POST['prc_wd_profit_perc'];

				}
				
				$product_unit = "";
				if($chk_prd_unt == ""){
					$product_unit = mysqli_real_escape_string($con,$_POST['prod_unit']);
				}else{
					$product_unit = mysqli_real_escape_string($con,$_POST['hidden_prod_unit']);
				}

				$is_changeable = mysqli_real_escape_string($con,$_POST['is_changeable']);

				$timestamp = date("Y-m-d H:i:s");
				$status = ($pquantity>0)?1:0;     
				
				$user_detail = $con->query('Select * from admin where id='.$admin_id)->fetch_assoc();
				$shop_name = $user_detail['shop_name'];
				$shop_detail = mysqli_real_escape_string($con,$_POST['psdesc']);
				
				$fileName = $_FILES['pimg']['tmp_name'];
				
				if(!empty($fileName)){
					$sourceProperties = getimagesize($fileName);
					$resizeFileName = time();
					$uploadPath = "product/";
					$fileExt = pathinfo($_FILES['pimg']['name'], PATHINFO_EXTENSION);
					$uploadImageType = $sourceProperties[2];
					$sourceImageWidth = $sourceProperties[0];
					$sourceImageHeight = $sourceProperties[1];
					$new_width = $sourceImageWidth;
					$new_height = $sourceImageHeight;
					
					switch ($uploadImageType) {
						case IMAGETYPE_JPEG:
							$resourceType = imagecreatefromjpeg($fileName); 
							$imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight,$new_width,$new_height);
							imagejpeg($imageLayer,$uploadPath."thump_".$resizeFileName.'.'. $fileExt);
							break;

						case IMAGETYPE_GIF:
							$resourceType = imagecreatefromgif($fileName); 
							$imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight,$new_width,$new_height);
							imagegif($imageLayer,$uploadPath."thump_".$resizeFileName.'.'. $fileExt);
							break;

						case IMAGETYPE_PNG:
							
							$resourceType = imagecreatefrompng($fileName); 
							$imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight,$new_width,$new_height);
							imagepng($imageLayer,$uploadPath."thump_".$resizeFileName.'.'. $fileExt);
							
							break;

						default:
							$imageProcess = 0;
							break;
					}
			
					$url = $uploadPath."thump_".$resizeFileName.".". $fileExt;
					
				}else{
					$url ='';
				}

				if(!empty($_FILES['prel']['name'][0]))
				{
					$arr = array();
					foreach($_FILES['prel']['tmp_name'] as $key => $tmp_name ){
						$file_name = $key.$_FILES['prel']['name'][$key];
						$file_size =$_FILES['prel']['size'][$key];
						$file_tmp =$_FILES['prel']['tmp_name'][$key];
						
						$file_type = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));
						if($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg" && $file_type != "gif" ) {
 								$related = '';
						}
						else 
						{
							
							move_uploaded_file($file_tmp,"product/".$file_name);
							$arr[] = "product/".$file_name;
						}
					}
					$related = implode(',',$arr);
		 		}
				else{
					$related = '';
		 		}
				
				$publish = 1;
				if(!empty($checkprod)){
					$old_pgms = explode('$;',$checkprod['pgms']);
					$old_pprice = explode('$;',$checkprod['pprice']);

					$old_pgms = array_unique($old_pgms);
					$new_pgms = array_merge($old_pgms,[$product_unit]);

					$old_pprice = array_unique($old_pprice);
					$new_pprice = array_merge($old_pprice,[$selling_price_wth_prft]);

					$str_pgms = implode('$;',$new_pgms);
					$str_pprice = implode('$;',$new_pprice);

					
					$product_upd =$con->query("UPDATE `product` SET `pname`='".$prod_name."',`sname`='".$shop_name."',`cid`=".$catname.",`sid`=".$subcatname.",`psdesc`='".$shop_detail."',`pgms`='".$str_pgms."',`pprice`='".$str_pprice."',`status`=".$publish.",`stock`=".$status.",`pimg`='".$url."',`prel`='".$related."',`date`='".$timestamp."',`discount`=0,`popular`=1,`created_by`='".$admin_id."' WHERE id=".$checkprod['id']);
					
				}else{
					$new_pgms = $product_unit;
					$new_pprice = $selling_price_wth_prft;

					$product_inst = $con->query("insert into product(`pname`,`pimg`,`prel`,`sname`,`cid`,`sid`,`psdesc`,`pgms`,`pprice`,`date`,`status`,`stock`,`discount`,`popular`,`created_by`)values('".$prod_name."','".$url."','".$related."','".$shop_name."',".$catname.",".$subcatname.",'".$shop_detail."','".$new_pgms."','".$new_pprice."','".$timestamp."',".$publish.",".$status.",1,1,".$admin_id.")");
				}

				if($product_upd == 0 || $product_inst == 0){
					$con->rollback();
					echo '<script>alert("Some Error Occured")</script>';
					die();
				}

				if(!empty($old_stock)){

					$insert_old =$con->query('INSERT INTO `inventory_stock_history`(`product_name`, `cat_id`, `subcat_id`, `prod_quantity`, `prod_price`, `total_buying_price`, `selling_price_wth_prft`, `total_price_with_profit`, `unit`,created_by, `is_changeable`, `status`,`profit_type`,`profit_value`) VALUES ("'.$old_stock['product_name'].'",'.$old_stock['cat_id'].','.$old_stock['subcat_id'].','.$old_stock['prod_quantity'].','.$old_stock['prod_price'].','.$old_stock['total_buying_price'].','.$old_stock['selling_price_wth_prft'].','.($old_stock['total_price_with_profit']?$old_stock['total_price_with_profit']:0).',"'.$old_stock['unit'].'",'.$old_stock['created_by'].','.$old_stock['is_changeable'].',"Old","'.$profit_type.'",'.$profit_value.')');
					
					// average of two stock
					// old 
					$old_cost = $old_stock['prod_price'];
					$new_cost = $pprice;
					
					if($product_unit == 'Kg'){
						if($old_stock['unit'] == 'Kg'){
							$pquantity = $pquantity;
						}else if($old_stock['unit'] == 'Gm'){
							$pquantity = ($pquantity*1000);
						}else if($old_stock['unit'] == 'Mg'){
							$pquantity = ($pquantity*100000);
						}
					}else if($product_unit == 'Gm'){
						if($old_stock['unit'] == 'Kg'){
							$pquantity = ($pquantity/1000);
						}else if($old_stock['unit'] == 'Gm'){
							$pquantity = $pquantity;
						}else if($old_stock['unit'] == 'Mg'){
							$pquantity = ($pquantity*1000);
						}
					}else if($product_unit == 'Mg'){
						if($old_stock['unit'] == 'Kg'){
							$pquantity = ($pquantity/100000);
						}else if($old_stock['unit'] == 'Gm'){
							$pquantity = ($pquantity/1000);
						}else if($old_stock['unit'] == 'Mg'){
							$pquantity = $pquantity;
						}
					}
					$sum_qty = $old_stock['prod_quantity'] + $pquantity;
					
					$avg_price = round(($old_cost + $new_cost)/$sum_qty,4);
					
					$avg_total_price =round($sum_qty*$avg_price);
					$profit = $selling_price_wth_prft-$pprice;

					$avg_price_with_profit = round($avg_price+$profit) ;
					
					$avg_total_with_profit = round($sum_qty*$avg_price_with_profit);
					
					// updating stock
					$updating =$con->query("UPDATE inventory_stock set product_name='".$prod_name."',cat_id='".$catname."',subcat_id='".$subcatname."',prod_quantity='".$sum_qty."',prod_price=".$avg_price.",total_buying_price=".$avg_total_price.",selling_price_wth_prft=".$avg_price_with_profit.",total_price_with_profit=".$avg_total_with_profit.",unit='".$product_unit."',status=".$status.",created_by=".$admin_id.",profit_type='".$profit_type."',profit_value=".$profit_value." where id='".$old_stock['id']."'");
					
					if($updating == 0 || $insert_old == 0){
						$con->rollback();
						echo '<script>alert("Some Error Occured")</script>';
						die();
					}
					$sum_qty = round($sum_qty - $old_stock['prod_quantity'],3);
					$qty_buy_price = round($sum_qty * $avg_price);
					$qty_sell_price = round($sum_qty * $avg_price_with_profit);
					
					$new_update = $con->query('INSERT INTO `inventory_stock_history`(`product_name`, `cat_id`, `subcat_id`, `prod_quantity`, `prod_price`, `total_buying_price`, `selling_price_wth_prft`, `total_price_with_profit`, `unit`, `is_changeable`, `status`,`created_by`,`profit_type`,`profit_value`) VALUES ("'.$prod_name.'",'.$catname.','.$subcatname.','.$sum_qty.','.$avg_price.','.$qty_buy_price.','.$avg_price_with_profit.','.$qty_sell_price.',"'.$product_unit.'","'.$old_stock['is_changeable'].'","Updated",'.$admin_id.',"'.$profit_type.'",'.$profit_value.')');
 
				}else{
					$con->query("insert into inventory_stock(`product_name`,`cat_id`,`subcat_id`,`prod_quantity`,`prod_price`,`total_buying_price`,`selling_price_wth_prft`,`total_price_with_profit`,`unit`,`is_changeable`,`status`,`created_by`,`added_on`,`updated_on`,`profit_type`,`profit_value`)values('".$prod_name."','".$catname."','".$subcatname."','".$pquantity."','".$pprice."','".$total_buying_price."','".$selling_price_wth_prft."','".$total_price_with_profit."','".$product_unit."','".$is_changeable."','".$status."',".$admin_id.",'".$timestamp."','".$timestamp."','".$profit_type."',".$profit_value.")");
				}
				$con->commit();
			
	
		?>
			<script type="text/javascript">
				$(document).ready(function() {
					toastr.options.timeOut = 4500; // 1.5s
					toastr.info('Inventory Added Successfully!!');
				
				});
			</script>
		<?php 
	
		}		
		?>
	</div>

<?php 

} 

?>
          </div>
        </div>

        

      </div>
    </div>
    
   <?php 
  require 'include/js.php';
  ?>
   
  
   <script>
   	$('#cat_change').change(function(){
		sub_cat_change('');
	});					

	function sub_cat_change(sub_val){
		var value = $('#cat_change').val();
		
		$.ajax({
			type:'post',
			url:'getsub.php',
			data:
			{
				catid:value
			},
			success:function(data)
			{
				$('#sub_list').html(data);
				if(sub_val != ''){
					$('#sub_list').val(sub_val)
				}
			}
		});
	}
	</script>
	
	<script>
$('#ptype').tagsinput('items');
$('#pprice').tagsinput('items');
</script>

<script>
      $(document).ready(function(){
        $("#pname").on("keyup", function(){
          var value1 = $(this).val().toLowerCase();
          //console.log(value1);
          $(".all_class_details").show();
          $.ajax({
            url: 'ajax.php',
            method: 'POST',
            dataType:"text",
           data:{value1:value1 },
            success: function(data){
           		//alert(data);
              var html = "";
              var j = 1;
              var sp = data.split(",")
              for(var i=0; i<sp.length-1; i++){
                html +='<div class="SpecificclassName">'+sp[i]+'</div>';
              }
              $('.all_class_details').html(html);
              $(".SpecificclassName").click(function(){
                //  var school_detail = $(".SpecificSchoolName").text();
                var class_detail = $(this).text()
                //  alert(school_detail);
                $("#studentClass").val(class_detail);
                $('.all_class_details').hide();
              });
             // console.log(sp);
              if(sp == ""){
              $('.all_class_details').hide();
            }
            },
              error:function(err){
                console.log("Error : ",err)
              }
          });

        });
   
      });


      
      </script>

      <script>

      $(document).ready(function(){
      	
      	$('#unit_change').on("change",function(){
      		var unit = $(this).val();      		
      		$('#chng_unt').text(unit);
      	});

      	$('#is_changeable').on("change",function(){      	
      		var pqty = $('#pqty').val();
      		var unit = $('#unit_change').val().trim();
      		unit = unit.toLowerCase();
      		console.log("unit is "+unit);
      		console.log("Quantity is "+pqty);

      		//if kg is select multiply quantity by per 1000 gms..
      		
      		if(unit == "kg"){			
      			
      			var netQnty = pqty;
      			console.log("NetQuantity is "+netQnty);
      			$('#hidden_pqty').val(netQnty);
      			 var ident = "Gm"
      			$('#hidden_prod_unit').val(ident);
      			// $.ajax({
      			// 	url:'stock.php',
      			// 	type:'post',
      			// 	data: {netQnty:netQnty}
      			// 	// data: {text:$('#pqty').val(netQnty)}

      			// });
      			//document.cookie = netQnty;
      			// //$('#pqty').val(netQnty);      			
      			// var ident = "Gm";
      			// $('#unit_change option[value="' + ident +'"]').prop("selected", true);


      		}
      	});



      	$('#edit_unit_change').on("change",function(){
      		var unit = $(this).val();      		
      		$('#edit_chng_unt').text(unit);
      	});


      	$('#fix').click(function(){
			$('#fix_price').show(200);
			$('#percentage_price').hide(200);
		});

		$('#fix1').click(function(){
			$('#percentage_price').show(200);
			$('#fix_price').hide(200);
		});

		



      	var quantity = 0;
      	var prod_price = 0;
      	var fix_price = 0;
      	var final_sum = 0;
      	var percentage_price = 0; 
      	var sum = quantity * prod_price + fix_price;
      	

        $("#pqty").on("keyup", function(){
          quantity = $(this).val();
		  
          sum = quantity * prod_price;

          final_sum = sum + fix_price;
         
          // console.log(quantity);
    	  $('#total').val(sum);
    	  $('#prc_wd_profit').val(final_sum);    	  

        });

        $("#prod_price").on("keyup", function(){
        	prod_price = $(this).val();
        	if(prod_price == ""){
        		 sum = quantity * prod_price;
        		 $('#total').val(sum);
        	}
        	else{
        		 prod_price = parseInt($(this).val());
        		 sum = quantity * prod_price;
        		 final_sum = sum + fix_price;

        		 $('#total').val(sum);
        		 $('#prc_wd_profit').val(final_sum);
        	}

          // prod_price = parseInt($(this).val());
          // //console.log(prod_price);
           
          //  sum = quantity * prod_price;

          //  final_sum = sum + fix_price;
          //  $('#total').val(sum);
          //  $('#prc_wd_profit').val(final_sum); 
          //  //console.log(sum);

        });

        $("#fix_price").on("keyup", function(){

          //fix_price = parseInt($(this).val());
          fix_price = $(this).val();	

          if(fix_price == ""){
             $("#prc_wd_profit").val(sum);
            }else{
            	fix_price = parseInt(fix_price);
            	var newprice = fix_price + prod_price;
            	// alert(newprice)
            	var final_sum = newprice * quantity;

            	var perKg_profit = fix_price + prod_price;
            	$('#perKg_profit').val(perKg_profit);
            	//alert(final_sum);
            	//final_sum = sum + fix_price;
           		$('#prc_wd_profit').val(final_sum);
            }
          //console.log(fix_price);
         
        });
      
           

        $("#percentage_price").on("keyup", function(){
        	percentage_price = $(this).val();
        	if(percentage_price == ""){
        		$('#prc_wd_profit').val(sum);
        	}
        	else{
        		percentage_price = parseInt($(this).val());

        		newprice = (percentage_price / 100) * prod_price;
        		var newprice1 = newprice + prod_price;
        		//alert(newprice1);
        		final_sum = newprice1 * quantity;
        		$('#perKg_profit').val(newprice1);
        		$('#prc_wd_profit').val(final_sum);
        		// quotant = (percentage_price / 100) * sum;
        		// final_sum = sum + quotant;
        		// $('#prc_wd_profit').val(final_sum);
        	}
        });

        $('#total').val(sum);

        $("#editQty").on("keyup", function(){

          quantity = $(this).val();
		  prod_price = $("#edit_prod_price").val();
          sum = parseFloat(quantity * prod_price);      

          final_sum = sum + fix_price;        
           
    	  $('#edit_total_price').val(sum);
    	  $('#edit_prc_wd_profit').val(final_sum); 

        });

        $("#edit_prod_price").on("keyup", function(){
          prod_price = $(this).val();
        	if(prod_price == ""){
        		 sum = quantity * prod_price;
        		 $('#edit_total_price').val(sum);
        	}
        	else{
        		 prod_price = parseInt($(this).val());
        		 sum = quantity * prod_price;
        		 final_sum = sum + fix_price;

        		 $('#edit_total_price').val(sum);
        		 $('#edit_prc_wd_profit').val(final_sum);
        	}

        });

        $("#edit_fix_price").on("keyup", function(){
          fix_price = $(this).val();	

          if(fix_price == ""){
             $("#edit_prc_wd_profit").val(sum);
            }else{
            	fix_price = parseInt(fix_price);
            	
            	var newprice = fix_price + parseInt($('#edit_prod_price').val()); //get the values of already coming databse values if not changed and parseInt
            	
            	
            	var final_sum = newprice * parseInt($('#editQty').val());            	
            	var perKg_profit = fix_price + parseInt($('#edit_prod_price').val());
            	$('#edit_perKg_profit').val(perKg_profit);

            	// final_sum = sum + fix_price;
           		$('#edit_prc_wd_profit').val(final_sum);
            }
         
        });

         $("#edit_percentage_price").on("keyup", function(){
        	percentage_price = $(this).val();
        	if(percentage_price == ""){
        		$('#edit_prc_wd_profit').val(sum);
        	}
        	else{
        		percentage_price = parseInt(percentage_price);
        		newprice = (percentage_price / 100) * parseInt($('#edit_prod_price').val());
        		var newprice1 = newprice + parseInt($('#edit_prod_price').val());
        		
        		quotant = (percentage_price / 100) * sum;
        		final_sum = newprice1 * parseInt($('#editQty').val());

        		$('#edit_perKg_profit').val(newprice1);//For Selling Price With Profit
        		$('#edit_prc_wd_profit').val(final_sum); //for total selling price with profit
        	}
        });

        // $("#perKg_profit").on("keyup", function(){
        // 	perKg_price = $(this).val();
        // 	alert(perKg_price);
        // 	if(perKg_price == ""){
        // 		$('#edit_prc_wd_profit').val(sum);
        // 	}
        // 	else{
        // 		percentage_price = parseInt($(this).val());
        // 		quotant = (percentage_price / 100) * sum;
        // 		final_sum = sum + quotant;
        // 		$('#edit_prc_wd_profit').val(final_sum);
        // 	}
        // });  
		
		
        
      });

	  $(document).ready(function(){
		var autocomplete_product= <?php echo json_encode(isset($stock_item)?$stock_item:[]); ?>;
        datalist('#pname', autocomplete_product);
        datalist('#vname', autocomplete_product);
	  })
	
		function datalist(inp,list){
			$src = '<datalist id="products">';
			$.each(list,function(i,name){
				$src +="<option value='"+name+"'>";
			});
			$src +="</datalist>";
			$(inp).after($src);
		}

		$("#pname").blur(function(){
			var product_name = $("#pname").val();
			var sub_cat = '';
			$.ajax({
				url:'Ajax/ajaxfile.php',
				Type:'GET',
				dataType:'Json',
				data:{"product_namess":"product_name","name":product_name},
				success:function(response){
					console.log(response);
					if(response.status == 'success'){
						var sel_pr = response.product;
						$("#cat_change").val(sel_pr.cat_id).trigger('change');
						$("#unit_change").val(sel_pr.unit).trigger('change');
						$("#is_changeable").val(sel_pr.is_changeable);
						
						sub_cat =sel_pr.subcat_id;
						sub_cat_change(sub_cat);
					}
				},  
				error:function(err){
					console.log("Error Found",err);
				
				}
			})
			
		})
		
      </script>
	  
	  
  </body>


</html>