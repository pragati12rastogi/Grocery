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
					<h4 class="card-title" id="basic-layout-form">Dashboard</h4>
					
				</div>
				<div class="card-body" style="padding:10px;">
				   <div class="row" matchheight="card">
              <?php 
               
              foreach($check_menu as $ind => $menu_allot){   
                
                if($username == 'admin' || (isset($menu_allot) && $menu_allot['menu_name'] == 'Category')){
              ?>
              <div class="col-xl-3 col-lg-6 col-12">
            
                <div class="card">
                  <a href="categorylist.php">
                      <div class="card-content">
                        <div class="px-3 py-3">
                          <div class="media">
                            <div class="media-body text-left">
                              <h3 class="mb-1 danger"><?php 
                                if($username == 'admin'|| $check_category['view_g'] ==1){
                                  $sel = $con->query("select * from category")->num_rows;
                                }else{
                                    $sel = $con->query("select * from category where created_by =".$admin_id)->num_rows;
                                }
                              echo $sel ?></h3>
                              <span>Total Category</span>
                            </div>
                            <div class="media-right align-self-center">
                              <i class="icon-list danger font-large-2 float-right"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                  </a>
                </div>
            
              </div>
              <?php 
                }   
                if($username == 'admin' || (isset($menu_allot) && $menu_allot['menu_name'] == 'Sub Category')){
              ?>
              <div class="col-xl-3 col-lg-6 col-12">
                <div class="card">
                  <a href="subcategorylist.php">
                      <div class="card-content">
                        <div class="px-3 py-3">
                          <div class="media">
                            <div class="media-body text-left">
                              <h3 class="mb-1 danger"><?php 
                                if($username == 'admin' || $check_sub_category['view_g'] ==1){
                                    $sel = $con->query("select * from subcategory");
                                }else{
                                    $sel = $con->query("select * from subcategory where created_by =".$admin_id);
                                }
                                echo $sel->num_rows;?></h3>
                              <span>Total Sub Cat.</span>
                            </div>
                            <div class="media-right align-self-center">
                              <i class="icon-list danger font-large-2 float-right"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                  </a>
                </div>
              </div>
              <?php 
                }   
                if($username == 'admin' || (isset($menu_allot) && $menu_allot['menu_name'] == 'Product')){
              ?>
              <div class="col-xl-3 col-lg-6 col-12">
                <div class="card">
                  <a href="productlist.php">
                      <div class="card-content">
                        <div class="px-3 py-3">
                          <div class="media">
                            <div class="media-body text-left">
                              <h3 class="mb-1 success"><?php 
                                if($username == 'admin' || $check_menu_prod['view_g'] ==1){
                                  $jj = $con->query("select * from product order by id desc");
                                }else{
                                    $jj = $con->query("select * from product where created_by =".$admin_id." order by id desc");
                                }
                                echo $jj->num_rows;?></h3>
                              <span>Total Product</span>
                            </div>
                            <div class="media-right align-self-center">
                              <i class="icon-basket-loaded success font-large-2 float-right"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                  </a>
                </div>
              </div>
              <?php 
                }   
                if($username == 'admin' || (isset($menu_allot) && $menu_allot['menu_name'] == 'Coupon')){
              ?>
              <div class="col-xl-3 col-lg-6 col-12">
                <div class="card">
                  <a href="couponlist.php">
                      <div class="card-content">
                        <div class="px-3 py-3">
                          <div class="media">
                            <div class="media-body text-left">
                              <h3 class="mb-1 success"><?php 
                                if($username == 'admin' || $check_menu_coupon['view_g'] ==1){
                                    $sel = $con->query("select * from tbl_coupon");
                                }else{
                                    $sel = $con->query("select * from tbl_coupon where created_by =".$admin_id);
                                }
                                echo $sel->num_rows;?></h3>
                              <span>Total Coupon</span>
                            </div>
                            <div class="media-right align-self-center">
                              <i class="fa fa-gift success font-large-2 float-right"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                  </a>
                </div>
              </div>
              <?php 
                }   
                if($username == 'admin' || (isset($menu_allot) && $menu_allot['menu_name'] == 'Area')){
              ?>
              <div class="col-xl-3 col-lg-6 col-12">
                <div class="card">
                  <a href="alist.php">
                      <div class="card-content">
                        <div class="px-3 py-3">
                          <div class="media">
                            <div class="media-body text-left">
                              <h3 class="mb-1 warning"><?php 
                              if($username == 'admin' || $check_menu_area['view_g'] ==1){
                                  $sel = $con->query("select * from area_db");
                              }else{
                                  $sel = $con->query("select * from area_db where created_by =".$admin_id);
                              }
                              echo $sel->num_rows;?></h3>
                              <span>Total Area</span>
                            </div>
                            <div class="media-right align-self-center">
                              <i class="icon-pie-chart warning font-large-2 float-right"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                  </a>
                </div>
              </div>
              <?php 
                }   
                if($username == 'admin' || (isset($menu_allot) && $menu_allot['menu_name'] == 'Timeslot')){
              ?>
              <div class="col-xl-3 col-lg-6 col-12">
                <div class="card">
                  <a href="tlist.php">
                      <div class="card-content">
                        <div class="px-3 py-3">
                          <div class="media">
                            <div class="media-body text-left">
                              <h3 class="mb-1 primary"><?php 
                                if($username == 'admin' || $check_menu_timeslot['view_g'] ==1){
                                  $sel = $con->query("select * from timeslot");
                                }else{
                                  $sel = $con->query("select * from timeslot where created_by =".$admin_id);
                                }
                                echo $sel->num_rows;?></h3>
                              <span>Total Timeslot</span>
                            </div>
                            <div class="media-right align-self-center">
                              <i class="icon-hourglass primary font-large-2 float-right"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                  </a>
                </div>
              </div>
              <?php 
                }   
                if($username == 'admin' || (isset($menu_allot) && $menu_allot['menu_name'] == 'Banner')){
              ?>
              <div class="col-xl-3 col-lg-6 col-12">
                <div class="card">
                  <a href="bannerlist.php">
                      <div class="card-content">
                        <div class="px-3 py-3">
                          <div class="media">
                            <div class="media-body text-left">
                              <h3 class="mb-1 primary"><?php 
                                if($username == 'admin' || $check_menu_banner['view_g'] ==1){
                                    $jj = $con->query("select * from banner");
                                }else{
                                    $jj = $con->query("select * from banner where created_by =".$admin_id);
                                }
                                echo $jj->num_rows;?></h3>
                              <span>Total Banner</span>
                            </div>
                            <div class="media-right align-self-center">
                              <i class="icon-screen-desktop primary font-large-2 float-right"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                  </a>
                </div>
              </div>
              <?php 
                }   
                if($username == 'admin' || (isset($menu_allot) && $menu_allot['menu_name'] == 'Customer Section')){
              ?>
              <div class="col-xl-3 col-lg-6 col-12">
                <div class="card">
                  <a href="user.php">
                      <div class="card-content">
                        <div class="px-3 py-3">
                          <div class="media">
                            <div class="media-body text-left">
                              <h3 class="mb-1 success"><?php 
                                if($username == 'admin' || $check_menu_customer['view_g'] ==1){
                                    $sel = $con->query("select * from user order by id desc");
                                }else{
                                    $sel = $con->query("select * from user where created_by =".$admin_id." order by id desc");
                                }
                                echo $sel->num_rows; ?></h3>
                              <span>Total Customer</span>
                            </div>
                            <div class="media-right align-self-center">
                              <i class="icon-user success font-large-2 float-right"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                  </a>
                </div>
              </div>
              <?php 
                }   
                if($username == 'admin' || (isset($menu_allot) && $menu_allot['menu_name'] == 'Orders')){
              ?>
              <div class="col-xl-3 col-lg-6 col-12">
                <div class="card">
                  <a href="order.php">
                      <div class="card-content">
                        <div class="px-3 py-3">
                          <div class="media">
                            <div class="media-body text-left">
                              <h3 class="mb-1 danger"><?php 
                                if($username == 'admin' || $check_menu_order['view_g'] ==1){
                                  $sel = $con->query("select * from orders where status ='Pending' order by id desc");
                                }else{
                                    $sel = $con->query("select * from orders where status ='Pending' and created_by =".$admin_id." order by id desc");
                                }
                                echo $sel->num_rows;?></h3>
                              <span>Pending Order</span>
                            </div>
                            <div class="media-right align-self-center">
                              <i class="icon-handbag danger font-large-2 float-right"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                  </a>
                </div>
              </div>
              
              <div class="col-xl-3 col-lg-6 col-12">
                <div class="card">
                  <a href="orders.php">
                      <div class="card-content">
                        <div class="px-3 py-3">
                          <div class="media">
                            <div class="media-body text-left">
                              <h3 class="mb-1 primary"><?php 
                                if($username == 'admin' || $check_menu_order['view_g'] ==1){
                                  $sel = $con->query("select * from orders where status ='completed' order by id desc");
                                }else{
                                  $sel = $con->query("select * from orders where status ='completed' and created_by =".$admin_id." order by id desc");
                                }
                              echo $sel->num_rows;?></h3>
                              <span>Complete Order</span>
                            </div>
                            <div class="media-right align-self-center">
                              <i class="icon-handbag primary font-large-2 float-right"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                  </a>
                </div>
              </div>
              
              <div class="col-xl-3 col-lg-6 col-12">
                <div class="card">
                  <a href="order.php">
                      <div class="card-content">
                        <div class="px-3 py-3">
                          <div class="media">
                            <div class="media-body text-left">
                              <h3 class="mb-1 warning"><?php 
                                if($username == 'admin' || $check_menu_order['view_g'] ==1){
                                  $sel = $con->query("select * from orders where status ='Cancelled' and order_type ='app' order by id desc");
                                }else{
                                    $sel = $con->query("select * from orders where status ='Cancelled' and order_type ='app' and created_by =".$admin_id." order by id desc");
                                }
                              echo $sel->num_rows;?></h3>
                              <span>Cancelled Order</span>
                            </div>
                            <div class="media-right align-self-center">
                              <i class="icon-handbag warning font-large-2 float-right"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                  </a>
                </div>
              </div>
              <?php 
                }   
                if($username == 'admin' || (isset($menu_allot) && $menu_allot['menu_name'] == 'Customer Section')){
              ?>
              <div class="col-xl-3 col-lg-6 col-12">
            
                <div class="card">
                  <a href="orderrate.php">
                      <div class="card-content">
                        <div class="px-3 py-3">
                          <div class="media">
                            <div class="media-body text-left">
                              <h3 class="mb-1 danger"><?php 
                                  if($username == 'admin' || $check_menu_customer['view_g'] ==1){
                                      $sel = $con->query("select rate_order.* from rate_order order by id desc");
                                  }else{
                                      $sel = $con->query("select rate_order.* from rate_order left join user on user.id=rate_order.uid  where user.created_by =".$admin_id." order by id desc");
                                  }
                                echo $sel->num_rows;?></h3>
                              <span>Customer Rating</span>
                            </div>
                            <div class="media-right align-self-center">
                              <i class="icon-like danger font-large-2 float-right"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                  </a>
                </div>
              
              </div>
              
              <div class="col-xl-3 col-lg-6 col-12">
                <div class="card">
                  <a href="feed.php">
                      <div class="card-content">
                        <div class="px-3 py-3">
                          <div class="media">
                            <div class="media-body text-left">
                              <h3 class="mb-1 primary"><?php
                              if($username == 'admin' || $check_menu_customer['view_g'] ==1){
                                $sel = $con->query("select feedback.* from feedback order by id desc");
                              }else{
                                  $sel = $con->query("select feedback.* from feedback left join user on user.id=feedback.uid  where user.created_by =".$admin_id." order by id desc");
                              }
                              echo $sel->num_rows;?></h3>
                              <span>Total Feedback</span>
                            </div>
                            <div class="media-right align-self-center">
                              <i class="icon-bubbles primary font-large-2 float-right"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                  </a>
                </div>
              </div>
              <?php 
                }   
                if($username == 'admin' || (isset($menu_allot) && $menu_allot['menu_name'] == 'Orders')){
              ?>
              <div class="col-xl-3 col-lg-6 col-12">
                <div class="card">
                  <div class="card-content">
                    <div class="px-3 py-3">
                      <div class="media">
                        <div class="media-body text-left">
                          <h3 class="mb-1 success"><?php 
                          if($username == 'admin' || $check_menu_order['view_g'] ==1){
                            $sales = $con->query("select sum(total) as full_total from orders where status ='completed'")->fetch_assoc();
                          }else{
                            $sales = $con->query("select sum(total) as full_total from orders where status ='completed' and created_by =".$admin_id."")->fetch_assoc();
                          }
                          
                          if($sales['full_total'] == ''){echo 0;}else {echo number_format((float)$sales['full_total'], 2, '.', ''); } ?></h3>
                          <span>Total Sales</span>
                        </div>
                        <div class="media-right align-self-center">
                          <i class="icon-rocket success font-large-2 float-right"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php 
                }   
                if($username == 'admin' || (isset($menu_allot) && $menu_allot['menu_name'] == 'Delivery Boy')){
              ?>
              <div class="col-xl-3 col-lg-6 col-12">
                <div class="card">
                  <a href="riderlist.php">
                      <div class="card-content">
                        <div class="px-3 py-3">
                          <div class="media">
                            <div class="media-body text-left">
                              <h3 class="mb-1 primary"><?php 
                                if($username == 'admin' || $check_menu_dboy['view_g'] ==1){
                                    $jj = $con->query("select * from rider");
                                }else{
                                    $jj = $con->query("select * from rider where created_by =".$admin_id);
                                }
                              echo $jj->num_rows;?></h3>
                              <span>Total Deliv. Boy</span>
                            </div>
                            <div class="media-right align-self-center">
                              <i class="fa fa-motorcycle primary font-large-2 float-right"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                  </a>
                </div>
              </div>
              <?php 
                }  
              } 
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  <style>
    .col-xl-3.col-lg-6.col-12 > .card {
    background: aliceblue;
    }
        
  </style>
  <?php 
  require 'include/js.php';
  ?>
     
</body>


</html>