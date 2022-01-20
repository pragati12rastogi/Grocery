<?php
    
    include '../include/dbconfig.php';
    

        if(isset($_GET['export'])){

            $admin_id = $_SESSION['ADMIN_ID'];
            $role = $con->query('SELECT * FROM `admin` WHERE id='.$admin_id)->fetch_assoc();
            $role_id =$role['user_role'];

            $username = $_SESSION['username'];

            include '../check_specific_menu.php';
            $outcolumn = ['Id','Product Name','Seller Name','Category Name','Sub Category Name','Description','Units','Price','Status','Date','Discount','Popular'];
            
            if($username == 'admin' || $check_menu_prod['view_g'] ==1){
                $history = $con->query("select product.*, category.catname, subcategory.name as sub_cat, admin.username from product left join category on category.id = product.cid left join subcategory on subcategory.id = product.sid left join admin on admin.id = product.created_by order by product.id desc")->fetch_all(MYSQLI_ASSOC);

            }else{
                $history = $con->query("select product.*, category.catname, subcategory.name as sub_cat, admin.username from product left join category on category.id = product.cid left join subcategory on subcategory.id = product.sid left join admin on admin.id = product.created_by where product.created_by =".$admin_id." order by product.id desc")->fetch_all(MYSQLI_ASSOC);
            }
            

            $column = ['id','pname','sname','catname','sub_cat','psdesc','pgms','pprice','status','date','discount','popular'];
            if($username == 'admin'){
                $column[] = 'username';
                $outcolumn[] = 'Created By';
            }

            $file_name = 'ProductList'.strtotime('now').'.csv';
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