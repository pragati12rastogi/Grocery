<?php 

require '../include/dbconfig.php';
 


if(isset($_POST['phone'])){
    $phoneNumber = $_POST['phone'];
    $return_arr = array();

    $admin_id = $_SESSION['ADMIN_ID'];
    $role = $con->query('SELECT * FROM `admin` WHERE id='.$admin_id)->fetch_assoc();
    $role_id =$role['user_role'];
    
    $username = $_SESSION['username'];
    
    $check_menu_customer = $con->query('Select sidemenu_permission.*, sidemenu.menu_name from sidemenu_permission left join sidemenu on sidemenu.id= sidemenu_permission.side_menu_id where role_id ='.$role_id.' and sidemenu.menu_name="Customer Section"')->fetch_assoc();

    if($username == 'admin' || $check_menu_customer['view_g'] ==1){
      $sql = "SELECT * FROM user WHERE mobile like '$phoneNumber%'";
    }else{
      $sql = "SELECT * FROM user WHERE mobile like '$phoneNumber%' and created_by =".$admin_id."";
    }

    $result = mysqli_query($con, $sql) or die("Query Failed".mysqli_error($con));
    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){        
       
        $id = $row['id'];
        $name = $row['name'];
        $email = $row['email'];
        $mobile = $row['mobile'];

        $return_arr[] = array("id" => $id,
                    "name" => $name,
                    "email" => $email,
                    "mobile" => $mobile,
                    );       

      }
    }else{
      //echo "No Data Found";
      //$return_arr[] = array("error" => "Not Found" );
    }

    echo json_encode($return_arr);
}

?>