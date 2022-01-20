
<?php 

require 'include/dbconfig.php';

$pid = $_POST['pid'];
$c = $con->query("select * from order_details where oid=".$pid."")->fetch_all(MYSQLI_ASSOC);
$order = $con->query("select * from orders where id=".$pid."")->fetch_assoc();


$uinfo = $con->query("select * from address where id=".(!empty($order['address_id'])?$order['address_id']:0)."")->fetch_assoc();
$user = $con->query("select * from user where id=".$order['uid']."")->fetch_assoc();
 

?>
<input type='button' id='btn' class="btn btn-primary text-right" value='Print' onclick='printDiv();' style="float:right;">
<div id="divprint">
<h5><b>Order Id :- <?php echo $pid;?></b></h5>
<h5><b>Customer Name :- <?php echo $user['name'];?></b></h5>
<h5><b>Customer Mobile :- <?php echo $user['mobile'];?></b></h5>
<h5><b>Address :- <?php echo (!empty($uinfo))?($uinfo['hno'].','.$uinfo['society'].','.$uinfo['area'].'-'.$uinfo['pincode']):'No Data Available';?></b></h5>
<h5><b>Landmark:- <?php echo (!empty($uinfo))?($uinfo['landmark']):'No Data Available';?></b></h5>

<h5><b>Payment Method :- <?php echo $order['p_method'];?></b></h5>

<h5><b>Delivery Date :- <?php echo ($order['order_type']=='store')?date('d-m-Y',strtotime($order['order_date'])):date('d-m-Y',strtotime($order['ddate']));?></b></h5>
<h5><b>Delivery Slot :- <?php echo $order['timesloat'];?></b></h5>
<h5><b>Order Type :- <?php echo ucfirst($order['order_type']);?></b></h5>
<?php 
if($order['p_method'] == 'Cash' or $order['p_method'] == 'Card' or $order['p_method'] == 'Pickup myself' or $order['p_method'] == 'Pickup Myself')
{
}
else
{
	?>
	<h5><b>Transaction Id :- <?php echo $order['tid'];?></b></h5>
	<?php 
}
?>
<div class="table-responsive">
<table class="table">
<tr>
<th>Sr No.</th>
<th>Product Name</th>
<th>Product Image</th>
<!-- <th>Discount</th> -->
<th>Product Category</th>
<th>Product Sub Category</th>
<th>Product Price</th>
<th>Product Qty</th>
<th>Product Total</th>
</tr>
<?php 
// $prid = explode('$;',$c['pid']);
// $qty = explode('$;',$c['qty']);
// $ptype = explode('$;',$c['ptype']);
// $pprice = explode('$;',$c['pprice']);
$pcount = count($c);

$op = 0;
$subtotal = 0;
	 $ksub = array();
	 
foreach($c as $ind => $details)
{
	$op = $op + 1;
  $pinfo = $con->query("select * from product where pname='".$details['product_name']."'")->fetch_assoc();
  $pinventory = $con->query("select inventory_stock.*, category.catname,subcategory.name as subcat from inventory_stock left join category on category.id = inventory_stock.cat_id left join subcategory on inventory_stock.subcat_id = subcategory.id where inventory_stock.id=".$details['item']."")->fetch_assoc();
  // $discount = $pprice[$i] * $pinfo['discount']*$qty[$i] /100;
	?>
      <tr>
      <td><?php echo $op;?></td>
      <td><?php echo $details['product_name'];?></td>
      <td>
          <?php
             if(!empty($pinfo) && $pinfo['pimg'] != '' && $pinfo['pimg'] != null){ 
               
            ?>
              <img src="<?php echo $pinfo['pimg'];?>" width="100px"/>
          <?php } ?>
      
          </td>
      <!-- <td><?php // echo $pinfo['discount'];?></td> -->
      <td><?php echo $pinventory['catname'];?></td>
      <td><?php echo $pinventory['subcat'];?></td>
      <td><?php echo $details['price'];?></td>
      <td><?php echo $details['qty'];?></td>
      <td><?php echo $details['total'];?></td>
      <!-- <td><?php //echo ($pprice[$i] * $qty[$i]) - $discount;?></td> -->
      </tr>
<?php


        // $ksub [] = $subtotal  + ($qty[$i] * $pprice[$i]) - $discount;
        
} ?>
</table>
</div>
<?php
$subtotal = number_format((float)($order['total']), 2, '.', '');
$tax = number_format((float) $subtotal * $order['tax']/100, 2, '.', '');
$coupon = $order['cou_amt'];
 $wallet = $order['wal_amt'];
?>
<ul class="list-group">
  <li class="list-group-item">
    <span class="badge bg-primary float-right budge-own" ><?php echo $order['p_method'];?></span> Payment Method
  </li>
  <li class="list-group-item">
    <span class="badge bg-info float-right budge-own" ><?php echo $subtotal?></span> Sub Total Price
  </li>
  
   <li class="list-group-item">
    <span class="badge bg-info float-right budge-own" ><?php echo $tax;?></span> Tax
  </li>
  <?php 
  if($coupon != 0)
  {
  ?>
   <li class="list-group-item">
    <span class="badge bg-info float-right budge-own" ><?php echo $coupon;?></span> Coupon Discount
  </li>
  <?php } ?>
  
  <?php 
  if($wallet != 0)
  {
  ?>
   <li class="list-group-item">
    <span class="badge bg-info float-right budge-own" ><?php echo $wallet;?></span> Wallet
  </li>
  <?php } ?>
  
  <li class="list-group-item">
    <span class="badge bg-info float-right budge-own" ><?php echo $order['total']- (($subtotal+$tax) - ($coupon + $wallet));?></span> Delivery Charge
  </li>
  
   <li class="list-group-item">
    <span class="badge bg-info float-right budge-own" ><?php echo $order['total'];?></span> Net Amount
  </li>
  <li class="list-group-item">
    <span class="badge bg-warning float-right budge-own" ><?php echo $order['status'];?></span> Order Status
  </li>
 
</ul>
</div>