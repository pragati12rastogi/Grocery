<?php
    if($username != 'admin'){
        $check_unit = $con->query('Select sidemenu_permission.*, sidemenu.menu_name from sidemenu_permission left join sidemenu on sidemenu.id= sidemenu_permission.side_menu_id where role_id ='.$role_id.' and sidemenu.menu_name="Unit Master"')->fetch_assoc();
	  
        $check_category = $con->query('Select sidemenu_permission.*, sidemenu.menu_name from sidemenu_permission left join sidemenu on sidemenu.id= sidemenu_permission.side_menu_id where role_id ='.$role_id.' and sidemenu.menu_name="Category"')->fetch_assoc();
        
        $check_sub_category = $con->query('Select sidemenu_permission.*, sidemenu.menu_name from sidemenu_permission left join sidemenu on sidemenu.id= sidemenu_permission.side_menu_id where role_id ='.$role_id.' and sidemenu.menu_name="Sub Category"')->fetch_assoc();
        
        $check_menu_prod = $con->query('Select sidemenu_permission.*, sidemenu.menu_name from sidemenu_permission left join sidemenu on sidemenu.id= sidemenu_permission.side_menu_id where role_id ='.$role_id.' and sidemenu.menu_name="Product"')->fetch_assoc();
        
        $check_menu_stock = $con->query('Select sidemenu_permission.*, sidemenu.menu_name from sidemenu_permission left join sidemenu on sidemenu.id= sidemenu_permission.side_menu_id where role_id ='.$role_id.' and sidemenu.menu_name="Stock Management"')->fetch_assoc();
	
        $check_menu_coupon = $con->query('Select sidemenu_permission.*, sidemenu.menu_name from sidemenu_permission left join sidemenu on sidemenu.id= sidemenu_permission.side_menu_id where role_id ='.$role_id.' and sidemenu.menu_name="Coupon"')->fetch_assoc();
        
        $check_menu_area = $con->query('Select sidemenu_permission.*, sidemenu.menu_name from sidemenu_permission left join sidemenu on sidemenu.id= sidemenu_permission.side_menu_id where role_id ='.$role_id.' and sidemenu.menu_name="Area"')->fetch_assoc();
        
        $check_menu_timeslot = $con->query('Select sidemenu_permission.*, sidemenu.menu_name from sidemenu_permission left join sidemenu on sidemenu.id= sidemenu_permission.side_menu_id where role_id ='.$role_id.' and sidemenu.menu_name="Timeslot"')->fetch_assoc();
        
        $check_menu_agent = $con->query('Select sidemenu_permission.*, sidemenu.menu_name from sidemenu_permission left join sidemenu on sidemenu.id= sidemenu_permission.side_menu_id where role_id ='.$role_id.' and sidemenu.menu_name="Agents"')->fetch_assoc();
        
        $check_menu_dboy = $con->query('Select sidemenu_permission.*, sidemenu.menu_name from sidemenu_permission left join sidemenu on sidemenu.id= sidemenu_permission.side_menu_id where role_id ='.$role_id.' and sidemenu.menu_name="Delivery Boy"')->fetch_assoc();

        $check_menu_banner = $con->query('Select sidemenu_permission.*, sidemenu.menu_name from sidemenu_permission left join sidemenu on sidemenu.id= sidemenu_permission.side_menu_id where role_id ='.$role_id.' and sidemenu.menu_name="Banner"')->fetch_assoc();
        
        $check_menu_home = $con->query('Select sidemenu_permission.*, sidemenu.menu_name from sidemenu_permission left join sidemenu on sidemenu.id= sidemenu_permission.side_menu_id where role_id ='.$role_id.' and sidemenu.menu_name="Home Section"')->fetch_assoc();
        
        $check_menu_notifi = $con->query('Select sidemenu_permission.*, sidemenu.menu_name from sidemenu_permission left join sidemenu on sidemenu.id= sidemenu_permission.side_menu_id where role_id ='.$role_id.' and sidemenu.menu_name="Notification"')->fetch_assoc();
        
        $check_menu_order = $con->query('Select sidemenu_permission.*, sidemenu.menu_name from sidemenu_permission left join sidemenu on sidemenu.id= sidemenu_permission.side_menu_id where role_id ='.$role_id.' and sidemenu.menu_name="Orders"')->fetch_assoc();
        
        $check_menu_customer = $con->query('Select sidemenu_permission.*, sidemenu.menu_name from sidemenu_permission left join sidemenu on sidemenu.id= sidemenu_permission.side_menu_id where role_id ='.$role_id.' and sidemenu.menu_name="Customer Section"')->fetch_assoc();

        $check_menu_country = $con->query('Select sidemenu_permission.*, sidemenu.menu_name from sidemenu_permission left join sidemenu on sidemenu.id= sidemenu_permission.side_menu_id where role_id ='.$role_id.' and sidemenu.menu_name="Country Code"')->fetch_assoc();

        $check_menu_billing = $con->query('Select sidemenu_permission.*, sidemenu.menu_name from sidemenu_permission left join sidemenu on sidemenu.id= sidemenu_permission.side_menu_id where role_id ='.$role_id.' and sidemenu.menu_name="Billing"')->fetch_assoc();

        $check_menu_payment = $con->query('Select sidemenu_permission.*, sidemenu.menu_name from sidemenu_permission left join sidemenu on sidemenu.id= sidemenu_permission.side_menu_id where role_id ='.$role_id.' and sidemenu.menu_name="Payment List"')->fetch_assoc();
  
    }
    

?>