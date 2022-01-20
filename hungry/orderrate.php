<?php 
  require 'include/header.php';
  ?>
  <body data-col="2-columns" class=" 2-columns ">
       <div class="layer"></div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="wrapper">


    
     <?php include('main.php'); ?>
      <!-- Navbar (Header) Ends-->

      <div class="main-panel">
        <div class="main-content">
          <div class="content-wrapper"><!--Statistics cards Starts-->

<section id="dom">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Order Rate List</h4>
                </div>
                
                <div class="card-body collapse show">
                    <div class="card-block card-dashboard">
                       <ul class="list-group">
                          <li class="list-group-item">
                            <span class="badge bg-primary float-right">1</span> Very Good
                          </li>
                          <li class="list-group-item">
                            <span class="badge bg-info float-right">2</span> Good
                          </li>
                          <li class="list-group-item">
                            <span class="badge bg-warning float-right">3</span> Not Good
                          </li>
                         
                        </ul>
                       
                       <br>
                        <table class="table table-striped table-bordered" id="example">
                            <thead>
                                <tr>
								 <th>Sr No.</th>
                                    <th>Order ID</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Rate Star</th>
                                    <th>Comment</th>
                                    

                                </tr>
                            </thead>
                            <tbody>
                                <?php 

                                if($username == 'admin' || $check_menu_customer['view_g'] ==1){
                                  $sel = $con->query("select rate_order.* from rate_order order by id desc");
                                }else{
                                    $sel = $con->query("select rate_order.* from rate_order left join user on user.id=rate_order.uid  where user.created_by =".$admin_id." order by id desc");
                                }
                                $i=0;
                                while($row = $sel->fetch_assoc())
                                {
                                    $i= $i + 1;
                                ?>
                                <tr>
                                    
                                    <td><?php echo $i; ?></td>
                                    <?php $fetch = $con->query("select * from orders where id=".$row['oid']."")->fetch_assoc();
                                    $fetchs = $con->query("select * from user where id='".$row['uid']."'")->fetch_assoc();
                                    ?>
                                    <td><?php echo $fetch['id'];?></td>
                                    <td><?php echo $fetchs['name'];?></td>
                                    <td><?php echo $fetchs['mobile'];?></td>
                                    <td><?php echo $row['rate'];?></td>
                                    <td><?php echo $row['msg'];?></td>
                                    
                                   
                                    
                                   
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




          </div>
        </div>

      

      </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    
   <?php 
  require 'include/js.php';
  ?>
   <script>
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [
               {
                extend: 'excelHtml5',
                className: 'btn btn-yahoo btn-sm ',
                text: 'Export',
                filename: 'CustomerRateList_'+new Date().getTime()
               } 
            ]
        } );
   </script>
  </body>


</html>