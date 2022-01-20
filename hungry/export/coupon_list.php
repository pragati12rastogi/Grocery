<?php
    
    include '../include/dbconfig.php';
    

        if(isset($_GET['export'])){

            $admin_id = $_SESSION['ADMIN_ID'];
            $role = $con->query('SELECT * FROM `admin` WHERE id='.$admin_id)->fetch_assoc();
            $role_id =$role['user_role'];

            $username = $_SESSION['username'];
            include '../check_specific_menu.php';
            $outcolumn = ['Id','Expiry Date','Description','Coupon Value','Coupon Title','Status(0=unpublish; 1=publish)','Min Order Amount'];
            
            if($username == 'admin' || $check_menu_coupon['view_g'] ==1){
                $history = $con->query("select tbl_coupon.*, admin.username from tbl_coupon left join admin on admin.id = tbl_coupon.created_by  order by tbl_coupon.id desc ")->fetch_all(MYSQLI_ASSOC);

            }else{
                $history = $con->query("select tbl_coupon.*, admin.username from tbl_coupon left join admin on admin.id = tbl_coupon.created_by where tbl_coupon.created_by =".$admin_id." order by tbl_coupon.id desc ")->fetch_all(MYSQLI_ASSOC);
            }
            

            $column = ['id','cdate','c_desc','c_value','ctitle','status','min_amt'];
            if($username == 'admin'){
                $column[] = 'username';
                $outcolumn[] = 'Created By';
            }

            $file_name = 'CouponList_'.strtotime('now').'.csv';
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