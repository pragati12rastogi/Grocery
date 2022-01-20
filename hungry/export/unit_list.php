<?php
    
    include '../include/dbconfig.php';
    

        if(isset($_GET['export'])){

            $admin_id = $_SESSION['ADMIN_ID'];
            $role = $con->query('SELECT * FROM `admin` WHERE id='.$admin_id)->fetch_assoc();
            $role_id =$role['user_role'];

            $username = $_SESSION['username'];
            include '../check_specific_menu.php';
            $outcolumn = ['Id','Unit'];
            
            if($username == 'admin' || $check_unit['view_g'] ==1){
                $history = $con->query("select units.id, units.unit_name, admin.username from units left join admin on admin.id = units.created_by  order by units.id desc ")->fetch_all(MYSQLI_ASSOC);

            }else{
                $history = $con->query("select units.id, units.unit_name, admin.username from units left join admin on admin.id = units.created_by where units.created_by =".$admin_id." order by units.id desc ")->fetch_all(MYSQLI_ASSOC);
            }
            

            $column = ['id','unit_name'];
            if($username == 'admin'){
                $column[] = 'username';
                $outcolumn[] = 'Created By';
            }

            $file_name = 'UnitList'.strtotime('now').'.csv';
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