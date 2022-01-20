<?php
    
    include '../include/dbconfig.php';
    

        if(isset($_GET['export'])){

            $admin_id = $_SESSION['ADMIN_ID'];
            $role = $con->query('SELECT * FROM `admin` WHERE id='.$admin_id)->fetch_assoc();
            $role_id =$role['user_role'];

            $username = $_SESSION['username'];
            include '../check_specific_menu.php';
            $outcolumn = ['Id','Rider Name','Email','Mobile','Area','Address','Agent','Status(Web App)','Reject','Accept','Complete','Rider Status(App)'];
            
            if($username == 'admin' || $check_menu_dboy['view_g'] ==1){
                $history = $con->query("select rider.*, admin.username, area_db.name as area_name, agents.name as agent_name from rider left join admin on admin.id = rider.created_by left join area_db on area_db.id = rider.area_id left join agents on agents.id = rider.agent_id order by rider.id desc ")->fetch_all(MYSQLI_ASSOC);

            }else{
                $history = $con->query("select rider.*,area_db.name as area_name,agents.name as agent_name, admin.username from rider left join admin on admin.id = rider.created_by left join area_db on area_db.id = rider.area_id left join agents on agents.id = rider.agent_id where rider.created_by =".$admin_id." order by rider.id desc ")->fetch_all(MYSQLI_ASSOC);
            }
            

            $column = ['id','name','email','mobile','area_name','address','agent_name','status','reject','accept','complete','a_status'];
            if($username == 'admin'){
                $column[] = 'username';
                $outcolumn[] = 'Created By';
            }

            $file_name = 'DeliveryBoyList_'.strtotime('now').'.csv';
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