<?php 
    require 'include/header.php';
?>
<body data-col="2-columns" class=" 2-columns ">
    <div class="layer"></div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="wrapper">


      <!-- main menu-->
      <!--.main-menu(class="#{menuColor} #{menuOpenType}", class=(menuShadow == true ? 'menu-shadow' : ''))-->
      <?php include('main.php'); ?>
      <!-- Navbar (Header) Ends-->

        <div class="main-panel">
            <div class="main-content">
                <div class="content-wrapper"><!--Statistics cards Starts-->
 
		            <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form">Update Profile</h4>
                                    
                                </div>
				                <div class="card-body">
                                    <div class="px-3">
                                        <form class="form" method="post" enctype="multipart/form-data">
                                            <div class="form-body">
								
                                                <?php 
                                                    $getkey = $con->query("select admin.*,role.role_name from admin left join role on role.id = admin.user_role where admin.id=".$admin_id)->fetch_assoc();
                                                ?>

                                                <div class="form-group">
                                                    <label for="cname">Email</label>
                                                    <input type="email" id="cemail" class="form-control"  name="email" value="<?php echo $getkey['email'];?>" required >
                                                </div>
                                                <div class="form-group">
                                                    <label for="cname">Mobile</label>
                                                    <input type="text" id="mob" class="form-control"  name="mobile" value="<?php echo $getkey['mobile'];?>" required >
                                                </div>
                                                <div class="form-group">
                                                    <label for="cname">Username</label>
                                                    <input type="text" id="username" class="form-control"  name="username" value="<?php echo $getkey['username'];?>" required >
                                                </div>
                                                <div class="form-group">
                                                    <label for="cname">User Role</label>
                                                    <input type="text" id="cpass" class="form-control"  name="role_name" value="<?php echo $getkey['role_name'];?>" disabled >
                                                </div>

                                                <div class="form-group">
                                                    <label for="cname">Area</label>
                                                    <select id="area" class="form-control select2" name="area" required>
                                                        <option value="" disabled>Select area</option>
                                                        <?php
                                                        
                                                            $areas = $con->query("select * from area_db where status = 1")->fetch_all(MYSQLI_ASSOC);

                                                            foreach($areas as $ind => $area){
                                                                $selected = '';
                                                                if($area['id']==$getkey['area_id']){
                                                                    $selected='selected';
                                                                }
                                                        ?>
                                                        <option value="<?php echo $area['id']; ?>" <?php echo $selected; ?> ><?php echo $area['name']; ?></option>
                                                        <?php        
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="shop_name">Shop Name</label>
                                                    <input type="text" id="shop_name" class="form-control" value="<?php echo $getkey['shop_name']; ?>"  name="shop_name" required >
                                                </div>
                                                <div class="form-group">
                                                    <label for="shop_name">Contact Person</label>
                                                    <input type="text" id="contact_name" class="form-control" value="<?php echo $getkey['contact_person']; ?>"  name="contact_name" required >
                                                </div>
                                                <div class="form-group">
                                                    <label for="shop_name">Contact Person</label>
                                                    <textarea class="form-control" name="shop_address" id="shop_address" required><?php echo $getkey['shop_address']; ?></textarea> 
                                                </div>
							                </div>

                                            <div class="form-actions">
                                                
                                                <button type="submit" name="sub_cat" class="btn btn-raised btn-raised btn-primary">
                                                    <i class="fa fa-check-square-o"></i> Update Profile
                                                </button>
                                            </div>
							
                                            <?php 
                                            if(isset($_POST['sub_cat'])){
                                                
                                                $username = $_POST['username'];
                                                $email = $_POST['email'];
                                                $mobile = $_POST['mobile'];
                                                $area = $_POST['area'];
                                                $shop_name = $_POST['shop_name'];
                                                $shop_address = $_POST['shop_address'];
                                                $contact_name = $_POST['contact_name'];

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

                                                $con->query("update admin set username='".$username."',email='".$email."',mobile='".$mobile."',area_id='".$area."',shop_name='".$shop_name."',shop_address='".$shop_address."' where id=".$admin_id);

                                            ?>
                                                                    
                                            <script type="text/javascript">
                                            $(document).ready(function() {
                                                toastr.options.timeOut = 4500; // 1.5s
                                                toastr.info('Profile Update Successfully!!!');
                                                setTimeout(function()
                                                        {
                                                            window.location.href="admin-user-profile.php";
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
                </div>
            </div>
        </div>
    </div>
   
    <?php 
        require 'include/js.php';
    ?>
    <!-- select2 -->
	<link rel="stylesheet" href="app-assets/js/select2/css/select2.min.css">
    <link rel="stylesheet" href="app-assets/js/select2-bootstrap4-theme/select2-bootstrap4.min.css">
     
	<!-- select2 script -->
	<script src="app-assets/js/select2/js/select2.full.min.js"></script>
	<script>
        $('.select2').select2();
    </script>
</body>


</html>