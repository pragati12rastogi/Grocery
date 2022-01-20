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
    $selk = $con->query("select * from inventory_stock where id=".$_GET['edit']."")->fetch_assoc();
?>
<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-form">Edit Stock</h4>
					
				</div>
				<div class="card-body">
					<div class="px-3">
						<form class="form" method="post" enctype="multipart/form-data">
							<div class="form-body">
								

								

								<div class="form-group">
									<label for="cname">Product Name</label>
									<input type="text" id="vname" class="form-control"  value="<?php echo $selk['product_name'];?>" name="pname" required>
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
											<select id="unit_change" name="prod_unit" class="form-control" required>
												<option value="" selected="" disabled="">Select Unit</option>
												<?php 
												$sk = mysqli_query($con,"select * from units");
												while($h = mysqli_fetch_assoc($sk))
												{
												?>
												<option value="<?php echo $h['unit_name'];?>"><?php echo $h['unit_name'];?></option>
												<?php } ?>
												
											</select>
										</div>	
									</div>
								</div>
								<div class="form-group">
									<label for="gurl">Product Price</label>
									<input type="text" id="edit_prod_price" class="form-control"  name="pprice"  value="<?php echo $selk['prod_price'];?>" required>
									
								</div>
								
								<div class="form-group">
									<label for="gurl">Total Price</label>
									<input type="text" id="edit_total_price" class="form-control"  name="edit_total_price" value="<?php echo $selk['total_price'];?>" required>									
								</div>	

									<div class="form-group">
									<label for="total">Set your profit
									   	  <input type="radio" id="fix" name="fix">
										  <label for="fix">Fix</label>
										  <input type="radio" id="fix1" name="fix">
										  <label for="fix1">Percentage</label></label>
											<input type="text" id="edit_fix_price" class="form-control"  value="" name="prc_wd_profit" style="display:none;" placeholder="enter fix value">
											<input type="text" id="edit_percentage_price" class="form-control"  value="" name="prc_wd_profit" style="display:none;" placeholder="Enter percentage">
									
								</div>

								<div class="form-group">
									<label for="total">Price with Profit</label>
									<input type="text" id="edit_prc_wd_profit" class="form-control"  value="<?php echo $selk['price_with_profit'];?>" name="edit_prc_wd_profit">
									
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
			$data = $con->query("select * from product where id=".$_GET['edit']."")->fetch_assoc();

			$pname = mysqli_real_escape_string($con,$_POST['pname']);		

		$catname = $_POST['catname'];
		$subcatname = $_POST['subcatname'];
		$pquantity = $_POST['editQty'];		
		$pprice = str_replace(',','$;',$_POST['pprice']);
		$total_price = mysqli_real_escape_string($con,$_POST['edit_total_price']);
		$prc_wd_profit = mysqli_real_escape_string($con,$_POST['edit_prc_wd_profit']);
		$product_unit = mysqli_real_escape_string($con,$_POST['prod_unit']);
		
   //      if($_FILES["pimg"]["name"] == '')
			// 				{
			// 					$pimg = $data['pimg'];
			// 				}
			// 				else 
			// 				{
			// 					$fileName = $_FILES['pimg']['tmp_name'];
			// 					echo $_FILES['pimg']['name'];
   //      $sourceProperties = getimagesize($fileName);
   //      $resizeFileName = uniqid().time();
   //      $uploadPath = "product/";
   //      $fileExt = pathinfo($_FILES['pimg']['name'], PATHINFO_EXTENSION);
   //      $uploadImageType = $sourceProperties[2];
   //      $sourceImageWidth = $sourceProperties[0];
   //      $sourceImageHeight = $sourceProperties[1];
		 // $new_width = $sourceImageWidth;
   //      $new_height = $sourceImageHeight;
   //      switch ($uploadImageType) {
   //          case IMAGETYPE_JPEG:
   //              $resourceType = imagecreatefromjpeg($fileName); 
   //              $imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight,$new_width,$new_height);
   //              imagejpeg($imageLayer,$uploadPath."thump_".$resizeFileName.'.'. $fileExt);
   //              break;

   //          case IMAGETYPE_GIF:
   //              $resourceType = imagecreatefromgif($fileName); 
   //              $imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight,$new_width,$new_height);
   //              imagegif($imageLayer,$uploadPath."thump_".$resizeFileName.'.'. $fileExt);
   //              break;

   //          case IMAGETYPE_PNG:
                
   //              $resourceType = imagecreatefrompng($fileName); 
   //              $imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight,$new_width,$new_height);
   //              imagepng($imageLayer,$uploadPath."thump_".$resizeFileName.'.'. $fileExt);
                
   //              break;

   //          default:
   //              $imageProcess = 0;
   //              break;
   //      }
        
   //      $pimg = $uploadPath."thump_".$resizeFileName.".". $fileExt;
			// 				}
							
							
// 							 if(empty($_FILES['prel']['name'][0]))
// 							{
// 								$related = $data['prel'];
								
// 							}
// 							else 
// 							{
// 								$arr = array();
// 							foreach($_FILES['prel']['tmp_name'] as $key => $tmp_name ){
// 	$file_name = $key.$_FILES['prel']['name'][$key];
// 	$file_size =$_FILES['prel']['size'][$key];
// 	$file_tmp =$_FILES['prel']['tmp_name'][$key];
	
// 	$file_type = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));
// 	if($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg"
// && $file_type != "gif" ) {
//  $related = '';
// }
// else 
// {
	
// 	move_uploaded_file($file_tmp,"product/".$file_name);
// 	$arr[] = "product/".$file_name;
// }
// 							}
// 							$related = implode(',',$arr);
// 					}
							
// 							if($related == '')
// 							{
// 								$related = $data['prel'];
// 							}
							
           $con->query("UPDATE inventory_stock set product_name='".$pname."',cat_id='".$catname."',subcat_id='".$subcatname."',prod_quantity='".$pquantity."',prod_price=".$pprice.",total_price=".$total_price.",price_with_profit=".$prc_wd_profit.",unit='".$product_unit."' where id='".$_GET['edit']."'");

        // $con->query("update inventory_stock set product_name='".$pname."',cat_id='".$catname."',subcat_id='".$subcatname."',prod_quantity='".$pquantity."',prod_price=".$pprice.",total_price=".$total_price.",price_with_profit=".$prc_wd_profit.",unit='$prod_unit' where id=".$_GET['edit']."");
        
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
    ?>
    
    <div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-form">Add Stock</h4>
					
				</div>
				<div class="card-body">
					<div class="px-3">
						<form class="form" action="#" method="post" enctype="multipart/form-data">
							<div class="form-body">
								

								

								<div class="form-group">
									<label for="cname">Product Name</label>
									<input type="text" id="pname" class="form-control"  placeholder="Enter Product Name" name="pname" required>
								</div>

								<div class="form-group">
									<div class="all_class_details"></div>									
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
									<div class="col-md-6">
										<div class="form-group">
											<label for="cname">Quantity</label>
											<input type="text" id="pqty" name="pqty" value="0" class="form-control"  placeholder="Enter Product Quantity" required>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label for="projectinput6">Select Unit</label>
											<select id="unit_change" name="prod_unit" class="form-control" required>
												<option value="" selected="" disabled="">Select Unit</option>
												<?php 
												$sk = mysqli_query($con,"select * from units");
												while($h = mysqli_fetch_assoc($sk))
												{
												?>
												<option value="<?php echo $h['unit_name'];?>"><?php echo $h['unit_name'];?></option>
												<?php } ?>
												
											</select>
										</div>	
									</div>
								</div>									

								<div class="form-group">
									<label for="gurl">Product Price/Per kg</label>
									<input type="text" id="prod_price" class="form-control"  value="0" name="pprice">
									
								</div>

								<div class="form-group">
									<label for="total">Total Price</label>
									<input type="text" id="total" class="form-control"  value="" name="totalprice">
									
								</div>

								<div class="form-group">
									<label for="total">Set your profit
									   	  <input type="radio" id="fix" name="fix">
										  <label for="fix">Fix</label>
										  <input type="radio" id="fix1" name="fix">
										  <label for="fix1">Percentage</label></label>
											<input type="text" id="fix_price" class="form-control"  value="" name="prc_wd_profit" style="display:none;" placeholder="enter fix value">
											<input type="text" id="percentage_price" class="form-control"  value="" name="prc_wd_profit" style="display:none;" placeholder="Enter percentage">
									
								</div>

								<div class="form-group">
									<label for="total">Price with Profit</label>
									<input type="text" id="prc_wd_profit" class="form-control"  value="" name="prc_wd_profit">
									
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
		$pname = mysqli_real_escape_string($con,$_POST['pname']);		

		//Product ID
		$prod = $con->query("select * from product where pname = '$pname'");
		$res = $prod->fetch_assoc();
		$prod_id = $res['id'];

		$catname = $_POST['catname'];
		$subcatname = $_POST['subcatname'];
		$pquantity = $_POST['pqty'];		
		$pprice = str_replace(',','$;',$_POST['pprice']);
		$total_price = mysqli_real_escape_string($con,$_POST['totalprice']);
		$prc_wd_profit = mysqli_real_escape_string($con,$_POST['prc_wd_profit']);
		$product_unit = mysqli_real_escape_string($con,$_POST['prod_unit']);

		
        $timestamp = date("Y-m-d H:i:s");
        $status = 1;     
              
 
		 $con->query("insert into inventory_stock(`product_name`,`product_id`,`cat_id`,`subcat_id`,`prod_quantity`,`prod_price`,`total_price`,`price_with_profit`,`unit`,`status`,`added_on`,`updated_on`)values('".$pname."','".$prod_id."','".$catname."','".$subcatname."','".$pquantity."','".$pprice."','".$total_price."','".$prc_wd_profit."','".$product_unit."','".$status."','".$timestamp."','".$timestamp."')");
	
	
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
   $(document).on('change','#cat_change',function()
	{
		var value = $(this).val();
		
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
			}
		});
	});					

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
      	$('#fix').click(function(){
			$('#fix_price').show(200);
			$('#percentage_price').hide(200);
		});

		$('#fix1').click(function(){
			$('#percentage_price').show(200);
			$('#fix_price').hide(200);
		});

		$('#fix').click(function(){
			$('#edit_fix_price').show(200);
			$('#edit_percentage_price').hide(200);
		});

		$('#fix1').click(function(){
			$('#edit_percentage_price').show(200);
			$('#edit_fix_price').hide(200);
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
        		 inal_sum = sum + fix_price;

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
            	final_sum = sum + fix_price;
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
        		quotant = (percentage_price / 100) * sum;
        		final_sum = sum + quotant;
        		$('#prc_wd_profit').val(final_sum);
        	}
        });

        $('#total').val(sum);

        $("#editQty").on("keyup", function(){

          quantity = $(this).val();
          sum = quantity * prod_price;        

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
        		 inal_sum = sum + fix_price;

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
            	final_sum = sum + fix_price;
           		$('#edit_prc_wd_profit').val(final_sum);
            }
          //console.log(fix_price);
         
        });

         $("#edit_percentage_price").on("keyup", function(){
        	percentage_price = $(this).val();
        	if(percentage_price == ""){
        		$('#edit_prc_wd_profit').val(sum);
        	}
        	else{
        		percentage_price = parseInt($(this).val());
        		quotant = (percentage_price / 100) * sum;
        		final_sum = sum + quotant;
        		$('#edit_prc_wd_profit').val(final_sum);
        	}
        });   
      });
      
      </script>
  </body>


</html>