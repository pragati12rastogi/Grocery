<?php
if(!empty($_SESSION['username']))
{
    $admin_id = $_SESSION['ADMIN_ID'];
    $role = $con->query('SELECT * FROM `admin` WHERE id='.$admin_id)->fetch_assoc();
    $role_id =$role['user_role'];
    
    $username = $_SESSION['username'];
    if(!empty($role_id)){
      $check_menu = $con->query('Select sidemenu_permission.*, sidemenu.menu_name from sidemenu_permission left join sidemenu on sidemenu.id= sidemenu_permission.side_menu_id where role_id ='.$role_id)->fetch_all(MYSQLI_ASSOC);
    }else{
      $check_menu = $con->query('Select sidemenu.*, sidemenu.menu_name from sidemenu LIMIT 1')->fetch_all(MYSQLI_ASSOC);
      
    }
    
}
else 
{
?>
<script>
    window.location.href="/";
</script>
<?php 
} 
?>

<div data-active-color="white" data-background-color="purple-bliss" data-image="" class="app-sidebar">
        <!-- main menu header-->
        <!-- Sidebar Header starts-->
        <div class="sidebar-header">
          <div class="logo clearfix"><a href="dashboard.php" class="logo-text float-left">
              <div class="logo-img"><img src="<?php echo $fset['logo'];?>" style="width:100%;"/></div><span class="text align-middle" style="font-size: 16px;
    padding: 7px;"></span></a><a id="sidebarToggle" href="javascript:;" class="nav-toggle d-none d-sm-none d-md-none d-lg-block"><i data-toggle="expanded" class="toggle-icon ft-toggle-right"></i></a><a id="sidebarClose" href="javascript:;" class="nav-close d-block d-md-block d-lg-none d-xl-none"><i class="ft-x"></i></a></div>
        </div>
        <!-- Sidebar Header Ends-->
        <!-- / main menu header-->
        <!-- main menu content-->
        <div class="sidebar-content">
          <div class="nav-container">
            <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">

              <?php
               foreach($check_menu as $ind => $menu_allot){
                
                if($username == 'admin' || ($menu_allot['menu_name'] == 'Dashboard')){
              ?>
              <li>
                <a href="dashboard.php"><i class="ft-airplay"></i><span data-i18n="" class="menu-title">Dashboard</span></a>
              </li>
              <?php    
                }
                if($username == 'admin' || ($menu_allot['menu_name'] == 'Unit Master')){
              ?>
              
              <li class="has-sub nav-item"><a href="#"><i class="ft-list"></i><span data-i18n="" class="menu-title">Unit Master</span></a>
                <ul class="menu-content">
                  <?php    
                    if($username == 'admin' || $menu_allot['create']== 1){
                  ?>
                  <li><a href="unit.php" class="menu-item active">Add Unit</a></li>
                  <?php    
                    }
                    if($username == 'admin'|| $menu_allot['view_o'] || $menu_allot['view_g']){
                  ?>
                  <li><a href="unitlist.php" class="menu-item">Unit List</a></li>
                  <?php    
                    }
                  ?>
                </ul>
              </li>

              <?php    
                }
                if($username == 'admin' || ($menu_allot['menu_name'] == 'Category')){
              ?>
              <li class="has-sub nav-item"><a href="#"><i class="ft-list"></i><span data-i18n="" class="menu-title">Category</span></a>
                <ul class="menu-content">
                  <?php    
                    if($username == 'admin' || $menu_allot['create']){
                  ?>
                  <li><a href="category.php" class="menu-item active">Add category</a></li>
                  <?php    
                    }
                    if($username == 'admin'|| $menu_allot['view_o'] || $menu_allot['view_g']){
                  ?>
                  <li><a href="categorylist.php" class="menu-item">Category List</a></li>
                  <?php    
                    }
                  ?>
                </ul>
              </li>
              <?php    
                }
                if($username == 'admin' || ($menu_allot['menu_name'] == 'Sub Category')){
              ?>
              <li class="has-sub nav-item"><a href="#"><i class="ft-list"></i><span data-i18n="" class="menu-title">Sub Category</span></a>
                <ul class="menu-content">
                  <?php    
                    if($username == 'admin' || $menu_allot['create']){
                  ?>
                  <li><a href="subcategory.php" class="menu-item active">Add Subcategory</a></li>
                  <?php    
                    }
                    if($username == 'admin'|| $menu_allot['view_o'] || $menu_allot['view_g']){
                  ?>
                  <li><a href="subcategorylist.php" class="menu-item">Sub Category List</a></li>
                  <?php    
                    }
                  ?>
                </ul>
              </li>
              <?php    
                }
                if($username == 'admin' || ($menu_allot['menu_name'] == 'Product')){
              ?>
              <li><a href="productlist.php"><i class="ft-package"></i><span data-i18n="" class="menu-title">Product List</span></a></li>
              <!-- <li class="has-sub nav-item"><a href="#"><i class="ft-package"></i><span data-i18n="" class="menu-title">Product</span></a>
                <ul class="menu-content">
                  
                    <li><a href="product.php" class="menu-item">Add Product</a></li>
                    <li><a href="import.php" class="menu-item">Import Product</a></li>
                  <?php    
                    
                    if($username == 'admin'|| $menu_allot['view_o'] || $menu_allot['view_g']){
                  ?>
                    <li><a href="productlist.php" class="menu-item">Product List</a></li>
                  <?php    
                    }
                  ?>
                </ul>
              </li> -->
              <?php    
                }
                if($username == 'admin' || ($menu_allot['menu_name'] == 'Stock Management')){
              ?>
              <li class="has-sub nav-item"><a href="#"><i class="ft-package"></i><span data-i18n="" class="menu-title">Stock Management</span></a>
                <ul class="menu-content">
                  <?php    
                    if($username == 'admin' || $menu_allot['create']){
                  ?>
                  <li><a href="stock.php" class="menu-item">Add Stock</a></li>
                  <li><a href="stock-import.php" class="menu-item">Import Stock</a></li>
                  <?php    
                    }
                    if($username == 'admin'|| $menu_allot['view_o'] || $menu_allot['view_g']){
                  ?>
                  <li><a href="stocklist.php" class="menu-item">Stock List</a></li>
                  <?php } ?>
                </ul>
              </li>
              <?php    
                }
                if($username == 'admin' || ($menu_allot['menu_name'] == 'Coupon')){
              ?>
              <li class="has-sub nav-item"><a href="#"><i class="fa fa-gift"></i><span data-i18n="" class="menu-title">Coupon</span></a>
                <ul class="menu-content">
                  <?php    
                    if($username == 'admin' || $menu_allot['create']){
                  ?>
                  <li><a href="coupon.php" class="menu-item">Add Coupon</a></li>
                  <?php    
                    }
                    if($username == 'admin'|| $menu_allot['view_o'] || $menu_allot['view_g']){
                  ?>
                  <li><a href="couponlist.php" class="menu-item">Coupon List</a></li>
                  <?php } ?>
                </ul>  
              </li>
              <?php    
                }
                if($username == 'admin' || ($menu_allot['menu_name'] == 'Area')){
              ?>
              <li class="has-sub nav-item"><a href="#"><i class="ft-compass"></i><span data-i18n="" class="menu-title">Area</span></a>
                <ul class="menu-content">
                  <?php    
                    if($username == 'admin' || $menu_allot['create']){
                  ?>
                  <li><a href="area.php" class="menu-item">Add Area</a></li>
                  <?php    
                    }
                    if($username == 'admin'|| $menu_allot['view_o'] || $menu_allot['view_g']){
                  ?>
                  <li><a href="alist.php" class="menu-item">Area List</a></li>
                  <?php } ?>
                </ul>
              </li>
              <?php    
                }
                if($username == 'admin' || ($menu_allot['menu_name'] == 'Timeslot')){
              ?>
        
              <li class="has-sub nav-item"><a href="#"><i class="ft-clock"></i><span data-i18n="" class="menu-title">Timeslot</span></a>
                <ul class="menu-content">
                  <?php    
                    if($username == 'admin' || $menu_allot['create']){
                  ?>
                  <li><a href="timesloat.php" class="menu-item">Add Timeslot</a></li>
                  <?php    
                    }
                    if($username == 'admin'|| $menu_allot['view_o'] || $menu_allot['view_g']){
                  ?>
                  <li><a href="tlist.php" class="menu-item">Timeslot List</a></li>         
                  <?php } ?>
                </ul>
              </li>

              <?php    
                }
                if($username == 'admin' || ($menu_allot['menu_name'] == 'Agents')){
              ?>
              <li class="has-sub nav-item"><a href="#"><i class="fa fa-user"></i><span data-i18n="" class="menu-title">Agents</span></a>
                <ul class="menu-content">
                  <?php    
                    if($username == 'admin' || $menu_allot['create']){
                  ?>
                  <li><a href="add_agent.php" class="menu-item active">Add Agent</a>
                  </li>
                  <?php    
                    }
                    if($username == 'admin'|| $menu_allot['view_o'] || $menu_allot['view_g']){
                  ?>
                  <li><a href="agentslist.php" class="menu-item">Agent List</a>
                  </li>
                  <?php } ?>
                </ul>
              </li>
              <?php    
                }
                if($username == 'admin' || ($menu_allot['menu_name'] == 'Delivery Boy')){
              ?>
        
              <li class="has-sub nav-item"><a href="#"><i class="fa fa-motorcycle"></i><span data-i18n="" class="menu-title">Delivery Boy</span></a>
                <ul class="menu-content">
                  <?php    
                    if($username == 'admin' || $menu_allot['create']){
                  ?>
                  <li><a href="add_rider.php" class="menu-item active">Add Delivery Boy</a></li>
                  <?php    
                    }
                    if($username == 'admin'|| $menu_allot['view_o'] || $menu_allot['view_g']){
                  ?>
                  <li><a href="riderlist.php" class="menu-item">Delivery Boy List</a></li>
                  <?php } ?>
                </ul>
              </li>
              <?php    
                }
                if($username == 'admin' || ($menu_allot['menu_name'] == 'Banner')){
              ?>
			        
              <li class="has-sub nav-item"><a href="#"><i class="ft-image"></i><span data-i18n="" class="menu-title">Banner</span></a>
                <ul class="menu-content">
                  <?php    
                    if($username == 'admin' || $menu_allot['create']){
                  ?>
                  <li><a href="banner.php" class="menu-item">Add Banner</a></li>
                  <?php    
                    }
                    if($username == 'admin'|| $menu_allot['view_o'] || $menu_allot['view_g']){
                  ?>
                  <li><a href="bannerlist.php" class="menu-item">Banner List</a></li>
                  <?php } ?>
                </ul>
              </li>
              
              <?php    
                }
                if($username == 'admin' || ($menu_allot['menu_name'] == 'Home Section')){
              ?>
              <li class="has-sub nav-item"><a href="#"><i class="ft-copy"></i><span data-i18n="" class="menu-title">Home Section</span></a>
                <ul class="menu-content">
                  <?php    
                    if($username == 'admin' || $menu_allot['create']){
                  ?>
                  <li><a href="home_section.php" class="menu-item">Add Section</a>
                  </li>
                  <?php    
                    }
                    if($username == 'admin'|| $menu_allot['view_o'] || $menu_allot['view_g']){
                  ?>
                  <li><a href="home_section_list.php" class="menu-item">Section List</a>
                  </li>
                  <?php } ?>
                </ul>
              </li>
              <?php    
                }
                if($username == 'admin' || ($menu_allot['menu_name'] == 'Notification')){
              ?>
              <li class="has-sub nav-item"><a href="#"><i class="ft-bell"></i><span data-i18n="" class="menu-title">Notification</span></a>
                <ul class="menu-content">
                  <?php    
                    if($username == 'admin' || $menu_allot['create']){
                  ?>
                  <li><a href="template.php" class="menu-item">Add Notification</a>
                  </li>
                  <?php    
                    }
                    if($username == 'admin'|| $menu_allot['view_o'] || $menu_allot['view_g']){
                  ?>
                  <li><a href="templatelist.php" class="menu-item">Notification List</a>
                  </li>
                  <?php } ?>
                </ul>
              </li>
              <?php    
                }
                if($username == 'admin' || ($menu_allot['menu_name'] == 'Orders')){
              ?>
              <li><a href="order.php"><i class="ft-shopping-cart"></i><span data-i18n="" class="menu-title">Orders</span></a></li>
              <?php    
                }
                if($username == 'admin' || ($menu_allot['menu_name'] == 'Customer Section')){
              ?>
			  
			        <li class="has-sub nav-item"><a href="#"><i class="ft-users"></i><span data-i18n="" class="menu-title">Customer Section</span></a>
                <ul class="menu-content">
                  <?php    
                    
                    if($username == 'admin'|| $menu_allot['view_o'] || $menu_allot['view_g']){
                  ?>
                  <li><a href="user.php" class="menu-item">Customer</a>
                  </li>
                  <li><a href="orderrate.php" class="menu-item">Customer Rating</a>
                  </li>
                  <li><a href="feed.php" class="menu-item">Feedback</a>
                  </li>
                  <?php } ?>
                </ul>
              </li>
              <?php    
                }
                if($username == 'admin' || ($menu_allot['menu_name'] == 'Country Code')){
              ?>
              <li class="has-sub nav-item"><a href="#"><i class="fa fa-flag"></i><span data-i18n="" class="menu-title"> Country Code</span></a>
                <ul class="menu-content">
                  <?php    
                    if($username == 'admin' || $menu_allot['create']){
                  ?>
                  <li><a href="code.php" class="menu-item active"> Add Country Code</a>
                  </li>
                  <?php    
                    }
                    if($username == 'admin'|| $menu_allot['view_o'] || $menu_allot['view_g']){
                  ?>
                  <li><a href="clist.php" class="menu-item"> Country Code List</a>
                  </li>
                  <?php } ?>
                </ul>
              </li>
              <?php    
                }
                if($username == 'admin' || ( $menu_allot['menu_name'] == 'Users Management')){
              ?>
              <li class="has-sub nav-item"><a href="#"><i class="ft-users"></i><span data-i18n="" class="menu-title">Users Management</span></a>
                <ul class="menu-content">
                  <?php    
                    if($username == 'admin' || $menu_allot['create']){
                  ?>
                  <li><a href="application-users.php" class="menu-item active"> Add User</a>
                  </li>
                  <?php    
                    }
                    if($username == 'admin'|| $menu_allot['view_o'] || $menu_allot['view_g']){
                  ?>
                  <li><a href="userslist.php" class="menu-item">Users List </a>
                  </li>
                  <?php } ?>
                </ul>
              </li> 
              <?php    
                }
                if($username == 'admin' || ( $menu_allot['menu_name'] == 'Billing')){
              ?>
              <li><a href="billing.php"><i class="fa fa-calculator"></i><span data-i18n="" class="menu-title">Billing</span></a></li>
              <?php    
                }
                if($username == 'admin' || ( $menu_allot['menu_name'] == 'Payment List')){
              ?>
			        <li><a href="payment_list.php"><i class="fa fa-money"></i><span data-i18n="" class="menu-title">Payment List</span></a></li>
              <?php    
                }
                if($username == 'admin' ){
              ?>
			        <li><a href="profile.php"><i class="ft-user"></i><span data-i18n="" class="menu-title">Profile</span></a></li>
              <?php    
                }
                if($username == 'admin' ){
              ?>
              <li><a href="setting.php"><i class="ft-settings"></i><span data-i18n="" class="menu-title">Settings</span></a></li>
              <?php    
                }
                if($username == 'admin' ){
              ?>
              <li><a href="role.php"><i class="ft-check-circle"></i><span data-i18n="" class="menu-title">Role</span></a> </li>
              <?php    
                }
              }
              ?>
            </ul>
          </div>
        </div>
        <!-- main menu content-->
        <div class="sidebar-background"></div>
        <!-- main menu footer-->
        <!-- include includes/menu-footer-->
        <!-- main menu footer-->
      </div>
      <!-- / main menu-->
      <script src="app-assets/vendors/js/core/jquery-3.2.1.min.js" type="text/javascript"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

      <!-- Navbar (Header) Starts-->
      <nav class="navbar navbar-expand-lg navbar-light bg-faded header-navbar">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" data-toggle="collapse" class="navbar-toggle d-lg-none float-left"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><span class="d-lg-none navbar-right navbar-collapse-toggle"><a aria-controls="navbarSupportedContent" href="javascript:;" class="open-navbar-container black"><i class="ft-more-vertical"></i></a></span>
            
          </div>
          <div class="navbar-container">
            <div id="navbarSupportedContent" class="collapse navbar-collapse">
              <ul class="navbar-nav">
                <li class="nav-item mr-2 d-none d-lg-block"><a id="navbar-fullscreen" href="javascript:;" class="nav-link apptogglefullscreen"><i class="ft-maximize font-medium-3 blue-grey darken-4"></i>
                    <p class="d-none">fullscreen</p></a></li>

               
                <li class="dropdown nav-item"><a href="javascript:void(0)" data-target="#dropdown_logout" data-toggle="collapse" class="nav-link position-relative dropdown-toggle"><i class="ft-user font-medium-3 blue-grey darken-4"></i>
                    <p class="d-none">User Settings</p></a>
                </li>
                  
                <div  id="dropdown_logout" class="dropdown-menu text-left dropdown-menu-right">
                  <?php if($username != 'admin' ){ ?>
                  <a href="admin-user-profile.php" class="dropdown-item"><i class="ft-user mr-2"></i><span>Profile Update</span></a>
                  <a href="admin-user-password.php" class="dropdown-item"><i class="ft-alert-octagon mr-2"></i><span>Password Update</span></a>
                  <?php } ?>
                  <a href="logout.php" class="dropdown-item"><i class="ft-power mr-2"></i><span>Logout</span></a>
                  
                </div>
                  
              </ul>
            </div>
          </div>
        </div>
      </nav>
      <?php include('check_specific_menu.php'); ?>