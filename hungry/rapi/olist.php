<?php 
require 'db.php';
$data = json_decode(file_get_contents('php://input'), true);
if(empty($data)){
    $data = $_GET;
}
if($data['rid'] == '')
{ 
 $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Delivery Person Id Missing");    
}
else
{
    $rid =  strip_tags(mysqli_real_escape_string($con,$data['rid']));
 
    $sel = $con->query("select * from orders where rid=".$rid." and status !='Completed' and status !='Cancelled' and order_type ='app' order by id desc");
    
    if($sel->num_rows != 0)
    {
        $result = array();
        $final_result = array();
        while($row = $sel->fetch_assoc())
        {
            $oid = $row['id']; 
            $order_details = $con->query("select * from order_details where oid=".$oid." order by id desc")->fetch_all(MYSQLI_ASSOC);
            // $a = explode('$;',$row['pname']);    
            // $b =  explode('$;',$row['pprice']);
            // $c = explode('$;',$row['ptype']);
            // $d = explode('$;',$row['qty']);
            // $e = explode('$;',$row['pid']);
            
            $products=array();
            foreach($order_details as $index => $detail)
            {
                $product_list = $con->query("select * from product where pname='".$detail['product_name']."'")->fetch_all(MYSQLI_ASSOC);
                
                foreach($product_list as $in => $product){
                    if($product['pname'] == $detail['product_name']){
                        $product_list = $product;
                    }
                }
                
                $products[$index] = array("product_name"=>$detail['product_name'],"product_price"=>number_format((float)$detail['total'], 2, '.', ''),"product_weight"=>$detail['unit'],"product_qty"=>$detail['qty'],"product_image"=>$product_list['pimg'],"discount"=>$product_list['discount']);
            }
            $result['productinfo'] = $products;
            
            if($row['p_method'] == 'Pickup myself' and $row['status'] != 'completed' and $row['status'] != 'cancelled')
            {
                $status = $row['p_method'];
            }
            else 
            {
                $status =$row['status'];
            }
            
            $result['status'] = $status;
            $address = $con->query("select * from address where id='".$row['address_id']."'")->fetch_assoc();
            
            $user_detail = $con->query("select * from user where id='".$row['uid']."'")->fetch_assoc();
            
            $area_detail = $con->query("select * from area_db where id='".$user_detail['area_id']."'")->fetch_assoc();
            
            if($row['p_method'] == 'Pickup myself')
            {
                $px = 0;
            }
            else 
            {
                $px = $area_detail['dcharge'];
            }
            
            $result['d_charge'] = $px;
                
            $result['p_method'] = $row['p_method'];
            $result['total'] =$row['total'] ;
            $result['odate'] = $row['order_date'];
            $result['orderid'] = $row['id'];
            $result['order_no'] = $row['order_code'];
            $result['timesloat'] = $row['timesloat'];
            //$result['pickup'] = $row['pickup'];
            $result['astatus'] = $row['a_status'];
            $result['delivery'] = ($address)?$address['hno'].','.$address['society'].','.$address['area'].'-'.$address['pincode']:''; 
            $result['email'] = $user_detail['email'];
            $result['mobile'] = $user_detail['mobile'];
            $result['name'] = $user_detail['name'];
            $final_result[] =$result;
        }
        $returnArr = array("order_data"=>$final_result,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Order Get successfully!");
    }
    else 
    {
        $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"No Pending Order Found!");   
    }
}
echo json_encode($returnArr);