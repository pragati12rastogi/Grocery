<?php
    
    include '../include/dbconfig.php';
    

        if(isset($_GET['export'])){

            $admin_id = $_SESSION['ADMIN_ID'];
            $role = $con->query('SELECT * FROM `admin` WHERE id='.$admin_id)->fetch_assoc();
            $role_id =$role['user_role'];

            $username = $_SESSION['username'];

            include '../check_specific_menu.php';
            $outcolumn = ['Id','Category','Total Sub-Cat'];
            
            if($username == 'admin' || $check_category['view_g'] ==1){
                $history = $con->query("select category.id, category.catname,(select count(sub.id) from subcategory as sub where sub.cat_id= category.id)as total_sub, admin.username from category left join admin on admin.id = category.created_by order by category.id desc ")->fetch_all(MYSQLI_ASSOC);

            }else{
                $history = $con->query("select category.id, category.catname,(select count(sub.id) from subcategory as sub where sub.cat_id= category.id )as total_sub, admin.username from category left join admin on admin.id = category.created_by where category.created_by =".$admin_id." order by category.id desc ")->fetch_all(MYSQLI_ASSOC);
            }
            

            $column = ['id','catname','total_sub'];
            if($username == 'admin'){
                $column[] = 'username';
                $outcolumn[] = 'Created By';
            }

            $file_name = 'CategoryList'.strtotime('now').'.csv';
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