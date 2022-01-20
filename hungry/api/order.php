<?php 
require 'db.php';
$data = json_decode(file_get_contents('php://input'), true);

if(empty($data)){
	$data = $_GET;
}

function stock_loop($pname,$order_id){
	
	require 'db.php';
	$con->begin_transaction();
	foreach($pname as $ind => $stock_detail){
		
		$get_product = $con->query("SELECT * FROM product WHERE id =".$stock_detail['pid']."")->fetch_assoc();

		$get_product_detail = $con->query('SELECT * FROM inventory_stock WHERE product_name ="'.$get_product['pname'].'"')->fetch_all(MYSQLI_ASSOC);
		
		foreach($get_product_detail as $in => $detail){
			if($detail['product_name'] == $get_product['pname']){
				$get_product_detail = $detail;
			}
		}
		// insert order_details
		$con->query("insert into order_details(`oid`,`item`,`price`,`qty`,`total`,`unit`,`product_name`,`is_changable`) values(".$order_id.",".$get_product_detail['id'].",".$get_product_detail['selling_price_wth_prft'].",".$stock_detail['qty'].",".$stock_detail['cost'].",'".$stock_detail['weight']."','".$get_product_detail['product_name']."',".$get_product_detail['is_changeable'].")");

		// If any unit of KG and GM and MG get converted
		if($get_product_detail['unit'] != $stock_detail['weight']){
			if($get_product_detail['unit'] == "Kg"){
				if($stock_detail['weight'] == "Gm"){
					$rest_qty = $get_product_detail['prod_quantity']-($stock_detail['qty']/1000);
				}else if($stock_detail['weight'] == "Mg"){
					$rest_qty = $get_product_detail['prod_quantity']-($stock_detail['qty']/100000);
				}else{
					$rest_qty = $get_product_detail['prod_quantity']- $stock_detail['qty'];
				}
			}else if($get_product_detail['unit'] == "Gm"){
				if($stock_detail['weight'] == "Mg"){
					$rest_qty = $get_product_detail['prod_quantity']-($stock_detail['qty']/1000);
				}else{
					$rest_qty = $get_product_detail['prod_quantity']- $stock_detail['qty'];
				}
			}else{
				$rest_qty = $get_product_detail['prod_quantity']- $stock_detail['qty'];
			}
			
		}else{
			$rest_qty = $get_product_detail['prod_quantity']-$stock_detail['qty'];
		}
		
		if($rest_qty < 0){
			$con->rollback();
			$return_err = array("status"=>"error","ResponseMsg"=>$get_product_detail['product_name']." Quantity is not sufficient to complete order.");
			
			return $return_err;
			
		}
		
		$new_update = $con->query('INSERT INTO `inventory_stock_history`(`product_name`, `cat_id`, `subcat_id`, `prod_quantity`, `prod_price`, `total_buying_price`, `selling_price_wth_prft`, `total_price_with_profit`, `unit`, `is_changeable`, `status`) VALUES ("'.$get_product_detail['product_name'].'",'.$get_product_detail['cat_id'].','.$get_product_detail['subcat_id'].','.$stock_detail['qty'].','.$get_product_detail['prod_price'].','.$get_product_detail['total_buying_price'].','.$get_product_detail['selling_price_wth_prft'].','.$stock_detail['cost'].',"'.$stock_detail['weight'].'","'.$get_product_detail['is_changeable'].'","Sold")');
		
		if($new_update==0){
			$con->rollback();
			$returnArr = array("status"=>"error","ResponseMsg"=>"Something Went Wrong!");
			return $returnArr;
			
		}
		$avail_stat =1;
		if($rest_qty <= 0){
			$avail_stat = 0;
		}
		// update stock
		$con->query("UPDATE `inventory_stock` Set `prod_quantity` = ".$rest_qty.",`status`= ".$avail_stat." WHERE id=".$get_product_detail['id']);
		$returnArr = array("status"=>"success");
		
	}	
	$con->commit();
	return $returnArr;
}

if($data['uid'] == '')
{
 	$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");    
}
else
{
	
    $con->begin_transaction();
	$uid =  $data['uid'];
	$ddate = date('Y-m-d',strtotime($data['ddate']));
	$timesloat = date('h:i:s A');
	$last_id = $con->query('SELECT * FROM `orders` ORDER BY `orders`.`id` DESC limit 1')->fetch_assoc();
	
	$new_id = empty($last_id)?1:$last_id['id']+1;
	$order_code =uniqid("#ORD-".$new_id."-");
	$pname = $data['pname'];
	$order_type = 'app';
	$status = 'Pending'; 
	$p_method = $data['p_method'];
	$address_id = $data['address_id'];
	$tax = $data['tax'];
	$coupon_id = $data['coupon_id'];
	$cou_amt = $data['cou_amt'];
	$wal_amt = $data['wal_amt'];
	$timestamp = date("Y-m-d");
	$tid = $data['tid'];
	$total = number_format((float)$data['total'], 2, '.', '');
	
	
	// old code
	/* 
	$e= array();
	$p = array();
	$w=array();
	$pp = array();
	$q = array();
	
	for($i=0;$i<count($pname);$i++)
	{
		$e[] = mysqli_real_escape_string($con,$pname[$i]['title']);
		$p[] = $pname[$i]['pid'];
		$w[] = $pname[$i]['weight'];
		$pp[] = $pname[$i]['cost'];
		$q[] = $pname[$i]['qty'];
	}
	$pname = implode('$;',$e);
	$pid = implode('$;',$p);
	$ptype = implode('$;',$w);
	$pprice = implode('$;',$pp);
	$qty = implode('$;',$q); */

	$getuinfo = $con->query("select * from user where id=".$uid."")->fetch_assoc();
	if($wal_amt != 0)
	{  
		if($wal_amt > $getuinfo['wallet'])
		{
			$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"You Not Have Enough Balance In Wallet!");    
		}
		else 
		{	

			$con->query("insert into orders(`uid`,`order_code`,`ddate`,`order_date`,`status`,`total`,`p_method`,`address_id`,`order_type`,`timesloat`,`tax`,`tid`,`cou_amt`,`coupon_id`,`wal_amt`) values(".$uid.",'".$order_code."','".$ddate."','".$timestamp."','".$status."',".$total.",'".$p_method."',".$address_id.",'".$order_type."','".$timesloat."',".$tax.",'".$tid."',".$cou_amt.",".$coupon_id.",".$wal_amt.")");
			// inserted order id
			$order_id = mysqli_insert_id($con);

			$stock_insert = stock_loop($pname,$order_id);
			
			if(isset($stock_insert)){
				if($stock_insert['status']== 'error'){
					$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>$stock_insert['ResponseMsg']); 
				}
			}
			// old code 
			/* $con->query("insert into orders(`order_code`,`uid`,`pname`,`pid`,`ptype`,`pprice`,`ddate`,`timesloat`,`order_date`,`status`,`qty`,`total`,`p_method`,`address_id`,`tax`,`tid`,`cou_amt`,`coupon_id`,`wal_amt`,`order_type`)values('".$order_code."',".$uid.",'".$pname."','".$pid."','".$ptype."','".$pprice."','".$ddate."','".$timesloat."','".$timestamp."','".$status."','".$qty."',".$total.",'".$p_method."',".$address_id.",".$tax.",'".$tid."',".$cou_amt.",".$coupon_id.",".$wal_amt.",'".$order_type."')"); */

			$con->query("update user set wallet=wallet-".$wal_amt." where id=".$uid."");
			$con->query("insert into wallet_report(`uid`,`message`,`status`,`amt`)values(".$uid.",'Wallet Balance Use For Order!!','Debit',".$wal_amt.")");
			$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Order Placed Successfully!!!");
			$con->commit();
		}
	}
	else 
	{
		
		// old code
		/* $con->query("insert into orders(`order_code`,`uid`,`pname`,`pid`,`ptype`,`pprice`,`ddate`,`timesloat`,`order_date`,`status`,`qty`,`total`,`p_method`,`address_id`,`tax`,`tid`,`cou_amt`,`coupon_id`,`wal_amt`)values('".$order_code."',".$uid.",'".$pname."','".$pid."','".$ptype."','".$pprice."','".$ddate."','".$timesloat."','".$timestamp."','".$status."','".$qty."',".$total.",'".$p_method."',".$address_id.",".$tax.",'".$tid."',".$cou_amt.",".$coupon_id.",".$wal_amt.")"); */

		$con->query("insert into orders(`uid`,`order_code`,`ddate`,`order_date`,`status`,`total`,`p_method`,`address_id`,`order_type`,`timesloat`,`tax`,`tid`,`cou_amt`,`coupon_id`,`wal_amt`) values(".$uid.",'".$order_code."','".$ddate."','".$timestamp."','".$status."',".$total.",'".$p_method."',".$address_id.",'".$order_type."','".$timesloat."',".$tax.",'".$tid."',".$cou_amt.",".$coupon_id.",".$wal_amt.")");
		
		// inserted order id
		$order_id = mysqli_insert_id($con);
		
		$stock_insert = stock_loop($pname,$order_id);
		
		if(isset($stock_insert)){
			if($stock_insert['status']== 'error'){
				$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>$stock_insert['ResponseMsg']); 
				echo json_encode($returnArr);
				exit();
			}
		}
		
		$con->query("update user set wallet=wallet-".$wal_amt." where id=".$uid."");
		$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Order Placed Successfully!!!");
		$con->commit();
	}
}

echo json_encode($returnArr);