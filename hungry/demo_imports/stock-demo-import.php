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
      <?php include('main.php'); ?>
      <!-- Navbar (Header) Ends-->

      <div class="main-panel">
        <div class="main-content">
          <div class="content-wrapper"><!--Statistics cards Starts-->
  <div class="container">
      <div class="alert alert-error">
        <strong  id="err_msg"></strong> 
      </div>
  </div>
<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-form">Upload Csv Product</h4>
					
				</div>
				<div class="card-body">
					<div class="px-3">
						<form class="form" method="post" enctype="multipart/form-data">
							<div class="form-body">
								

								

								

								

								<div class="form-group">
									<label>select A Csv</label>
									<input type="file" name="csv" class="form-control-file" id="projectinput8">
								</div>

								
							</div>

							<div class="form-actions">
								
								<button type="submit" name="sub_cat" class="btn btn-raised btn-raised btn-primary">
									<i class="fa fa-check-square-o"></i> Upload Csv
								</button>
								
								<a href="import.csv" target="_blank" class="btn btn-raised btn-raised btn-info" id="download" >Demo Csv</a>
							</div>
							
							
						</form>
					</div>
				</div>
			</div>
		</div>

 <?php 
	if(isset($_POST['sub_cat']))
	{
		$csv = array();
    
      // check there are no errors
      if($_FILES['csv']['error'] == 0){
          $name = $_FILES['csv']['name'];
          $exp = explode('.',$name);
          $get_ext = end($exp);
          $ext = strtolower($get_ext);
          
          $type = $_FILES['csv']['type'];
          $tmpName = $_FILES['csv']['tmp_name'];
          $error ='';
          $err = 1;
          // check the file is a csv
          
          if($ext === 'csv'){
            
            if(($handle = fopen($tmpName, 'r')) !== FALSE) {
                // necessary if a large csv file
                set_time_limit(0);
                $row = 0;
                fgets($handle);
                
                $con->begin_transaction();
                while(($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                        // number of fields in the csv
                        $col_count = count($data);
                        
                        date_default_timezone_set('Asia/Kolkata');
                        $timestamp = date("Y-m-d");
                        // get the values from the csv
                        $prod_name = mysqli_real_escape_string($con,$data[0]);		

                        if(empty($prod_name)){
                            $error .=" Enter Product at row ".$err.",";
                        }
                        $counts = $con->query("select * from inventory_stock where product_name='".$prod_name."' and created_by =".$admin_id."")->fetch_assoc();
                        
                        $con->begin_transaction();
                        
                        $catname = $data[1];
                        $subcatname = $data[2];
                        
                        $catid = $con->query('SELECT id FROM `category` WHERE `catname` LIKE "%'.$catname.'%"')->fetch_assoc();
                        $subcatid = $con->query('SELECT id FROM `subcategory` WHERE `name` LIKE "%'.$subcatname.'%"')->fetch_assoc();
                    
                        $err++;
                      
                      if($error == ''){

                            $catname = $catid['id'];
                            $subcatname = $subcatid['id'];
                            $pquantity = 0;
                            $pprice = $data[3];
                            $total_buying_price = 0;
                            $selling_price_wth_prft =$data[4];
                            $total_price_with_profit =0;
                            $product_unit = $data[5];
                            $is_changeable =0;
                            $status = 0;
                            

                        if($counts != 0 )
                        {
                            
                        }
                        else 
                        {
                            $con->query("insert into inventory_stock(`product_name`,`cat_id`,`subcat_id`,`prod_quantity`,`prod_price`,`total_buying_price`,`selling_price_wth_prft`,`total_price_with_profit`,`unit`,`is_changeable`,`status`,`added_on`,`updated_on`,`created_by`)values('".$prod_name."','".$catname."','".$subcatname."','".$pquantity."','".$pprice."','".$total_buying_price."','".$selling_price_wth_prft."','".$total_price_with_profit."','".$product_unit."','".$is_changeable."','".$status."','".$timestamp."','".$timestamp."',".$admin_id.")");
                        
                        }
                      }else{
                        print_r("issue");
                        $con->rollback();
                        die();
                      }
                          // inc the row
                      $row++;
                }
                
                if($error == ''){
                    
                  $con->commit();
                }
                fclose($handle);
            }
              
        
		?>
        <script type="text/javascript">
          var error = <?php echo json_encode($error); ?>
          
          $(document).ready(function() {
            if(error == ''){
              toastr.options.timeOut = 4500; // 1.5s
              toastr.info('Import Product Successfully!!');
              setTimeout(function()
              {
                window.location.href="subcategorylist.php";
              },1500);
            }else{
              
              alert(error);
            }
              
          });
          </script> 
		<?php 
        }
      }
	  }
	?>
		
	</div>
	





          </div>
        </div>

        

      </div>
    </div>
    
    <?php 
  require 'include/js.php';
  ?>
   
 
  </body>


</html>