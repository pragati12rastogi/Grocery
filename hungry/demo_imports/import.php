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
                      
                      $err++;
                      $cat = $con->query('select * from category where catname="'.$data[4].'"')->fetch_assoc();
                      
                      if(empty($cat)){
                        $error .=" Wrong Category Id at row ".$err.",";
                      }
                      $subcat = $con->query('select * from subcategory where name="'.$data[5].'"')->fetch_assoc();
                      if(empty($subcat)){
                        $error .=" Wrong SubCategory Id at row ".$err.",";
                      }
                      $check_stock = $con->query('select * from inventory_stock where product_name="'.$data[0].'"')->num_rows;
                      if($check_stock == 0){
                        $error .=" Product Is not present in Inventory row No:".$err.",";
                      }
                      $counts = $con->query('select * from product where pname="'.$data[0].'"and created_by= '.$admin_id.' and cid= '.$cat['id'].' and sid='.$subcat['id'])->num_rows;
                      if($error == ''){
                        if($counts != 0 )
                        {
                          
                        }
                        else 
                        {
                          
                            $check_file = file_exists($data[1]);
                            $check_file_rel = file_exists($data[2]);
                            if($check_file == 0){
                              $data[1]='product/thump_1618401711.jpg';
                            }
                            if($check_file_rel == 0){
                              $data[2]='product/thump_1618401711.jpg';
                            }
                             
                            $con->query('insert into product(`pname`,`pimg`,`prel`,`sname`,`cid`,`sid`,`psdesc`,`pgms`,`pprice`,`date`,`status`,`stock`,`discount`,`popular`,`created_by`)values("'.$data[0].'","'.$data[1].'","'.$data[2].'","'.$data[3].'",'.$cat['id'].','.$subcat['id'].',"'.$data[6].'","'.$data[7].'","'.$data[8].'","'.$timestamp.'",'.$data[10].','.$data[9].','.$data[11].','.$data[12].','.$admin_id.')');
                        }
                      }else{
                        $con->rollback();
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
                window.location.href="productlist.php";
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