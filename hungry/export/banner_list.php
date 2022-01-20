<?php
    
    include '../include/dbconfig.php';
    

        if(isset($_GET['export'])){

            $admin_id = $_SESSION['ADMIN_ID'];
            $role = $con->query('SELECT * FROM `admin` WHERE id='.$admin_id)->fetch_assoc();
            $role_id =$role['user_role'];

            $username = $_SESSION['username'];
            include '../check_specific_menu.php';
            $outcolumn = ['Id','Banner Image','Category Name'];
            
            if($username == 'admin' || $check_menu_banner['view_g'] ==1){
                $history = $con->query("select banner.*, admin.username, category.catname as category_name from banner left join admin on admin.id = banner.created_by left join category on category.id = banner.cid order by banner.id desc ")->fetch_all(MYSQLI_ASSOC);

            }else{
                $history = $con->query("select banner.*, category.catname as category_name, admin.username from banner left join admin on admin.id = banner.created_by left join category on category.id = banner.cid where banner.created_by =".$admin_id." order by banner.id desc ")->fetch_all(MYSQLI_ASSOC);
            }
            

            $column = ['id','bimg','category_name'];
            if($username == 'admin'){
                $column[] = 'username';
                $outcolumn[] = 'Created By';
            }

            $file_name = 'BannerList_'.strtotime('now').'.csv';
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