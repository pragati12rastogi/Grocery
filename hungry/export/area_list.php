<?php
    
    include '../include/dbconfig.php';
    

        if(isset($_GET['export'])){

            $admin_id = $_SESSION['ADMIN_ID'];
            $role = $con->query('SELECT * FROM `admin` WHERE id='.$admin_id)->fetch_assoc();
            $role_id =$role['user_role'];

            $username = $_SESSION['username'];
            include '../check_specific_menu.php';
            $outcolumn = ['Id','Area','Delivery Charge','Location Verified(1:Required,0:Not Required)','Status'];
            
            if($username == 'admin' || $check_menu_area['view_g'] ==1){
                $history = $con->query("select area_db.*, admin.username from area_db left join admin on admin.id = area_db.created_by  order by area_db.id desc ")->fetch_all(MYSQLI_ASSOC);

            }else{
                $history = $con->query("select area_db.*, admin.username from area_db left join admin on admin.id = area_db.created_by where area_db.created_by =".$admin_id." order by area_db.id desc ")->fetch_all(MYSQLI_ASSOC);
            }
            

            $column = ['id','name','dcharge','verfication_status','status'];
            if($username == 'admin'){
                $column[] = 'username';
                $outcolumn[] = 'Created By';
            }

            $file_name = 'AreaList_'.strtotime('now').'.csv';
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