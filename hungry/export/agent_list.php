<?php
    
    include '../include/dbconfig.php';
    

        if(isset($_GET['export'])){

            $admin_id = $_SESSION['ADMIN_ID'];
            $role = $con->query('SELECT * FROM `admin` WHERE id='.$admin_id)->fetch_assoc();
            $role_id =$role['user_role'];

            $username = $_SESSION['username'];
            include '../check_specific_menu.php';
            $outcolumn = ['Id','Agent Name','Email','Mobile','Area','Address','Profit Type','Status','Reject','Accept','Complete'];
            
            if($username == 'admin' || $check_menu_agent['view_g'] ==1){
                $history = $con->query("select agents.*, admin.username, area_db.name as area_name from agents left join admin on admin.id = agents.created_by left join area_db on area_db.id = agents.area_id order by agents.id desc ")->fetch_all(MYSQLI_ASSOC);

            }else{
                $history = $con->query("select agents.*,area_db.name as area_name, admin.username from agents left join admin on admin.id = agents.created_by left join area_db on area_db.id = agents.area_id where agents.created_by =".$admin_id." order by agents.id desc ")->fetch_all(MYSQLI_ASSOC);
            }
            

            $column = ['id','name','email','mobile','area_name','address','profit_type','status','reject','accept','complete'];
            if($username == 'admin'){
                $column[] = 'username';
                $outcolumn[] = 'Created By';
            }

            $file_name = 'AgentList_'.strtotime('now').'.csv';
            header("Content-type: application/csv; charset=utf-8'");
            header("Content-Disposition: attachment; filename=".$file_name);
            var_dump(ini_get('allow_url_fopen'));
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