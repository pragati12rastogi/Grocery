<?php 
include '../include/dbconfig.php';

require_once '../dompdf/autoload.inc.php';
// reference the Dompdf namespace
use Dompdf\Dompdf;

if(isset($_GET['save'])){
	$return_arr = array();

	$product_name1 = mysqli_real_escape_string($con,$_GET['product_name']);
	
	$query = "SELECT * FROM inventory_stock WHERE product_name ='".$product_name1."'";
	$result = mysqli_query($con,$query);
	
	while($row = mysqli_fetch_assoc($result)){
		
		$id = $row['id'];
	    $product_name = $row['product_name'];
	    $barcode = $row['barcode'];
	    $prod_quantity = $row['prod_quantity'];
	    $prod_price = $row['prod_price'];
	    $selling_price_wth_prft = $row['selling_price_wth_prft'];
	    $unit = $row['unit'];
	    $is_changeable = $row['is_changeable'];
		
		if($product_name === $product_name1){
			$return_arr[] = array("id" => $id,
			"product_name" => $product_name,
			"barcode" => $barcode,
			"prod_quantity" => $prod_quantity,
			"selling_price_wth_prft" => $selling_price_wth_prft,
			"unit" => $unit,
			"is_changeable" => $is_changeable);
		}

	}
	
	echo json_encode($return_arr);
}


if(isset($_GET['submit_order'])){
	$data = json_decode($_GET['data'],true);
	
	$stock_ids = $data['prod_id'];
	$units = $data['unit'];
	$quantities = $data['qty'];
	$totals = $data['total'];
	$user_no = $data['user_id'];
	$customer_note = $data['customer_note'];
	$owner_note = $data['owner_note'];
	$payment_type =$data['payment_type'];
	$timeslot = date('h:i:s A');
	$last_id = $con->query('SELECT * FROM `orders` ORDER BY `orders`.`id` DESC limit 1')->fetch_assoc();
	$new_id = empty($last_id)?1:$last_id['id']+1;
	$order_code =uniqid("#ORD-".$new_id."-");

	$con->begin_transaction();

	$total_sum =0;
	foreach($stock_ids as $ind => $stock_id){
		$total_sum += $totals[$stock_id];
	}
	$get_user_detail = "SELECT * FROM user WHERE mobile ='".$user_no."'";
	$result_user_detail = mysqli_query($con,$get_user_detail);
	$user_row = $result_user_detail->fetch_assoc();
	
	$date = date('Y-m-d');
	$status = "completed";
	if(empty($user_row['id'])){
		$con->rollback();
		$return_err = array("order_id"=>null,"error"=>"User dont exist!!");
		echo json_encode($return_err);
		die();
	}
	$con->query("insert into orders(`uid`,`order_date`,`status`,`total`,`p_method`,`owner_note`,`customer_note`,`order_type`,`timesloat`,`order_code`) values(".$user_row['id'].",'".$date."','".$status."',".$total_sum.",'".$payment_type."','".$owner_note."','".$customer_note."','store','".$timeslot."','".$order_code."')");
	$order_id = mysqli_insert_id($con);
	// $order_id = 1;
	
	foreach($stock_ids as $ind => $stock_id){

		$get_product_detail = "SELECT * FROM inventory_stock WHERE id ='".$stock_id."'";
		$result_product_detail = mysqli_query($con,$get_product_detail);
		$stock_row = $result_product_detail->fetch_assoc();

		// insert order_details
		$con->query("insert into order_details(`oid`,`item`,`price`,`qty`,`total`,`unit`,`product_name`,`is_changable`) values(".$order_id.",".$stock_id.",".$stock_row['selling_price_wth_prft'].",".$quantities[$stock_id].",".$totals[$stock_id].",'".$units[$stock_id]."','".$stock_row['product_name']."',".$stock_row['is_changeable'].")");

		if($stock_row['unit'] != $units[$stock_id]){
			if($stock_row['unit'] == "Kg"){
				if($units[$stock_id] == "Gm"){
					$rest_qty = $stock_row['prod_quantity']-($quantities[$stock_id]/1000);
				}else if($units[$stock_id] == "Mg"){
					$rest_qty = $stock_row['prod_quantity']-($quantities[$stock_id]/100000);
				}else{
					$rest_qty = $stock_row['prod_quantity']- $quantities[$stock_id];
				}
			}else if($stock_row['unit'] == "Gm"){
				if($units[$stock_id] == "Mg"){
					$rest_qty = $stock_row['prod_quantity']-($quantities[$stock_id]/1000);
				}else{
					$rest_qty = $stock_row['prod_quantity']- $quantities[$stock_id];
				}
			}else{
				$rest_qty = $stock_row['prod_quantity']- $quantities[$stock_id];
			}
			
		}else{
			$rest_qty = $stock_row['prod_quantity']-$quantities[$stock_id];
		}
		$rest_qty = round($rest_qty,2);
		if($rest_qty < 0){
			$con->rollback();
			$return_err = array("order_id"=>null,"error"=>$stock_row['product_name']." Quantity is not sufficient to complete order.");
			echo json_encode($return_err);
			die();
		}
		
		$new_update = $con->query('INSERT INTO `inventory_stock_history`(`product_name`, `cat_id`, `subcat_id`, `prod_quantity`, `prod_price`, `total_buying_price`, `selling_price_wth_prft`, `total_price_with_profit`, `unit`, `is_changeable`, `status`) VALUES ("'.$stock_row['product_name'].'",'.$stock_row['cat_id'].','.$stock_row['subcat_id'].','.$quantities[$stock_id].','.$stock_row['prod_price'].','.$stock_row['total_buying_price'].','.$stock_row['selling_price_wth_prft'].','.$totals[$stock_id].',"'.$units[$stock_id].'","'.$stock_row['is_changeable'].'","Sold")');
		
		if($new_update==0){
			$con->rollback();
			$return_err = array("order_id"=>null,"error"=>"Some error occured!!");
			echo json_encode($return_err);
			die();
		}
		// update stock
		$con->query("UPDATE `inventory_stock` Set `prod_quantity` = ".$rest_qty." WHERE id=".$stock_id);
	}
	if(!empty($order_id)){
		$_SESSION["ORDER_ID"] = $order_id;		
	}
	$return_arr = array("order_id" => $order_id);
	$con->commit();	
	echo json_encode($return_arr);
}

if(isset($_GET['product_namess'])){
	$name = $_GET['name'];
	$products = $con->query("select * from inventory_stock where product_name='".$name."'")->fetch_all(MYSQLI_ASSOC);

	if(count($products)<=0){
		$return_arr = ['status'=>'error'];
		echo json_encode($return_arr);
		die();
	}else{
		foreach($products as $ind => $prod){
			if($prod['product_name'] === $name){
				$products = $prod;
			}
		}
		$return_arr = ['status'=>'success','product'=>$products];
		echo json_encode($return_arr);
		die();
	}
	
}

if(isset($_GET['send_otp'])){
	$cust_id = $_GET['cust_id'];
	$otp = mt_rand(100000,999999);
	$con->begin_transaction();
	$get_mobile = $con->query('Select * from `user` WHERE id="'.$cust_id.'"')->fetch_assoc();
	$mobile = $get_mobile['mobile'];
	$update_otp = $con->query('UPDATE  `user` SET `active_otp`="'.$otp.'" WHERE id='.$cust_id);
	
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://control.msg91.com/api/sendotp.php?authkey=302176AeEcfLaw5dc0355a&mobile='.$mobile.'&message=Hungry%2520Grocery%2520'.$otp.'&sender=OWNWAY&country=91&otp='.$otp.'&otp_length=6',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_HTTPHEADER => array(
		  'Content-Type: application/json; charset=utf-8',
		  'authkey: 302176AeEcfLaw5dc0355a'
		),
	  ));
	
	$response = curl_exec($curl);
	
	curl_close($curl);
	$err = curl_error($curl);
	if($err){
		$con->rollback();
		$return_arr = ['status'=>'error','mesg'=>$err];
		echo json_encode($return_arr);
		die();
	}
	$return_arr = ['status'=>'success'];
	$con->commit();
	echo json_encode($return_arr);
}

if(isset($_GET['submit_otp'])){
	$cust_id = $_GET['cust_id'];
	$otp = $_GET['otp'];
	
	$check = $con->query('Select * from `user` WHERE id="'.$cust_id.'" and `active_otp`="'.$otp.'"')->fetch_assoc();
	if(!empty($check)){
		$update_otp = $con->query('UPDATE  `user` SET `status`= 1 WHERE id='.$cust_id);
		$return_arr = ['status'=>'success','msg'=>'User Activated'];
	}else{
		$return_arr = ['status'=>'error','msg'=>'Wrong OTP Inserted'];
	}
	echo json_encode($return_arr);
}
?>