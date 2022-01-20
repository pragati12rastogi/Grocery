<?php 
require 'db.php';
$data = json_decode(file_get_contents('php://input'), true);
if(empty($data)){
	$data = $_GET;
}
if($data['uid'] == '' or $data['oid'] == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
    $uid = strip_tags(mysqli_real_escape_string($con,$data['uid']));
    $oid = strip_tags(mysqli_real_escape_string($con,$data['oid']));

    $con->begin_transaction();
    //stock refilled
    $order_detail = $con->query('Select * from order_details where oid ='.$oid)->fetch_all(MYSQLI_ASSOC);
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

      $updating =$con->query("UPDATE inventory_stock set prod_quantity='".$sum_qty."',total_buying_price=".$total_buying_price.",total_price_with_profit=".$total_price_with_profit.",status =".$status." where id='".$detail['item']."'");
                            
      if($updating == 0 || $insert_old == 0){
          $con->rollback();
          echo '<script>alert("Some Error Occured")</script>';
          die();
      }
      $sum_qty = round($sum_qty - $inventory['prod_quantity'],3);
      $qty_buy_price = round($sum_qty * $inventory['prod_price']);
      $qty_sell_price = round($sum_qty * $inventory['selling_price_wth_prft']);
      
      $new_update = $con->query('INSERT INTO `inventory_stock_history`(`product_name`, `cat_id`, `subcat_id`, `prod_quantity`, `prod_price`, `total_buying_price`, `selling_price_wth_prft`, `total_price_with_profit`, `unit`, `is_changeable`, `status`,`created_by`) VALUES ("'.$inventory['product_name'].'",'.$inventory['cat_id'].','.$inventory['subcat_id'].','.$sum_qty.','.$inventory['prod_price'].','.$qty_buy_price.','.$inventory['selling_price_wth_prft'].','.$qty_sell_price.',"'.$inventory['unit'].'","'.$inventory['is_changeable'].'","Cancelled",0)');

    }
    $con->query('update orders SET `status` = "Cancelled" where id='.$oid.' and uid='.$uid);
    $con->commit();
    
    $returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Order Cancle Successfully!");
    
}
echo json_encode($returnArr);