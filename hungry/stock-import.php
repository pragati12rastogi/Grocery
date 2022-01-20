<?php 
  require 'include/header.php';
  
  ?>
<?php 

?>

  <body data-col="2-columns" class=" 2-columns ">
      <div class="layer"></div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="wrapper">


      <!-- main menu-->
      <!--.main-menu(class="#{menuColor} #{menuOpenType}", class=(menuShadow == true ? 'menu-shadow' : ''))-->
      <?php include('main.php'); 
        if($username != 'admin' && $check_menu_stock['create'] !=1 ){?>
		<script>
			window.location.href="404.php";
		</script>
	    <?php	}
      ?>
      <!-- Navbar (Header) Ends-->

      <div class="main-panel">
        <div class="main-content">
          <div class="content-wrapper"><!--Statistics cards Starts-->
  <div class="container">
      
  </div>
<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-form">Upload CSV To Import Stock</h4>
					
				</div>
				<div class="card-body">
					<div class="px-3">
						<form class="form" method="post" enctype="multipart/form-data">
							<div class="form-body">
								
								<div class="form-group">
									<label>select A CSV</label>
									<input type="file" name="csv" class="form-control-file" id="projectinput8">
								</div>
							</div>

							<div class="form-actions">
								
								<button type="submit" name="sub_cat" class="btn btn-raised btn-raised btn-primary">
									<i class="fa fa-check-square-o"></i> Upload Csv
								</button>
								
								<a href="demo_files/stock_import_csv.csv" target="_blank" class="btn btn-raised btn-raised btn-info" id="download" >Stock Import Csv</a>
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
                    
                    $err++;
                    // get the values from the csv
                    $prod_name = mysqli_real_escape_string($con,$data[0]);		

                    if(empty($prod_name)){
                        $error .=" Enter Product at row ".$err.",";
                    }
                    
                    $con->begin_transaction();

                    $catname = $data[1];
				    $subcatname = $data[2];
                    
                    $catid = $con->query('SELECT id FROM `category` WHERE `catname` LIKE "%'.$catname.'%"')->fetch_assoc();
                    $subcatid = $con->query('SELECT id FROM `subcategory` WHERE `name` LIKE "%'.$subcatname.'%"')->fetch_assoc();
                    
                    if(empty($catid)){
                        $error .=" Wrong Category at row ".$err.",";
                    }
                    if(empty($subcatid)){
                        $error .=" Wrong Sub Category at row ".$err.",";
                    }
                    if(empty($data[3])){
                        $error .=" Empty Quantity at row ".$err.",";
                    }
                    if(empty($data[4])){
                        $error .=" Empty Price at row ".$err.",";
                    }
                    if(empty($data[5])){
                        $error .=" Empty Total Buying Price at row ".$err.",";
                    }
                    if(empty($data[6])){
                        $error .=" Empty Profit Type at row ".$err.",";
                    }
                    if(empty($data[7])){
                        $error .=" Empty Profit Value at row ".$err.",";
                    }
                    if(empty($data[8])){
                        $error .=" Empty Selling Price With Profit at row ".$err.",";
                    }
                    if(empty($data[9])){
                        $error .=" Empty Total Amount With Profit at row ".$err.",";
                    }
                    if(empty($data[10])){
                        $error .=" Empty Unit at row ".$err.",";
                    }
                    if($data[11] != 1 && $data[11] != 0){
                        $error .=" Empty Changable at row ".$err.",";
                    }
                    if(empty($data[12])){
                        $error .=" Empty Status at row ".$err.",";
                    }
                    if(empty($data[13])){
                        $error .=" Empty Discription at row ".$err.",";
                    }

                    if($error == ''){
                        
                        $catname = $catid['id'];
                        $subcatname = $subcatid['id'];

                        //Product ID
                        $checkprod = $con->query("select * from product where pname = '".$prod_name."' and cid=".$catname." and sid=".$subcatname."")->fetch_assoc();

                        $old_stock = $con->query("select * from inventory_stock where product_name='".$prod_name."'and cat_id='".$catname."' and subcat_id='".$subcatname."'")->fetch_assoc();
                        
                        $pquantity = $data[3];		
                        $pprice = $data[4];
                        $total_buying_price = mysqli_real_escape_string($con,$data[5]);
                        $profit_type = mysqli_real_escape_string($con,$data[6]);
                        $profit_value = mysqli_real_escape_string($con,$data[7]);
                        $selling_price_wth_prft = mysqli_real_escape_string($con,$data[8]);
                        $total_price_with_profit = mysqli_real_escape_string($con,$data[9]);
                        $product_unit = mysqli_real_escape_string($con,$data[10]);
                        $is_changeable = mysqli_real_escape_string($con,$data[11]);
                        $status = $data[12];
                        
                        
                        $user_detail = $con->query('Select * from admin where id='.$admin_id)->fetch_assoc();
                        $shop_name = $user_detail['shop_name'];
                        $shop_detail = mysqli_real_escape_string($con,$data[13]);
				
                        $publish = 1;
                        $url ='';
                        $related='';
                        if(!empty($checkprod)){
                            $old_pgms = explode('$;',$checkprod['pgms']);
                            $old_pprice = explode('$;',$checkprod['pprice']);

                            $old_pgms = array_unique($old_pgms);
                            $new_pgms = array_merge($old_pgms,[$product_unit]);
                            
                            $old_pprice = array_unique($old_pprice);
                            $new_pprice = array_merge($old_pprice,[$selling_price_wth_prft]);

                            $str_pgms = implode('$;',$new_pgms);
                            $str_pprice = implode('$;',$new_pprice);

                            
                            $con->query("UPDATE `product` SET `pname`='".$prod_name."',`sname`='".$shop_name."',`cid`=".$catname.",`sid`=".$subcatname.",`psdesc`='".$shop_detail."',`pgms`='".$str_pgms."',`pprice`='".$str_pprice."',`status`=".$publish.",`stock`=".$status.",`pimg`='".$url."',`prel`='".$related."',`date`='".$timestamp."',`discount`=0,`popular`=1,`created_by`='".$admin_id."' WHERE id=".$checkprod['id']);
                            
                        }else{
                            $new_pgms = $product_unit;
                            $new_pprice = $selling_price_wth_prft;

                            $con->query("insert into product(`pname`,`pimg`,`prel`,`sname`,`cid`,`sid`,`psdesc`,`pgms`,`pprice`,`date`,`status`,`stock`,`discount`,`popular`,`created_by`)values('".$prod_name."','".$url."','".$related."','".$shop_name."',".$catname.",".$subcatname.",'".$shop_detail."','".$new_pgms."','".$new_pprice."','".$timestamp."',".$publish.",".$status.",1,1,".$admin_id.")");
                        }

                        if(!empty($old_stock)){

                            $insert_old =$con->query('INSERT INTO `inventory_stock_history`(`product_name`, `cat_id`, `subcat_id`, `prod_quantity`, `prod_price`, `total_buying_price`, `selling_price_wth_prft`, `total_price_with_profit`, `unit`, `is_changeable`, `status`,`created_by`,`profit_type`,`profit_value`) VALUES ("'.$old_stock['product_name'].'",'.$old_stock['cat_id'].','.$old_stock['subcat_id'].','.$old_stock['prod_quantity'].','.$old_stock['prod_price'].','.$old_stock['total_buying_price'].','.$old_stock['selling_price_wth_prft'].','.($old_stock['total_price_with_profit']?$old_stock['total_price_with_profit']:0).',"'.$old_stock['unit'].'",'.$old_stock['is_changeable'].',"Old",'.$admin_id.',"'.$profit_type.'",'.$profit_value.')');
                            
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
                            $con->query("insert into inventory_stock(`product_name`,`cat_id`,`subcat_id`,`prod_quantity`,`prod_price`,`total_buying_price`,`selling_price_wth_prft`,`total_price_with_profit`,`unit`,`is_changeable`,`status`,`added_on`,`updated_on`,`created_by`,`profit_type`,`profit_value`)values('".$prod_name."','".$catname."','".$subcatname."','".$pquantity."','".$pprice."','".$total_buying_price."','".$selling_price_wth_prft."','".$total_price_with_profit."','".$product_unit."','".$is_changeable."','".$status."','".$timestamp."','".$timestamp."',".$admin_id.",'".$profit_type."',".$profit_value.")");
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
              toastr.info('Stock Imported Successfully!!');
              setTimeout(function()
              {
                window.location.href="stocklist.php";
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