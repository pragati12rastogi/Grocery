<?php
    
    include '../include/dbconfig.php';
    

        if(isset($_GET['export'])){

            $admin_id = $_SESSION['ADMIN_ID'];
            $role = $con->query('SELECT * FROM `admin` WHERE id='.$admin_id)->fetch_assoc();
            $role_id =$role['user_role'];

            $username = $_SESSION['username'];

            include '../check_specific_menu.php';
            $outcolumn = ['Id','Sub Category','Total Product'];
            
            if($username == 'admin' || $check_sub_category['view_g'] ==1){
                $history = $con->query("select subcategory.id, subcategory.name,(select count(p.id) from product as p where p.sid =subcategory.id)as total_product, admin.username from subcategory left join admin on admin.id = subcategory.created_by order by subcategory.id desc ")->fetch_all(MYSQLI_ASSOC);

            }else{
                $history = $con->query("select subcategory.id, subcategory.name,(select count(p.id) from product as p where p.sid =subcategory.id)as total_product, admin.username from subcategory left join admin on admin.id = subcategory.created_by where subcategory.created_by =".$admin_id." order by subcategory.id desc ")->fetch_all(MYSQLI_ASSOC);
            }
            

            $column = ['id','name','total_product'];
            if($username == 'admin'){
                $column[] = 'username';
                $outcolumn[] = 'Created By';
            }

            $file_name = 'SubcategoryList'.strtotime('now').'.csv';
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