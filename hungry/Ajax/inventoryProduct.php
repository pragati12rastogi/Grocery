<?php 

require '../include/dbconfig.php';

//  $productName = $_POST['value1'];

// //echo "select * from inventory_stock where product_name like '%$productName%'";
// $c = $con->query("select * from inventory_stock where product_name like '%$productName%'");
// while($row = $c->fetch_assoc()){
// 	echo $product_name = $row['product_name'];
// }
   
if(isset($_POST['value1'])){
   $productName = $_POST['value1'];
  // echo "SELECT * FROM school where school_name like %$name%";

    $admin_id = $_SESSION['ADMIN_ID'];
    $role = $con->query('SELECT * FROM `admin` WHERE id='.$admin_id)->fetch_assoc();
    $role_id =$role['user_role'];
    
    $username = $_SESSION['username'];
    
    $check_menu_stock = $con->query('Select sidemenu_permission.*, sidemenu.menu_name from sidemenu_permission left join sidemenu on sidemenu.id= sidemenu_permission.side_menu_id where role_id ='.$role_id.' and sidemenu.menu_name="Stock Management"')->fetch_assoc();
    
    if($username == 'admin' || $check_menu_stock['view_g'] ==1){
      $sql = 'SELECT * FROM inventory_stock WHERE product_name like "%'.$productName.'%"';
    }else{
      $sql = 'SELECT * FROM inventory_stock WHERE product_name like "%'.$productName.'%" and created_by ='.$admin_id.'';
    }
    
    $result = mysqli_query($con, $sql) or die("Query Failed".mysqli_error($conn));
    while($row = mysqli_fetch_assoc($result)){
        
        echo $productName = $row['product_name'].",";
      // $school_id = $row['school_id'];
    //   print_r($row);

    }

    if(mysqli_num_rows($result) > 0){
     

    }else{

    }
}

?>