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

<section id="dom">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Feedback List</h4>
                </div>
                
                <div class="card-body collapse show">
                    <div class="card-block card-dashboard">
                       
                       
                        <table class="table table-striped table-bordered " id="example">
                            <thead>
                                <tr>
								 <th>Sr No.</th>
                                   
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Rate Star</th>
                                    <th>Message</th>
                                    

                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if($username == 'admin' || $check_menu_customer['view_g'] ==1){
                                    $sel = $con->query("select feedback.* from feedback order by id desc");
                                }else{
                                    $sel = $con->query("select feedback.* from feedback left join user on user.id=feedback.uid  where user.created_by =".$admin_id." order by id desc");
                                }
                                $i=0;
                                while($row = $sel->fetch_assoc())
                                {
                                    $i= $i + 1;
                                ?>
                                <tr>
                                    
                                    <td><?php echo $i; ?></td>
                                    <?php
                                    $fetchs = $con->query("select * from user where id='".$row['uid']."'")->fetch_assoc();
                                    ?>
                                    
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
                filename: 'FeedbackList_'+new Date().getTime()
               } 
            ]
        } );
   </script>
  </body>


</html>