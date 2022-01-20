<?php
    
    include '../include/dbconfig.php';
    

        if(isset($_GET['export'])){

            $admin_id = $_SESSION['ADMIN_ID'];
            $role = $con->query('SELECT * FROM `admin` WHERE id='.$admin_id)->fetch_assoc();
            $role_id =$role['user_role'];

            $username = $_SESSION['username'];
            include '../check_specific_menu.php';
            $outcolumn = ['Id','Section Title','Category Name','Sub-Category','Status'];
            
            if($username == 'admin' || $check_menu_home['view_g'] ==1){
                $history = $con->query("select home.*, admin.username, category.catname as category_name ,subcategory.name as sub_name from home left join admin on admin.id = home.created_by left join category on category.id = home.cid  left join subcategory on subcategory.id = home.sid order by home.id desc ")->fetch_all(MYSQLI_ASSOC);

            }else{
                $history = $con->query("select home.*, category.catname as category_name, admin.username,subcategory.name as sub_name  from home left join admin on admin.id = home.created_by left join category on category.id = home.cid left join subcategory on subcategory.id = home.sid where home.created_by =".$admin_id." order by home.id desc ")->fetch_all(MYSQLI_ASSOC);
            }
            

            $column = ['id','title','category_name','sub_name','status'];
            if($username == 'admin'){
                $column[] = 'username';
                $outcolumn[] = 'Created By';
            }

            $file_name = 'SectionList_'.strtotime('now').'.csv';
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