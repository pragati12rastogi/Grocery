<?php 
  require 'include/header.php';
  ?>
  <body data-col="2-columns" class=" 2-columns ">
       <div class="layer"></div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="wrapper">


      <!-- main menu-->
      <!--.main-menu(class="#{menuColor} #{menuOpenType}", class=(menuShadow == true ? 'menu-shadow' : ''))-->
      <?php  
          include('main.php');
          if($username != 'admin' && $check_menu_stock['view_g'] !=1 && $check_menu_stock['view_o'] !=1){?>
          <script>
            window.location.href="404.php";
          </script>
      <?php	}
      ?>
      <!-- Navbar (Header) Ends-->
      
      <div class="main-panel" >
        
        
        <div class="main-content" >
          <div class="content-wrapper"><!--Statistics cards Starts-->
            <div class="tab">
              <button id="current" type="button" class="btn btn-bitbucket">Current Stock</button>
              <button id="sold" type="button" class="btn btn-outline-bitbucket">Sold Stock</button>
              <button id="old" type="button" class="btn btn-outline-bitbucket">History</button>
            </div>

            <section id="current_table">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                  <div class="col-md-11">
                                    <h4 class="card-title ml-1">Stock List History</h4>
                                  </div>
                                  <div class="col-md-1">
                                    <a href="export/stock_list.php?export=1"><button type="button" class="btn btn-outline-github btn-sm">Export</button></a>
                                  </div>
                                </div>
                            </div>
                            <div class="card-body collapse show">
                                <div class="card-block card-dashboard">
                                  
                                    <table class="table table-striped table-bordered dom-jQuery-events">
                                        <thead>
                                            <tr>
                                                <th>Sr No.</th>
                                                <th>Product Name</th>                                
                                                
                                                <th>Quantity</th>
                                                <th>Product Price</th>
                                                <th>Selling Price</th>
                                                <th>Total Buying Price</th>
                                                
                                                <th>Unit</th>                                    
                                                <!-- <th>In Stock</th> -->
                                                <th>Status</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            if($username == 'admin' || $check_menu_stock['view_g'] ==1){
                                              $jj = $con->query("select * from inventory_stock order by id desc");
                                            }else{
                                              $jj = $con->query("select * from inventory_stock where created_by =".$admin_id." order by id desc");
                                            }
                                            $i=0;
                                            while($rkl = $jj->fetch_assoc())
                                            {
                                                $i = $i + 1;
                                            ?>
                                            <tr>
                                                <td><?php echo $i;?></td>
                                                <td><?php echo $rkl['product_name'];?></td>                                    
                                                <td><?php echo $rkl['prod_quantity'];?></td> 
                                                <td><?php echo $rkl['prod_price'];?></td>
                                                <td><?php echo $rkl['selling_price_wth_prft'];?></td>
                                                <td><?php echo $rkl['total_buying_price'];?></td>
                                                <td><?php echo $rkl['unit'];?></td>
                                                <td><?php if($rkl['status'] == 1) {echo 'In Stock';}else{echo 'Out Of Stock';} ?></td>                            
                                              <td>
                                                <?php if($username == 'admin'|| $check_menu_stock['edit'] ==1){ ?>

                                                  <a class="primary" href="stock.php?edit=<?php echo $rkl['id'];?>" data-original-title="" title="">
                                                    <i class="ft-edit font-medium-3"></i>
                                                  </a>
                                                <?php } if($username == 'admin'|| $check_menu_stock['delete'] ==1){ ?>   
                                                    
                                                  <a class="danger" data-original-title=""  href="?dele=<?php echo $rkl['id'];?>" title="">
                                                    <i class="ft-trash font-medium-3"></i>
                                                  </a>
                                                <?php } ?>                   
                                                </td>
                                            </tr>
                                          <?php } ?>
                                        </tbody>
                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section id="sold_table">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                  <div class="col-md-11">
                                    <h4 class="card-title">Sold Stock List</h4>
                                  </div>
                                  <div class="col-md-1">
                                    <a href="export/sold_stock_list.php?export=1"><button type="button" class="btn btn-outline-github btn-sm">Export</button></a>
                                  </div>
                                </div>
                                
                            </div>
                            <div class="card-body collapse show">
                                <div class="card-block card-dashboard">
                                  
                                    <table class="table table-striped table-bordered dom-jQuery-events">
                                        <thead>
                                            <tr>
                                                <th>Sr No.</th>
                                                <th>Product Name</th> 
                                                <th>Product Quantity</th>
                                                <th>Product Selling Price</th>
                                                <th>Sold At (Rs.)</th>
                                                <th>Unit</th>                                    
                                                <th>Date</th>                                    
                                                
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            if($username == 'admin' || $check_menu_stock['view_g'] ==1){
                                              $jj = $con->query("select * from inventory_stock_history where status='Sold' order by id desc");
                                            }else{
                                              $jj = $con->query("select * from inventory_stock_history where status='Sold' and created_by =".$admin_id." order by id desc");
                                            }
                                             $i=0;
                                            while($rkl = $jj->fetch_assoc())
                                            {
                                                $i = $i + 1;
                                            ?>
                                            <tr>
                                                <td><?php echo $i;?></td>
                                                <td><?php echo $rkl['product_name'];?></td>                                    
                                                <td><?php echo $rkl['prod_quantity'];?></td> 
                                                <td><?php echo $rkl['selling_price_wth_prft'];?></td>
                                                <td><?php echo $rkl['total_price_with_profit'];?></td>
                                                <td><?php echo $rkl['unit'];?></td>
                                                <td><?php echo date('d-m-Y h:i A',strtotime($rkl['added_on']));?></td>
                                            </tr>
                                          <?php } ?>
                                        </tbody>
                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="old_table">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="row">
                                      <div class="col-md-11">
                                        <h4 class="card-title">Stock List History</h4>
                                      </div>
                                      <div class="col-md-1">
                                        <a href="export/inventory_history.php?export=1"><button type="button" class="btn btn-outline-github btn-sm">Export</button></a>
                                      </div>
                                </div>              
                            </div>
                            <div class="card-body collapse show">
                                <div class="card-block card-dashboard">
                                  
                                    <table class="table table-striped table-bordered dom-jQuery-events">
                                        <thead>
                                            <tr>
                                                <th>Sr No.</th>
                                                <th>Product Name</th> 
                                                <th>Product Quantity</th>
                                                <th>Product Price</th>
                                                <th>Total Buying Price</th>
                                                <th>Unit</th>                                    
                                                <th>Date</th>                                    
                                                <th>Status</th>                                    
                                                
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            if($username == 'admin' || $check_menu_stock['view_g'] ==1){
                                              $jj = $con->query("select * from inventory_stock_history where status IN('Old','Updated') order by id desc");
                                            }else{
                                              $jj = $con->query("select * from inventory_stock_history where status IN('Old','Updated') and created_by =".$admin_id." order by id desc");
                                            }
                                            
                                            $i=0;
                                            while($rkl = $jj->fetch_assoc())
                                            {
                                                $i = $i + 1;
                                            ?>
                                            <tr>
                                                <td><?php echo $i;?></td>
                                                <td><?php echo $rkl['product_name'];?></td>                                    
                                                <td><?php echo $rkl['prod_quantity'];?></td> 
                                                <td><?php echo $rkl['prod_price'];?></td>
                                                <td><?php echo $rkl['total_buying_price'];?></td>
                                                <td><?php echo $rkl['unit'];?></td>
                                                <td><?php echo date('d-m-Y h:i A',strtotime($rkl['added_on']));?></td>
                                                <td><?php echo $rkl['status'];?> Stock</td>
                                                
                                            </tr>
                                          <?php } ?>
                                        </tbody>
                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <?php 
            if(isset($_GET['dele']))
            {
              if($username != 'admin'&& $check_menu_stock['delete'] != 1){
                  header('Location: 404.php'); 
                  die("404 error");
              }
              $con->query("delete from inventory_stock where id=".$_GET['dele']."");
            ?>
              <script type="text/javascript">
              $(document).ready(function() {
                toastr.options.timeOut = 4500; // 1.5s

                toastr.error('selected product deleted successfully.');
                setTimeout(function()
              {
                window.location.href="stocklist.php";
              },1500);
              });
              </script>
              <?php
            }
            ?>

            

          </div>
        </div>
         

      </div>
    </div>
   
    <?php 
    
      require 'include/js.php';
    ?>
    <style>
        table
        {
            font-size:13px;
        }
    </style>
    <script>
      $(document).ready(function(){
          $("#current_table").show();
          $("#sold_table").hide();
          $("#old_table").hide();
          $("#current").addClass("active");
          

          $("#current").click(function(){
            $("#current_table").show();
            $("#current").addClass("active btn-bitbucket");
            $("#current").removeClass("btn-outline-bitbucket");

            $("#sold_table").hide();
            $("#sold").removeClass("active btn-bitbucket");
            $("#sold").addClass("btn-outline-bitbucket");

            $("#old_table").hide();
            $("#old").removeClass("active btn-bitbucket");
            $("#old").addClass("btn-outline-bitbucket");

          });

          $("#sold").click(function(){
            $("#sold_table").show();
            $("#sold").addClass("active btn-bitbucket");
            $("#sold").removeClass("btn-outline-bitbucket");

            $("#current_table").hide();
            $("#current").removeClass("active btn-bitbucket");
            $("#current").addClass("btn-outline-bitbucket");

            $("#old_table").hide();
            $("#old").removeClass("active btn-bitbucket");
            $("#old").addClass("btn-outline-bitbucket");

          });

          $("#old").click(function(){
            $("#old_table").show();
            $("#old").addClass("active btn-bitbucket");
            $("#old").removeClass("btn-outline-bitbucket");

            $("#sold_table").hide();
            $("#sold").removeClass("active btn-bitbucket");
            $("#sold").addClass("btn-outline-bitbucket");
            
            $("#current_table").hide();
            $("#current").removeClass("active btn-bitbucket");
            $("#current").addClass("btn-outline-bitbucket");

          });
      });
    </script>
    <!-- END PAGE LEVEL JS-->
  </body>   

</html>