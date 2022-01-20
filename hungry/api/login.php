<?php 
require 'db.php';
$data = json_decode(file_get_contents('php://input'), true);

if(empty($data)){
	$data = $_GET;
}

if($data['mobile'] == ''  or $data['password'] == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
    $mobile = strip_tags(mysqli_real_escape_string($con,$data['mobile']));
    $password = strip_tags(mysqli_real_escape_string($con,$data['password']));
    
    $chek = $con->query("select * from user where (mobile='".$mobile."' or email='".$mobile."') and password='".$password."'")->fetch_assoc();
    if(!empty($chek)){
        if($chek['status'] == 1)
        {
            
            $dc = $con->query("select * from area_db where id='".$chek['area_id']."' and verfication_status= 1 ")->fetch_assoc();
            if(!empty($dc)){
                if($dc['status']==1){
                    $returnArr = array("user"=>$chek,"delivery_charge"=>$dc['dcharge'],"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Login successfully!");
                }else{
                    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Your Area is not Published!!!");
                }
                
            }else{
                $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Your Area is not Verified!!!");
            }
        }
        else  
        {
            $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Your Status Deactivate!!!");
        }
    }else
    {
        $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Invalid Email/Mobile No or Password!!!");
    }
        
}

echo json_encode($returnArr);