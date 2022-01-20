  <?php 
  require 'include/header.php';
  ?>
  <body data-col="2-columns" class=" 2-columns ">
    <div class="layer"></div>
      <!-- ////////////////////////////////////////////////////////////////////////////-->
      <div class="wrapper">


      <!-- main menu-->
      <!--.main-menu(class="#{menuColor} #{menuOpenType}", class=(menuShadow == true ? 'menu-shadow' : ''))-->
      <?php include('main.php');
        if($username != 'admin' && $check_menu_customer['view_g'] !=1 && $check_menu_customer['view_o'] !=1 ){
      ?>
        <script>
            window.location.href="404.php";
        </script>
      <?php			
      }?>
        <!-- Navbar (Header) Ends-->
        <div class="main-panel">
          <div class="main-content">
            <div class="content-wrapper"><!--Statistics cards Starts-->

              <section id="dom">
                  <div class="row">
                    <div class="col-12">
                        <div class="card">
                        <?php
                          if(isset($_GET['a_bal']))
                          {
                        ?>
                          <div class="card-header">
                            <h4 class="card-title">Add Wallet Balance To Selected User</h4>
                          </div>
                          <div class="card-body collapse show">
                            <div class="card-block card-dashboard">
                              <form class="form" method="post" enctype="multipart/form-data">
                                <div class="form-body">
                                                  
                                  <div class="form-group">
                                    <label for="cname">Wallet Amount</label>
                                    <input type="number" step="any" name="wal_bal" onkeypress="return isNumberKey(event)" class="form-control" required/>
                                  </div>
            
                                  <div class="form-actions">
            
                                    <button type="submit" name="add_balance" class="btn btn-raised btn-raised btn-primary">
                                      <i class="fa fa-check-square-o"></i> Add Balance
                                    </button>
                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>
                          <?php 
                          if(isset($_POST['add_balance']))
                          {
                            
                            
                            $id = $_GET['a_bal'];
          
                            $wallet = $_POST['wal_bal'];
                          
                            $con->query("update user set wallet=wallet + ".$wallet." where id=".$id."");

                            
                          ?>
                            <script type="text/javascript">
                              $(document).ready(function() {
                                toastr.options.timeOut = 4500; // 1.5s
                                toastr.info('Add Balance Successfully!!!');
                                window.location.href="user.php";
                              
                              });
                            </script>

                          <?php 
                          }
                        }
                      else 
                      {	
                      ?>
                
                      <div class="card-header">
                        <div class="row">
                          <div class="col-md-11">
                              <h4 class="card-title">User List</h4>
                          </div>
                          <div class="col-md-1">
                              <a href="export/customer_list.php?export=1"><button type="button" class="btn btn-outline-github btn-sm">Export</button></a>
                          </div>
                        </div>
                      </div>
              
                      <div class="card-body collapse show">
                          <div class="card-block card-dashboard">
                            
                              <table class="table table-striped table-bordered dom-jQuery-events">
                                  <thead>
                                      <tr>
                                          <th>Sr No.</th>
                                          <th>Name</th>
                                          <th>Email</th>
                                          <th>Country Code</th>
                                          <th>Mobile</th>
                                          <th>password</th>
                                          <th>Current_Status</th>
                                          <th>Wallet Balance</th>
                                          <th>Status</th>
                                          <th>Action</th>

                                      </tr>
                                  </thead>
                                  <tbody>
                                    <?php 
                                    if($username == 'admin' || $check_menu_customer['view_g'] ==1){
                                      $sel = $con->query("select * from user order by id desc");
                                    }else{
                                        $sel = $con->query("select * from user where created_by =".$admin_id." order by id desc");
                                    }
                                    
                                    $i=0;
                                    while($row = $sel->fetch_assoc())
                                    {
                                        $i= $i + 1;
                                    ?>
                                    <tr>
                                  
                                      <td><?php echo $i; ?></td>
                                      <td><?php echo $row['name'];?></td>
                                      <td><?php echo $row['email'];?></td>
                                      <td><?php echo $row['ccode'];?></td>
                                      <td><?php echo $row['mobile'];?></td>
                                      <td><?php echo $row['password'];?></td>
                                      <td><?php if($row['status'] == 1){echo 'Active';}else{echo 'Deactive';}?></td>
                                      <td><?php echo $row['wallet'];?></td>
                                      <td>
                                      
                                      <?php if($username == 'admin'|| $check_menu_customer['delete'] ==1){
                                        if($row['status'] == 1) {?>
                                      <a href="?status=0&sid=<?php echo $row['id'];?>"><button class="btn btn-sm btn-danger"> Make Deactive</button></a>
                                      <?php }else {?>
                                      <button class="btn  btn-sm btn-success" data-id="<?php echo $row['id'];?>" onclick="otp_modal(this)" > Make Active</button>
                                      <?php }} ?>
                                      </td>
                
                                      <td>
                                        <?php  if($username == 'admin'|| $check_menu_customer['delete'] ==1){ ?>   

                                          <a class="danger" href="?dele=<?php echo $row['id'];?>" data-original-title="" title="">
                                              <i class="ft-trash font-medium-3"></i>
                                          </a>
                                          <?php } ?> &nbsp;&nbsp;
                                          <a class="info" href="address.php?uid=<?php echo $row['id'];?>" data-original-title="" title="">
                                            <i class="fa fa-map-marker font-medium-3"></i>
                                          </a>
                  
                                          <!-- <a class="btn btn-success" href="?a_bal=<?php echo $row['id'];?>" data-original-title="" title="">
                                          Add Balance
                                          </a> -->
                                        </td>
                                  
                                    </tr>
                                  <?php } ?>
                                </tbody>
                          
                              </table>
                      
                            </div>
                  
                          </div>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
              </section>
              <?php 
              if(isset($_GET['status']))
              {
                $status = $_GET['status'];
                $id = $_GET['sid'];

                $con->query("update user set status=".$status." where id=".$id."");  
              ?>
                    <script type="text/javascript">
                    $(document).ready(function() {
                      toastr.options.timeOut = 4500; // 1.5s

                      toastr.info('User Status Update Successfully!!');
                    setTimeout(function()
                    {
                      window.location.href="user.php";
                    },1500);
                      
                    });
                    </script>
              <?php
              }
              if(isset($_GET['dele']))
              {
              $con->query("delete from user where id=".$_GET['dele']."");
              ?>
                    <script type="text/javascript">
                    $(document).ready(function() {
                      toastr.options.timeOut = 4500; // 1.5s

                      toastr.error('selected user deleted successfully.');
                      setTimeout(function()
                    {
                      window.location.href="user.php";
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
      <div id="otpModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              
            </div>
            <div class="modal-body ">
                <form action="#">
                    <div class="form-body">
                      
                      <div class="form-group">
                          <label for="active_otp">Enter OTP</label>
                          <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="6" id="active_otp" class="form-control"  name="active_otp" required >
                      </div>
                      <input type="hidden" value='' name="hidd_cust_id" id="hidd_cust_id">
                    </div>

                    <div class="form-actions">
                        <button type="button" name="resend_otp" id="resend_otp" class="btn btn-raised btn-raised btn-primary">
                            <i class="fa fa-check-square-o"></i> Resend OTP
                        </button>
                        <button type="button" name="submit_otp" id="submit_otp" class="btn btn-raised btn-raised btn-primary" >
                            <i class="fa fa-check-square-o"></i> Submit
                        </button>
                    </div> 
                </form>
            </div>
          
          </div>

        </div>
      </div>
      <?php 
      require 'include/js.php';
      ?>
      <SCRIPT>
        <!--
        function isNumberKey(evt)
        {
          var charCode = (evt.which) ? evt.which : event.keyCode
          if (charCode > 31 && (charCode < 48 || charCode > 57))
              return false;

          return true;
        }

        function otp_modal(i){
          $("#otpModal").modal('show');
          var cust_id = $(i).attr('data-id');
          $("#hidd_cust_id").val(cust_id);
          $('.modal-backdrop').removeClass('modal-backdrop')
          send_otp(cust_id);
        }

        $("#resend_otp").click(function(){
            var cust_id = $("#hidd_cust_id").val();
            send_otp(cust_id);
        });

        function send_otp(customer_id){
          
          var cust_id = customer_id;
            $.ajax({
                url:'Ajax/ajaxfile.php',
                Type:'GET',
                dataType:'Json',
                data:{"send_otp":"send_otp","cust_id":cust_id},
                success:function(response){
                  if(response.status == 'success'){
                    toastr.options.timeOut = 4500; // 1.5s
                    toastr.info('OTP SENT!!');
                  }else{
                    toastr.options.timeOut = 4500; // 1.5s
                    toastr.info(response.mesg);
                  }
                },  
                error:function(err){
                  console.log("Error Found",err);
                  
                }
            });
        }

        $("#submit_otp").click(function(){
          
          
          var cust_id = $("#hidd_cust_id").val();
          var otp = $("#active_otp").val();
          if(otp == '' || otp.length != 6){
            alert('Please Enter OTP of 6 digits');
            return false;
          }
          $.ajax({
              url:'Ajax/ajaxfile.php',
              Type:'GET',
              dataType:'Json',
              data:{"submit_otp":"submit_otp","cust_id":cust_id,"otp":otp},
              success:function(response){
                if(response.status == 'success'){
                  toastr.options.timeOut = 4500; // 1.5s
                  toastr.info(response.msg);
                  setTimeout(function()
                  {
                    window.location.href="user.php";
                  },1500);

                }else{
                  toastr.options.timeOut = 4500; // 1.5s
                  toastr.info(response.msg);
                }
              },  
              error:function(err){
                console.log("Error Found",err);
                
              }
          });
        });
        //-->

      </SCRIPT>
      <style>
          table
          {
              font-size:13px;
          }
          
      </style>
        <!-- END PAGE LEVEL JS-->
  </body>


</html>