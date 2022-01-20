
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Invoice</title>

<style>
@media print {
  .noPrint{
    display:none;
  }
}</style>
</head> 
<body>
<?php 
    include 'include/dbconfig.php';
    if(isset($_GET['order_id'])){
        $order_id =$_GET['order_id'];
        $order_data = "SELECT orders.*,user.name as user_name,user.mobile,user.email FROM orders left join user on orders.uid=user.id WHERE orders.id ='".$order_id."'" ;
        $result_order = mysqli_query($con,$order_data);
		$order_row = $result_order->fetch_assoc();
    }
    
    ?>
    <input type="button" onclick="window.print()" value="Print" style="width:100px;
    margin: 10px 253px;
    color: azure;
    background: crimson;
    border: 1px solid blanchedalmond;
    padding: 12px;
    font-size: larger;
    border-radius: 13px;" class="noPrint"/>
	<table style="width:1000px; margin:0px auto; border:solid 1px #666666; border-spacing:0px" id="printableArea">
		<tr>
			<td colspan="11" style=" border-spacing:0px; text-align:center; padding:8px ;"><img src="website/thump_1597913295.png" style="height:45px"/></td>
		</tr>
		<tr>
			<td colspan="11" style="border-top: solid 1px #666666;border-bottom: solid 1px #666666; border-spacing:0px; text-align:center; padding:8px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:18px">Billing Invoice</td>
		</tr>
		<tr>
			<td colspan="11" style="border-spacing:0px; text-align:center; padding:8px">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="3" style=" vertical-align:top ; border-spacing:0px; padding:8px; width:300px; font-family:Arial, Helvetica, sans-serif; font-size:14px">Hungry Groceries<br />
			<td colspan="4" style="border-spacing:0px;padding:8px; width:350px">
				<table style="width:350px;border-spacing:0px">
					<tr>
						<td style="border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px">Customer Name</td>
						<td style="border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px"><?php echo($order_row['user_name']); ?></td>
					</tr>
					
					<tr>
						<td style="border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px">Order Date</td>
						<td style="border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px"><?php echo date("d-m-Y",strtotime($order_row['order_date'])); ?></td>
					</tr>
					
					<tr>
						<td style="border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px">Phone Number</td>
						<td style="border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px"><?php echo ($order_row['mobile']); ?></td>
					</tr>
                    
				</table>
			</td>
		</tr>
		
		<tr>
			<td colspan="2" style="border: solid 1px #666666;border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px; width:30px">Sr No.</td>
			<td style="border: solid 1px #666666;border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px; width:300px">Product</td>
			<td style="border: solid 1px #666666;border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px; width:80px">Price</td>
			<td style="border: solid 1px #666666;border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px; width:80px">Unit</td>
			<td style="border: solid 1px #666666;border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px; width:80px">Quantity</td>
			<td style="border: solid 1px #666666;border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px; width:80px">Changable</td>
			<td style="border: solid 1px #666666;border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px; width:80px">Total</td>
		</tr>
		<?php 
            $order_detail_data = "SELECT order_details.* FROM order_details WHERE `oid` ='".$order_id."'" ;
            $result_order_detail = mysqli_query($con,$order_detail_data);
            $order_detail_row = mysqli_fetch_all($result_order_detail,MYSQLI_ASSOC);

            
        $i=1; foreach($order_detail_row as $ind => $od) { ?><tr>
			<td colspan="2" style="border: solid 1px #666666;border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px;"><?php echo $i++; ?></td>
			<!--<td style="border: solid 1px #666666;border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px"></td>-->
			<td   style="border: solid 1px #666666;border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px"><?php echo $od['product_name']; ?></td>
			<td style="border: solid 1px #666666;border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px"><?php echo $od['price']; ?></td>
			<td style="border: solid 1px #666666;border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px"><?php echo $od['unit']; ?></td>
			<td style="border: solid 1px #666666;border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px"><?php echo $od['qty']; ?></td>
			<td style="border: solid 1px #666666;border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px"><?php echo ($od['is_changable'] != '0'? "Yes" : "No"); ?></td>
			<td style="border: solid 1px #666666;border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px"><?php echo ($od['total']); ?></td>
		</tr><?php } ?>
		
		<tr>
			<td colspan="5" style="border: solid 1px #666666;border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px">&nbsp;</td>
			<td colspan="2" style="border: solid 1px #666666;border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px">Gross Amount</td>
			<td colspan="2" style="border: solid 1px #666666;border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px"><?php echo $order_row['total']; ?></td>
			
		</tr>
		
		
		<tr>
			<td colspan="3" style="border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px;font-weight:bold;">Pre Authenticated by</td>
			<td colspan="8" style="border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="1" style="border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px;font-weight:bold;"></td>
			<td colspan="2" style="border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px">&nbsp;</td>
			<td colspan="4" style="border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px">&nbsp;</td>
			<td colspan="2" style="border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px;font-weight:bold;">For Hungry</td>
			<td colspan="2" style="border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="1" style="border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px;font-weight:bold;"></td>
			<td colspan="10" style="border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="7" style="border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px">Please check the contents before taking delivery of the consignment</td>
			<td colspan="4" style="border-spacing:0px; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:14px">&nbsp;</td>
		</tr>
	</table>
</body>
</html>
