<?php
    
    include '../include/dbconfig.php';

        if(isset($_GET['export'])){
            $admin_id = $_SESSION['ADMIN_ID'];
            $role = $con->query('SELECT * FROM `admin` WHERE id='.$admin_id)->fetch_assoc();
            $role_id =$role['user_role'];

            $check_menu_stock = $con->query('Select sidemenu_permission.*, sidemenu.menu_name from sidemenu_permission left join sidemenu on sidemenu.id= sidemenu_permission.side_menu_id where role_id ='.$role_id.' and sidemenu.menu_name="Stock Management"')->fetch_assoc();
            $username = $_SESSION['username'];

            $outcolumn = ['Id','Product Name','Category','Sub Category','Quantity','Price','Total Buying Price','Selling Price With Profit','Total Amount With Profit','Unit','Changable','Status','Timestamp'];
            
            if($username == 'admin' || $check_menu_stock['view_g'] ==1){
                $history = $con->query("SELECT inventory_stock.*,category.catname, subcategory.name as subcat from `inventory_stock` left join category on category.id = inventory_stock.cat_id left join subcategory on inventory_stock.subcat_id = subcategory.id order by id desc ")->fetch_all(MYSQLI_ASSOC);

            }else{
                $history = $con->query("SELECT inventory_stock.*,category.catname, subcategory.name as subcat from `inventory_stock` left join category on category.id = inventory_stock.cat_id left join subcategory on inventory_stock.subcat_id = subcategory.id where inventory_stock.created_by =".$admin_id." order by id desc ")->fetch_all(MYSQLI_ASSOC);
            }
            

            $column = ['id','product_name','catname','subcat','prod_quantity','prod_price','total_buying_price','selling_price_wth_prft','total_price_with_profit','unit','is_changeable','status','added_on'];
            $file_name = 'StockList_'.strtotime('now').'.csv';
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