<?php 
    require 'include/header.php';
?>
<?php 
    $roles = $con->query("select * from role")->fetch_all(MYSQLI_ASSOC);
    $areas = $con->query("select * from area_db where status = 1")->fetch_all(MYSQLI_ASSOC);

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
                        
                        <?php if(isset($_GET['edit'])) {
                            $edituser = $con->query("select * from admin where id=".$_GET['edit']."")->fetch_assoc();
                            
                        ?>
                        <div class="row">
		                    <div class="col-md-12">
			                    <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title" id="basic-layout-form">Edit User</h4>
                                    </div>
				                    <div class="card-body">
                                        <div class="px-3">
                                            <form class="form" method="post" enctype="multipart/form-data" autocomplete="off">
                                                <div class="form-body">
								
                                                <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="role">User Name</label>
                                                                <input type="text" id="username" class="form-control" value="<?php echo $edituser['username']?>" name="username" required >
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="role">Role</label>
                                                                <select id="user_role" class="form-control" name="user_role" required>
                                                                    <option value="" disabled>Select role</option>
                                                                    <?php
                                                                        foreach($roles as $ind => $role){
                                                                            $selected = '';
                                                                            if($role['id']==$edituser['user_role']){
                                                                                $selected='selected';
                                                                            }
                                                                    ?>
                                                                    <option value="<?php echo $role['id']; ?>" <?php echo $selected; ?> ><?php echo $role['role_name']; ?></option>
                                                                    <?php        
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="role">Mobile</label>
                                                                <input type="text" value="<?php echo $edituser['mobile']?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="10" id="mobile" class="form-control"  name="mobile" required >
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="area">Area</label>
                                                                <select id="area" class="form-control" name="area" required>
                                                                    <option value="" disabled>Select area</option>
                                                                    <?php
                                                                        foreach($areas as $ind => $area){
                                                                            $selected = '';
                                                                            if($area['id']==$edituser['area_id']){
                                                                                $selected='selected';
                                                                            }
                                                                    ?>
                                                                    <option value="<?php echo $area['id']; ?>" <?php echo $selected; ?> ><?php echo $area['name']; ?></option>
                                                                    <?php        
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="email">Email</label>
                                                                <input type="email" id="email" value="<?php echo $edituser['email']; ?>" class="form-control"  name="email" required >
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="password">Password</label>
                                                                <input type="password" id="password" class="form-control" value="<?php echo $edituser['password']; ?>"  name="password" required >
                                                                <i class="ft-eye-off" id="eye-pos" onclick="show_pass(this)"></i>
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="shop_name">Shop Name</label>
                                                                <input type="text" id="shop_name" class="form-control" value="<?php echo $edituser['shop_name']; ?>"  name="shop_name" required >
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="contact_person">Contact Person Name</label>
                                                                <input type="text" id="contact_person" class="form-control" value="<?php echo $edituser['contact_person']; ?>"  name="contact_person" required >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="shop_name">Shop Address</label>
                                                                <textarea class="form-control" name="shop_address" id="shop_address" required><?php echo $edituser['shop_address']; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" value="<?php echo $_GET['edit']; ?>" name="admin_id">
                                                    
                                                </div>

                                                <div class="form-actions">
                                                    <button type="submit" name="upd_role" class="btn btn-raised btn-raised btn-primary">
                                                        <i class="fa fa-check-square-o"></i> Update
                                                    </button>
                                                </div>
							
                                                <?php 
                                                    if(isset($_POST['upd_role'])){
                                                        
                                                        $con->begin_transaction();

                                                        $username = mysqli_real_escape_string($con,$_POST['username']);
                                                        $user_role = mysqli_real_escape_string($con,$_POST['user_role']);
                                                        $mobile = mysqli_real_escape_string($con,$_POST['mobile']);
                                                        $area = mysqli_real_escape_string($con,$_POST['area']);
                                                        $email = mysqli_real_escape_string($con,$_POST['email']);
                                                        $password = mysqli_real_escape_string($con,$_POST['password']);
                                                        $shop_name = mysqli_real_escape_string($con,$_POST['shop_name']);
                                                        $contact_person = mysqli_real_escape_string($con,$_POST['contact_person']);
                                                        $shop_address = mysqli_real_escape_string($con,$_POST['shop_address']);
                                                        $admin_id = $_POST['admin_id'];

                                                        $check_email = $con->query('select admin.* from admin where `email`="'.$email.'" and id !='.$admin_id)->fetch_assoc();

                                                        $check_mobile = $con->query('select admin.* from admin where `mobile`="'.$mobile.'" and id !='.$admin_id)->fetch_assoc();

                                                        if(!empty($check_email)){
                                                            $con->rollback();
                                                            echo "<script>alert('Email ID exist');</script>";
                                                            exit();
                                                        }
                                                        if(!empty($check_mobile)){
                                                            $con->rollback();
                                                            echo "<script>alert('Mobile already exist');</script>";
                                                            exit();
                                                        }

                                                    	$update = $con->query('UPDATE `admin` SET `username`="'.$username.'",`password`="'.$password.'",`user_role`='.$user_role.',`mobile`="'.$mobile.'",`area_id`='.$area.',`email`="'.$email.'",`shop_name`="'.$shop_name.'",`contact_person`="'.$contact_person.'",`shop_address`="'.$shop_address.'" WHERE id='.$admin_id);
                                                        if($update == 0){
                                                            $con->rollback();
                                                            echo "<script>alert('Something Went wrong');</script>";
                                                            exit();
                                                        }

                                                        $con->commit();
                                                ?>
						
							                    <script type="text/javascript">
                                                    $(document).ready(function() {
                                                        toastr.options.timeOut = 4500; // 1.5s

                                                        toastr.info('User Update Successfully!!');
                                                        setTimeout(function()
                                                        {
                                                            window.location.href="userslist.php";
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
                                        <h4 class="card-title" id="basic-layout-form">Add Users</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="px-3">
                                            <form class="form" method="post" enctype="multipart/form-data" autocomplete="off">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="role">User Name</label>
                                                                <input type="text" id="username" class="form-control"  name="username" required >
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="role">Role</label>
                                                                <select id="user_role" class="form-control" name="user_role" required>
                                                                    <option value="" disabled>Select role</option>
                                                                    <?php
                                                                        foreach($roles as $ind => $role){
                                                                    ?>
                                                                    <option value="<?php echo $role['id']; ?>"><?php echo $role['role_name']; ?></option>
                                                                    <?php        
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="role">Mobile</label>
                                                                <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="10" id="mobile" class="form-control"  name="mobile" required >
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="area">Area</label>
                                                                <select id="area" class="form-control" name="area" required>
                                                                    <option value="" disabled>Select area</option>
                                                                    <?php
                                                                        foreach($areas as $ind => $area){
                                                                    ?>
                                                                    <option value="<?php echo $area['id']; ?>"><?php echo $area['name']; ?></option>
                                                                    <?php        
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="email">Email</label>
                                                                <input type="email" id="email" class="form-control"  name="email" required >
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="password">Password</label>
                                                                <input type="password" id="password" class="form-control"  name="password" required >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="shop_name">Shop Name</label>
                                                                <input type="text" id="shop_name" class="form-control"  name="shop_name" required >
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="contact_person">Contact Person Name</label>
                                                                <input type="text" id="contact_person" class="form-control"  name="contact_person" required >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="shop_name">Shop Address</label>
                                                                <textarea class="form-control" name="shop_address" id="shop_address" required></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    

							                    </div>
                                                
                                                <div class="form-actions">
                                                    <button type="submit" name="user_add" class="btn btn-raised btn-raised btn-primary">
                                                        <i class="fa fa-check-square-o"></i> Save
                                                    </button>
                                                </div>
							
                                                <?php 
                                                    if(isset($_POST['user_add'])){
                                                        $con->begin_transaction();

                                                        $username = mysqli_real_escape_string($con,$_POST['username']);
                                                        $user_role = mysqli_real_escape_string($con,$_POST['user_role']);
                                                        $mobile = mysqli_real_escape_string($con,$_POST['mobile']);
                                                        $area = mysqli_real_escape_string($con,$_POST['area']);
                                                        $email = mysqli_real_escape_string($con,$_POST['email']);
                                                        $password = mysqli_real_escape_string($con,$_POST['password']);
                                                        $shop_name = mysqli_real_escape_string($con,$_POST['shop_name']);
                                                        $contact_person = mysqli_real_escape_string($con,$_POST['contact_person']);
                                                        $shop_address = mysqli_real_escape_string($con,$_POST['shop_address']);

                                                        $check_email = $con->query('select admin.* from admin where `email`="'.$email.'"')->fetch_assoc();

                                                        $check_mobile = $con->query('select admin.* from admin where `mobile`="'.$mobile.'"')->fetch_assoc();

                                                        if(!empty($check_email)){
                                                            $con->rollback();
                                                            echo "<script>alert('Email ID exist');</script>";
                                                            exit();
                                                        }
                                                        if(!empty($check_mobile)){
                                                            $con->rollback();
                                                            echo "<script>alert('Mobile already exist');</script>";
                                                            exit();
                                                        }

                                                    	$insert = $con->query("insert into `admin`(`username`, `password`, `user_role`, `mobile`, `area_id`, `email`, `shop_name`, `contact_person`, `shop_address`)values('".$username."','".$password."',".$user_role.",'".$mobile."',".$area.",'".$email."','".$shop_name."','".$contact_person."','".$shop_address."')");
                                                        if($insert == 0){
                                                            $con->rollback();
                                                            echo "<script>alert('Something Went wrong');</script>";
                                                            exit();
                                                        }

                                                ?>
						
							                    <script type="text/javascript">
                                                    $(document).ready(function() {
                                                        toastr.options.timeOut = 4500; // 1.5s
                                                        toastr.info('user Insert Successfully!!!');
                                                        setTimeout(function()
                                                        {
                                                            window.location.href="application-users.php";
                                                        },1500);
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
            function show_pass(ele){ 
                var ele_class= $(ele).attr('class');
                if(ele_class == 'ft-eye'){
                    $("#eye-pos").removeClass('ft-eye');
                    $("#eye-pos").addClass('ft-eye-off');
                    $("#password").prop("type","password");

                }else if(ele_class == 'ft-eye-off'){
                    $("#eye-pos").removeClass('ft-eye-off');
                    $("#eye-pos").addClass('ft-eye');
                    $("#password").prop("type","text");
                }
            }
        </script>
        <style>
            #eye-pos{
                float: right;
                position: relative;
                bottom: 26px;
                right: 10px;
                color: #868d8d;
            }
        </style>
    </body>
</html>