<?php 
  require 'include/header.php';
  $getkey = $con->query("select * from setting")->fetch_assoc();
define('ONE_KEY',$getkey['one_key']);
define('ONE_HASH',$getkey['one_hash']);
define('r_key',$getkey['r_key']);
define('r_hash',$getkey['r_hash']);
  ?>
  <body data-col="2-columns" class=" 2-columns ">
       <div class="layer"></div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="wrapper">


     
     <?php include('main.php');
      if($username != 'admin' && $check_menu_order['view_g'] !=1 && $check_menu_order['view_o'] !=1 ){
        ?>
            <script>
                window.location.href="404.php";
            </script>
        <?php			
            }
     ?>
     

      <div class="main-panel">
        <div class="main-content">
          <div class="content-wrapper"><!--Statistics cards Starts-->

            <div class="tab">
              <a href="order.php" ><button id="pending" type="button" class="active btn btn-bitbucket">Pending Orders</button></a>
              <a href="orders.php" ><button id="complete" type="button" class="btn btn-outline-bitbucket">Completed Orders</button></a>
              <a href="excel.php" ><button id="export" type="button" class="btn btn-outline-bitbucket">Export</button></a>
              <a href="orderbyshop.php" ><button id="shop" type="button" class="btn btn-outline-bitbucket">Shop Orders</button></a>
              <a href="orderbyapp.php" ><button id="app" type="button" class="btn btn-outline-bitbucket">App Orders</button></a>
              <a href="cancelled-order.php" ><button id="cancelled" type="button" class=" btn btn-outline-bitbucket">Cancelled Orders</button></a>

            </div>
<section id="dom">
    <div class="row">
        <div class="col-12">
            <div class="card">
			<?php
if(isset($_GET['oid']))
{
	?>
	      <div class="card-header">
                    <h4 class="card-title">Assign Delivery Boy To Selected Order</h4>
                </div>
                <div class="card-body collapse show">
                    <div class="card-block card-dashboard">
					<form class="form" method="post" enctype="multipart/form-data">
							<div class="form-body">
								

							<?php 
							$odata = $con->query("select * from orders where id=".$_GET['oid']."")->fetch_assoc();
							?>

								<div class="form-group">
									<label for="cname">Select Delivery Boy</label>
									<select name="srider" class="form-control">
									<option value="">select a Delivery Boy</option>
									<?php 
									$rid = $con->query("select * from rider where a_status=1 and status=1");
									while($ro = $rid->fetch_assoc())
									{
									?>
									<option value="<?php echo $ro['id'];?>" <?php if($ro['id'] == $odata['rid']) {echo 'selected'; } ?>><?php echo $ro['name'];?></option>
									<?php } ?>
									</select>
								</div>
                                
								<div class="form-group" style="display:none;">
									<label for="cname">Pickup Address</label>
									<textarea  class="form-control" name="pickup"  required>Surat Gujrat</textarea>
								</div>
								
								<div class="form-actions">
								
								<button type="submit" name="as_order" class="btn btn-raised btn-raised btn-primary">
									<i class="fa fa-check-square-o"></i> Assign Delivery Boy
								</button>
							</div>
								</div>
								</form>
					</div>
					</div>
					<?php 
					if(isset($_POST['as_order']))
					{
						
						$rid = $_POST['srider'];
						$pickup = $_POST['pickup'];
						$id = $_GET['oid'];
						$check = $con->query("select * from orders where id=".$id."")->fetch_assoc();
						if($check['r_status'] != 'Accepted')
						{
						$timestamp = date("Y-m-d H:i:s");
						$con->query("update orders set rid=".$rid.",pickup='".$pickup."',a_status=1,r_status='Assigned' where id=".$id."");
            $con->query("insert into rnoti(`rid`,`msg`,`date`)values(".$rid.",'You have an order assigned to you.','".$timestamp."')");											
                                  $content = array(
            "en" => 'You have an order assigned to you.'//mesaj burasi
            );
            $fields = array(
            'app_id' => r_key,
            'included_segments' =>  array("Active Users"),
            'filters' => array(array('field' => 'tag', 'key' => 'rider_id', 'relation' => '=', 'value' => $rid)),
            'contents' => $content
            );
            $fields = json_encode($fields);

            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
            curl_setopt($ch, CURLOPT_HTTPHEADER, 
            array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic '.r_hash));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            
            $response = curl_exec($ch);
            curl_close($ch);


					


						
						?>
						  <script type="text/javascript">
                $(document).ready(function() {
                  toastr.options.timeOut = 4500; // 1.5s
                  toastr.info('Assign Delivery Boy Successfully!!!');
                  window.location.href="order.php";
                
                });
              </script>
      <?php 
      }
      else 
      {
      ?>
						  <script type="text/javascript">
                $(document).ready(function() {
                  toastr.options.timeOut = 4500; // 1.5s
                  toastr.error('Assign Delivery Boy Already Accepted Order So Can not Change Delivery Boy.');
                  window.location.href="order.php";
                
                });
              </script>	
        <?php 
      }
    }
    ?>
					
	<?php 
}
else 
{	
			?>
                <div class="card-header">
                    <h4 class="card-title">Order List</h4>
                </div>
                <div class="card-body collapse show">
                    <div class="card-block card-dashboard">
                       
                        <table class="table table-striped" id="example">
                            <thead>
                                <tr>
								                    <th>Sr No.</th>
                                    <th>Date</th>
                                     <th>Order ID</th>
                                    <th>Delivery Boy Name</th>
                                    <th>Delivery Boy Assign Status</th>
                                    <th>Delivery Boy Delivery Status</th>
                                     <th>Status</th>
                                     <th>Preview</th>
									                    <th>Assign?</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if($username == 'admin' || $check_menu_order['view_g'] ==1){
                                    $sel = $con->query("select * from orders where status ='Pending' order by id desc");
                                }else{
                                    $sel = $con->query("select * from orders where status ='Pending' and created_by =".$admin_id." order by id desc");
                                }

                                $i=0;
                                while($row = $sel->fetch_assoc())
                                {
                                    
                                    $i = $i + 1;
                                ?>
                                <tr>
                                    
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row['order_date'];?></td>
									
                                    <td><?php echo $row['id'];?></td>
                                   <td><?php $rdata = $con->query("select * from rider where id=".$row['rid']."")->fetch_assoc(); if(!empty($rdata)){ if($rdata['name'] == '') {echo '';}else {echo $rdata['name'];}}else{echo '';}?>
                                    <td><?php if($row['a_status'] == 0){echo 'Not Assign';}else if($row['a_status'] == 1){echo 'Assign';}else if($row['a_status'] == 2) {echo 'Accepted';}else if($row['a_status'] == 3){echo 'Completed';}else if($row['a_status'] == 4){echo 'Cancelled';} else 
										{echo 'Rejected';}?></td>
										<td><?php
                                   echo $row['r_status'];
										?></td>
									<td><?php echo ucfirst($row['status']);?></td>
                                    								   <td>
								  <button class="preview_d btn btn-primary shadow-z-2" data-id="<?php echo $row['id'];?>" data-toggle="modal" data-target="#myModal">Preview</button></td>
								<td>
                
								<?php if($username == 'admin'|| $check_menu_order['edit'] ==1){
                  if($row['p_method'] !='Pickup Myself') {?>
								<?php if($row['a_status'] == 0) {

									?>
								
								 <a href="?oid=<?php echo $row['id'];?>"><button class="btn shadow-z-2 btn-info">Assign Delivery Boy</button></a>
								<?php } else if($row['a_status'] == 1) { 
								?>
								
								<a href="?oid=<?php echo $row['id'];?>"><button class="btn shadow-z-2 btn-info">Reassign Delivery Boy</button></a>
								<?php } else if($row['a_status'] == 2) { ?>
								<p>Accepted</p>
								<?php  } else if($row['a_status'] == 3) { ?>
								<p>Completed</p>
								<?php }else if($row['a_status'] == 4) { ?>
								<p>Cancelled(<?php echo $row['s_photo'];?>)</p>
								<?php }else { 
								?>
								<a href="?oid=<?php echo $row['id'];?>"><button class="btn shadow-z-2 btn-info">Reassign Delivery Boy</button></a>
								<?php } } else {
?>
<p>Pickup My Self</p>
<?php 
									}}?>
</td>								
								  
                                    <td>
                                    <?php if($username == 'admin'|| $check_menu_order['edit'] ==1){?>
									<?php if($row['p_method'] =='Pickup Myself' and $row['status'] != 'completed' and $row['status'] != 'cancelled') {?>
                  <a href="?status=completed&id=<?php echo $row['id'];?>"><button class="btn shadow-z-2 btn-success" >Make Completed</button></a>
                <?php } ?>
									 <a href="?dele=<?php echo $row['id'];?>"><button class="btn shadow-z-2 btn-danger gradient-pomegranate">Cancel</button></a>
                   <?php } ?>
										</td>
                                   
                                </tr>
                               <?php  }?>
                            </tbody>
                            
                        </table>
                    </div>
                </div>
<?php } ?>
            </div>
        </div>
    </div>
</section>
<?php 
if(isset($_GET['status']))
{
$status = $_GET['status'];
$id = $_GET['id'];

 $con->query("update orders set status='".$status."' where id=".$id."");  
?>
	 <script type="text/javascript">
  $(document).ready(function() {
    toastr.options.timeOut = 4500; // 1.5s

    toastr.info('Order Status Update Successfully!!');
	setTimeout(function()
	{
		window.location.href="order.php";
	},1500);
    
  });
  </script>
  <?php
}
if(isset($_GET['dele']))
{
    $con->begin_transaction();
    //stock refilled
    $order_detail = $con->query('Select * from order_details where oid ='.$_GET['dele'])->fetch_all(MYSQLI_ASSOC);
    foreach($order_detail as $ind => $detail){
      $inventory = $con->query('Select * from inventory_stock where id ='.$detail['item'])->fetch_assoc();

      $insert_old =$con->query('INSERT INTO `inventory_stock_history`(`product_name`, `cat_id`, `subcat_id`, `prod_quantity`, `prod_price`, `total_buying_price`, `selling_price_wth_prft`, `total_price_with_profit`, `unit`, `is_changeable`, `status`,`created_by`) VALUES ("'.$inventory['product_name'].'",'.$inventory['cat_id'].','.$inventory['subcat_id'].','.$inventory['prod_quantity'].','.$inventory['prod_price'].','.$inventory['total_buying_price'].','.$inventory['selling_price_wth_prft'].','.($inventory['total_price_with_profit']?$inventory['total_price_with_profit']:0).',"'.$inventory['unit'].'",'.$inventory['is_changeable'].',"Old",'.$inventory['created_by'].')');

      $pquantity = $detail['qty'];              
      if($inventory['unit'] == 'Kg'){
        if($detail['unit'] == 'Kg'){
            $pquantity = $detail['qty'];
        }else if($detail['unit'] == 'Gm'){
            $pquantity = ($detail['qty']/1000);
        }else if($detail['unit'] == 'Mg'){
            $pquantity = ($detail['qty']/100000);
        }
      }else if($inventory['unit'] == 'Gm'){
          if($detail['unit'] == 'Kg'){
              $pquantity = ($detail['qty']*1000);
          }else if($detail['unit'] == 'Gm'){
              $pquantity = $detail['qty'];
          }else if($detail['unit'] == 'Mg'){
              $pquantity = ($detail['qty']/1000);
          }
      }else if($inventory['unit'] == 'Mg'){
          if($detail['unit'] == 'Kg'){
              $pquantity = ($detail['qty']*100000);
          }else if($detail['unit'] == 'Gm'){
              $pquantity = ($detail['qty']*1000);
          }else if($detail['unit'] == 'Mg'){
              $pquantity = $detail['qty'];
          }
      }

      $sum_qty = $inventory['prod_quantity'] + $pquantity;
      $total_buying_price = $sum_qty*$inventory['prod_price'];
      $total_price_with_profit = $sum_qty*$inventory['selling_price_wth_prft'];
      $status = ( $sum_qty>0)?1:0;

      $updating =$con->query("UPDATE inventory_stock set prod_quantity='".$sum_qty."',total_buying_price=".$total_buying_price.",total_price_with_profit=".$total_price_with_profit.",status =".$status.",created_by=".$admin_id." where id='".$detail['item']."'");
                            
      if($updating == 0 || $insert_old == 0){
          $con->rollback();
          echo '<script>alert("Some Error Occured")</script>';
          die();
      }
      $sum_qty = round($sum_qty - $inventory['prod_quantity'],3);
      $qty_buy_price = round($sum_qty * $inventory['prod_price']);
      $qty_sell_price = round($sum_qty * $inventory['selling_price_wth_prft']);
      
      $new_update = $con->query('INSERT INTO `inventory_stock_history`(`product_name`, `cat_id`, `subcat_id`, `prod_quantity`, `prod_price`, `total_buying_price`, `selling_price_wth_prft`, `total_price_with_profit`, `unit`, `is_changeable`, `status`,`created_by`) VALUES ("'.$inventory['product_name'].'",'.$inventory['cat_id'].','.$inventory['subcat_id'].','.$sum_qty.','.$inventory['prod_price'].','.$qty_buy_price.','.$inventory['selling_price_wth_prft'].','.$qty_sell_price.',"'.$inventory['unit'].'","'.$inventory['is_changeable'].'","Cancelled",'.$admin_id.')');

    }
    $con->query("update orders SET `status` = 'Cancelled' where id=".$_GET['dele']."");
    $con->commit();
    

?>
	<script type="text/javascript">
  $(document).ready(function() {
    toastr.options.timeOut = 4500; // 1.5s

    toastr.error('selected order Cancelled successfully.');
    setTimeout(function()
	{
		window.location.href="order.php";
	},1500);
  });
  </script>
  <?php
}
?>



          </div>
        </div>

      

      </div>
    </div>
    
  <?php require 'include/js.php';?>
    
  </body>
  
   <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    
    <div class="modal-content">
      <div class="modal-header">
        <h4>Order Preivew</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body p_data">
      
      </div>
     
    </div>

  </div>
</div>

  <script>
       $('#example').DataTable();
  </script>
  <script>
$(document).ready(function()
{
	$("#example").on("click", ".preview_d", function()
	{
		var id = $(this).attr('data-id');
		$.ajax({
			type:'post',
			url:'pdata.php',
			data:
			{
				pid:id
			},
			success:function(data)
			{
				$(".p_data").html(data);
			}
		});
	});
});
</script>

<script>
function printDiv() 
{

  var divToPrint=document.getElementById('divprint');

  var newWin=window.open('','Print-Window');
var htmlToPrint = '' +
        '<style type="text/css">' +
        'table th, table td {' +
        'border:1px solid #000;' +
        'padding:0.5em;' +
        '}' +
        '.list-group { ' +
   ' display: flex; ' +
    ' flex-direction: column; ' +
   ' padding-left: 0; ' +
   ' margin-bottom: 0; ' +
 '}' +
 '.list-group-item {' +
   ' position: relative;' +
    'display: block;' +
    'padding: 0.75rem 1.25rem;' +
    'margin-bottom: -1px;' +
    'background-color: #fff;' +
    'border: 1px solid rgba(0, 0, 0, 0.125);' +
 '}' +
 
 '.float-right {' +
    'float: right !important;' +
 '}' +

        '</style>';
		
  newWin.document.open();
htmlToPrint += divToPrint.innerHTML;
  newWin.document.write('<html><body onload="window.print()">'+htmlToPrint+'</body></html>');
 
  newWin.document.close();

  setTimeout(function(){newWin.close();},1);

}
</script>

<style>
#example_wrapper
{
    overflow:auto;
}
    td p {
   /* border-bottom: 1px solid #dee2e6;*/
    /* padding: 0% !important; */
    margin: 0px;
   /* font-size:11px;*/
}
td.manage_td
{
padding: 0% !important;
}
table
{
   /* font-size:12px;*/
}
}
</style>

</html>