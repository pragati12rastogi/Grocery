<?php
    
    include '../include/dbconfig.php';
    

        if(isset($_GET['export'])){

            $admin_id = $_SESSION['ADMIN_ID'];
            $role = $con->query('SELECT * FROM `admin` WHERE id='.$admin_id)->fetch_assoc();
            $role_id =$role['user_role'];

            $username = $_SESSION['username'];
            include '../check_specific_menu.php';
            $outcolumn = ['Id','Name','IMEI','Email','Phone','Area','Country code','Register Date','Status','Pin','Wallet','Pin Code','Refer code'];
            
            if($username == 'admin' || $check_menu_customer['view_g'] ==1){
                $history = $con->query("select user.*, admin.username,  area_db.name as area_name from user left join admin on admin.id = user.created_by left join area_db on area_db.id = user.area_id order by user.id desc ")->fetch_all(MYSQLI_ASSOC);

            }else{
                $history = $con->query("select user.*, admin.username, area_db.name as area_name from user left join admin on admin.id = user.created_by left join area_db on area_db.id = user.area_id where user.created_by =".$admin_id." order by user.id desc ")->fetch_all(MYSQLI_ASSOC);
            }
            

            $column = ['id','name','imei','email','mobile','area_name','ccode','rdate','status','pin','wallet','code','refercode'];
            if($username == 'admin'){
                $column[] = 'username';
                $outcolumn[] = 'Created By';
            }

            $file_name = 'CustomerList_'.strtotime('now').'.csv';
            header("Content-type: application/csv");
            header("Content-Disposition: attachment; filename=".$file_name);
            $fp = fopen('php://output', 'w');
            if ($fp) {
                $tmpArray = $outcolumn;
                fputcsv($fp, $tmpArray);
                foreach($history as $key => $data) {
                    $tmpArray = [];
                    foreach ($column as $ind => $col_name) {
                        $tmpArray[]=$data[$col_name];
                    }                 
                    fputcsv($fp, $tmpArray);
                }
            }   
            fclose($fp);
            exit();
        }
?>