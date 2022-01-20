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
								
                                                

                                                <div class="form-group">
                                                    <label for="cname">Old Password</label>
                                                    <input type="password" id="cemail" class="form-control"  name="old_password" required >
                                                </div>
                                                <div class="form-group">
                                                    <label for="cname">New Password</label>
                                                    <input type="password" id="mob" class="form-control"  name="new_password" required >
                                                </div>
                                                
							                </div>

                                            <div class="form-actions">
                                                
                                                <button type="submit" name="sub_cat" class="btn btn-raised btn-raised btn-primary">
                                                    <i class="fa fa-check-square-o"></i> Update Password
                                                </button>
                                            </div>
							
                                            <?php 
                                            if(isset($_POST['sub_cat'])){
                                                
                                                $old_password = $_POST['old_password'];
                                                $new_password = $_POST['new_password'];
                                               

                                                $check_pass = $con->query('select admin.* from admin where `password`="'.$old_password.'" and id ='.$admin_id)->fetch_assoc();
                                                
                                                if(!empty($check_pass)){
                                                    $con->query("update admin set password='".$new_password."' where id=".$admin_id);
                                                }else{
                                                    $con->rollback();
                                                    echo "<script>alert('Password not match');</script>";
                                                    exit();
                                                }
                                                

                                            ?>
                                                                    
                                            <script type="text/javascript">
                                            $(document).ready(function() {
                                                toastr.options.timeOut = 4500; // 1.5s
                                                toastr.info('Password Update Successfully!!!');
                                                setTimeout(function()
                                                {
                                                    window.location.href="admin-user-password.php";
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