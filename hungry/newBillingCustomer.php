<?php 
include 'include/dbconfig.php';


if(isset($_POST['name'])){
	$name = $_POST['name'];
	$email = $_POST['email'];
	$mobile = $_POST['mobile'];

	$admin_id = $_SESSION['ADMIN_ID'];
    $role = $con->query('SELECT * FROM `admin` WHERE id='.$admin_id)->fetch_assoc();
    $role_id =$role['user_role'];
    
    $username = $_SESSION['username'];
	
	$con->query("insert into user(`name`,`email`,`mobile`,`created_by`)values('".$name."','".$email."','".$mobile."',".$admin_id.")");
	if($con){
		//Query Success
		// echo 1;
		return 1;
	}else{
		//"Query Failed";
		return 0;
	}
}

?>