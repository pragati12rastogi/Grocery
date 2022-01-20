<?php 
    require 'include/header.php';
?>
<?php 

?>

    <body data-col="2-columns" class=" 2-columns ">
        <div class="layer"></div>
            <div class="wrapper">
                <!-- main menu-->
                <!--.main-menu(class="#{menuColor} #{menuOpenType}", class=(menuShadow == true ? 'menu-shadow' : ''))-->
                <?php include('main.php'); ?>
                <!-- Navbar (Header) Ends-->

                <div class="main-panel">
                    <div class="main-content">
                        <div class="content-wrapper"><!--Statistics cards Starts-->
                        <div class="row">
                            <div class="col-md-4">
                                <a href="rolelist.php" class="active btn btn-bitbucket" >Role List</a>
                            </div>
                        </div>
                        <?php if(isset($_GET['edit'])) {
                            $role = $con->query("select * from role where id=".$_GET['edit']."")->fetch_assoc();
                            
                        ?>
                        <div class="row">
		                    <div class="col-md-12">
			                    <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title" id="basic-layout-form">Edit Role</h4>
                                    </div>
				                    <div class="card-body">
                                        <div class="px-3">
                                            <form class="form" method="post" enctype="multipart/form-data">
                                                <div class="form-body">
								
                                                    <div class="form-group">
                                                        <label for="role">Enter Role</label>
                                                        <input type="text" id="role" value="<?php echo $role['role_name'];?>" class="form-control"  name="role" required >
                                                    </div>
                                                    <input type="hidden" value="<?php echo $_GET['edit']; ?>" name="role_id">
                                                    <table class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <td>Menu</td>
                                                                <td>Capabilities</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                $menulist = $con->query("SELECT * FROM `sidemenu`")->fetch_all(MYSQLI_ASSOC);
                                                                foreach($menulist as $ind=>$menu){
                                                                    $explode_option = explode(",",$menu['options']);
                                                                    $span_count = count($explode_option);
                                                                    $menu_per = $con->query("select * from sidemenu_permission where role_id=".$_GET['edit']." and side_menu_id=".$menu['id'])->fetch_assoc();
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <?php echo $menu['menu_name']; ?>
                                                                </td>
                                                                <td>
                                                                    <ul class="list-unstyled">
                                                                        <?php 
                                                                            foreach($explode_option as $in => $option){
                                                                                $checked = '';
                                                                                if(isset($menu_per['side_menu_id']) && $menu_per['side_menu_id'] == $menu['id']){
                                                                                    switch ($option) {
                                                                                        case 'View(Global)':
                                                                                            if($menu_per['view_g']==1){
                                                                                                $checked = 'checked'; 
                                                                                            }
                                                                                            break;
                                                                                        case 'View(Own)':
                                                                                            if($menu_per['view_o']==1){
                                                                                                $checked = 'checked'; 
                                                                                            }
                                                                                            break;
                                                                                        case 'Create':
                                                                                            if($menu_per['create']==1){
                                                                                                $checked = 'checked'; 
                                                                                            }
                                                                                            break;
                                                                                        case 'Edit':
                                                                                            if($menu_per['edit']==1){
                                                                                                $checked = 'checked'; 
                                                                                            }
                                                                                            break;
                                                                                        case 'Delete':
                                                                                            if($menu_per['delete']==1){
                                                                                                $checked = 'checked'; 
                                                                                            }
                                                                                            break;
                                                                                        default:
                                                                                            break;
                                                                                    }
                                                                                }
                                                                        ?>
                                                                        <li>
                                                                            <label><input type="checkbox" <?php echo $checked; ?>  onclick="disable_one(this)" id="option_<?php echo $menu['id']; ?>_<?php echo $option; ?>" value="<?php echo $option; ?>" name="menu[<?php echo $menu['id']; ?>][]"> <?php echo $option; ?></label>
                                                                        </li>
                                                                        <?php 
                                                                            }
                                                                        ?>
                                                                    </ul>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                                }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                    
							                    
                                                </div>

                                                <div class="form-actions">
                                                    <button type="submit" name="upd_role" class="btn btn-raised btn-raised btn-primary">
                                                        <i class="fa fa-check-square-o"></i> Update
                                                    </button>
                                                </div>
							
                                                <?php 
                                                    if(isset($_POST['upd_role'])){
                                                        
                                                        $role = $_POST['role'];
                                                        $con->begin_transaction();
                                                        $id = $_POST['role_id'];

                                                        $timestamp = date('Y-m-d H:i:s');
                                                        $menu_changed_arr =[];
                                                        $con->query("UPDATE `role` SET `role_name`='".$role."' WHERE id=".$id."");
                                                        $selected_menus = $_POST['menu'];
                                                        foreach($selected_menus as $menu_id => $options){
                                                            $view_g =0;
                                                            $view_o =0;
                                                            $create =0;
                                                            $edit =0;
                                                            $delete =0;
                                                            foreach($options as $in => $opt){
                                                                switch ($opt) {
                                                                    case 'View(Global)':
                                                                        $view_g =1;
                                                                        break;
                                                                    case 'View(Own)':
                                                                        $view_o =1;
                                                                        break;
                                                                    case 'Create':
                                                                        $create =1;
                                                                        break;
                                                                    case 'Edit':
                                                                        $edit =1;
                                                                        break;
                                                                    case 'Delete':
                                                                        $delete =1;
                                                                        break;
                                                                    default:
                                                                        
                                                                        break;
                                                                }
                                                            }
                                                            
                                                            
                                                            $check_role_present = $con->query("SELECT * FROM `sidemenu_permission` WHERE side_menu_id = ".$menu_id." and role_id =".$id."")->fetch_assoc();
                                                            if(!empty($check_role_present)){
                                                                
                                                                $menu_changed_arr[] = $check_role_present['menu_id'];
                                                                $upd_menu_select = $con->query("UPDATE `sidemenu_permission` SET `view_g`=".$view_g.",`view_o`=".$view_o.",`create`=".$create.",`edit`=".$edit.",`delete`=".$delete." WHERE menu_id =".$check_role_present['menu_id']);

                                                            }else{

                                                                $menu_select =$con->query("INSERT INTO `sidemenu_permission`(`side_menu_id`, `role_id`, `view_g`, `view_o`, `create`, `edit`, `delete`) VALUES (".$menu_id.",".$id.",".$view_g.",".$view_o.",".$create.",".$edit.",".$delete.")");
                                                                $menu_select = mysqli_insert_id($con);
                                                                $menu_changed_arr[] = $menu_select;
                                                            }
                                                                
                                                           
                                                        }
                                                        
                                                        if(count($menu_changed_arr)>0){
                                                            $menu_changed_arr = implode(',',$menu_changed_arr);
                                                            
                                                            $update_other_role = $con->query("DELETE from `sidemenu_permission` WHERE menu_id NOT IN(".$menu_changed_arr.") and role_id =".$id."");
                                                        }
                                                        
                                                        $con->commit();
                                                ?>
						
							                    <script type="text/javascript">
                                                    $(document).ready(function() {
                                                        toastr.options.timeOut = 4500; // 1.5s

                                                        toastr.info('Role Update Successfully!!');
                                                        setTimeout(function()
                                                        {
                                                            window.location.href="rolelist.php";
                                                        },1500);
                                                        
                                                    });
                                                </script>
  
                                                <?php 
                                                    
                                                    }
                                                ?>
						                    </form>
                                        </div>
                                    </div>
                                </div>
                            </div>		
	                    </div>
                        <?php } else { ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title" id="basic-layout-form">Add Role</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="px-3">
                                            <form class="form" method="post" enctype="multipart/form-data">
                                                <div class="form-body">
                                                    
                                                    <div class="form-group">
                                                        <label for="role">Add Role</label>
                                                        <input type="text" id="role" class="form-control"  name="role" required >
                                                    </div>

							                    </div>
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <td>Menu</td>
                                                            <td>Capabilities</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $menulist = $con->query("SELECT * FROM `sidemenu`")->fetch_all(MYSQLI_ASSOC);
                                                            foreach($menulist as $ind=>$menu){
                                                                $explode_option = explode(",",$menu['options']);
                                                                $span_count = count($explode_option);
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $menu['menu_name']; ?>
                                                            </td>
                                                            <td>
                                                                <ul class="list-unstyled">
                                                                    <?php 
                                                                        foreach($explode_option as $in => $option){
                                                                    ?>
                                                                    <li>
                                                                        <label><input type="checkbox" onclick="disable_one(this)" id="option_<?php echo $menu['id']; ?>_<?php echo $option; ?>" value="<?php echo $option; ?>" name="menu[<?php echo $menu['id']; ?>][]"> <?php echo $option; ?></label>
                                                                    </li>
                                                                    <?php 
                                                                        }
                                                                    ?>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <div class="form-actions">
                                                    <button type="submit" name="role_add" class="btn btn-raised btn-raised btn-primary">
                                                        <i class="fa fa-check-square-o"></i> Save
                                                    </button>
                                                </div>
							
                                                <?php 
                                                    if(isset($_POST['role_add'])){
                                                        $role = $_POST['role'];
                                                        $con->begin_transaction();

                                                        $timestamp = date('Y-m-d H:i:s');

                                                        $con->query("INSERT INTO `role`(`role_name`, `created_at`) VALUES ('".$role."','".$timestamp."')");

                                                        $insert_role_id= mysqli_insert_id($con);

                                                        $selected_menus = $_POST['menu'];
                                                        foreach($selected_menus as $menu_id => $options){
                                                            $view_g =0;
                                                            $view_o =0;
                                                            $create =0;
                                                            $edit =0;
                                                            $delete =0;
                                                            foreach($options as $in => $opt){
                                                                switch ($opt) {
                                                                    case 'View(Global)':
                                                                        $view_g =1;
                                                                        break;
                                                                    case 'View(Own)':
                                                                        $view_o =1;
                                                                        break;
                                                                    case 'Create':
                                                                        $create =1;
                                                                        break;
                                                                    case 'Edit':
                                                                        $edit =1;
                                                                        break;
                                                                    case 'Delete':
                                                                        $delete =1;
                                                                        break;
                                                                    default:
                                                                        
                                                                        break;
                                                                }
                                                            }

                                                            $menu_select =$con->query("INSERT INTO `sidemenu_permission`(`side_menu_id`, `role_id`, `view_g`, `view_o`, `create`, `edit`, `delete`) VALUES (".$menu_id.",".$insert_role_id.",".$view_g.",".$view_o.",".$create.",".$edit.",".$delete.")");
                                                            
                                                            if($menu_select == 0){
                                                                echo "<script>alert('Some error Occurred');</script>";
                                                                $con->rollback();
                                                                die();
                                                            }
                                                        }
                                                ?>
						
							                    <script type="text/javascript">
                                                    $(document).ready(function() {
                                                        toastr.options.timeOut = 4500; // 1.5s
                                                        toastr.info('Role Insert Successfully!!!');
                                                        
                                                    });
                                                </script>
                                                <?php 
                                                    $con->commit();
							                        }
							                    ?>
						                    </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
 
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    
        <?php 
            require 'include/js.php';
        ?>
        <script>
            function disable_one(i){
                var id = $(i).attr('id');
                var row_no = id.split('_')[1];
                var check_val = id.split('_')[2];
                var is_checked = document.getElementById(id).checked;
                if(check_val == "View(Global)" && is_checked == true){
                    document.getElementById("option_"+row_no+"_View(Own)").disabled = true;
                }else if(check_val == "View(Own)" && is_checked == true){
                    document.getElementById("option_"+row_no+"_View(Global)").disabled = true;
                }else{
                    var own_check = document.getElementById("option_"+row_no+"_View(Own)").checked;
                    var global_check = document.getElementById("option_"+row_no+"_View(Global)").checked;
                    if(own_check == false && global_check == false){
                        document.getElementById("option_"+row_no+"_View(Own)").disabled = false;
                        
                        document.getElementById("option_"+row_no+"_View(Global)").disabled = false;
                        
                    }
                }
            }
        </script>
    </body>
</html>