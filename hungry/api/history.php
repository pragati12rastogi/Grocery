<?php 
require 'db.php';
$data = json_decode(file_get_contents('php://input'), true);
if(empty($data)){
	$data = $_GET;
}
if($data['uid'] == '')
{
 $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");    
}
else
{
    $uid =  strip_tags(mysqli_real_escape_string($con,$data['uid']));
  $sel = $con->query("select * from orders where uid=".$uid." order by id desc"); 
  
  $po= array();
  if($sel->num_rows != 0)
  {
  while($row = $sel->fetch_assoc())
  {
      $g['id'] = $row['id'];
      $g['order_no'] = $row['order_code'];
      $g['status'] = $row['status'];
      $g['order_date'] = $row['order_date'];
	    $g['total'] = $row['total'];
      $order_details = $con->query("select * from order_details where oid=".$row['id']."")->fetch_all(MYSQLI_ASSOC);
      foreach($order_details as $in => $detail){
        $g['product_name_with_qty_n_price'][$detail['product_name']]= 'Qty: '. $detail['qty'] .' '.$detail['unit'].', Total: '.$detail['total'];
      }
      
      $rdata = $con->query("select * from rider where id=".$row['rid']."")->fetch_assoc();
	    $g['rider_status'] = $row['r_status'];
	    $g['rider_name'] = (!empty($rdata))?$rdata['name']:'';
	    $g['rider_mobile'] = (!empty($rdata))?$rdata['mobile']:'';
  }
  $returnArr = array("Data"=>$g,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Order History  Get Successfully!!!");
  }
  else 
  {
	  $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Order  Not Found!!!");
  }
}
echo json_encode($returnArr);