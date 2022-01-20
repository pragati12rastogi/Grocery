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
                                        <h4 class="card-title">Users List</h4>
                                    </div>
                                    <div class="card-body collapse show">
                                        <div class="card-block card-dashboard">
                                        
                                            <table class="table table-striped table-bordered " id="example">
                                                <thead>
                                                    <tr>
                                                        <th>Sr No.</th>
                                                        <th>Username</th>
                                                        <th>Role</th>
                                                        <th>Area</th>
                                                        <th>Email</th>
                                                        <th>Mobile</th>
                                                        <th>Contact Person</th>
                                                        <th>Shop Name</th>
                                                        <th>Shop Address</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    
                                                      
                                                    $sel = $con->query("select admin.*, role.role_name as rolename, area_db.name as area_name from admin left join role on admin.user_role = role.id left join area_db on admin.area_id = area_db.id where admin.user_role <> '' ");
                                                    $i=0;
                                                    while($row = $sel->fetch_assoc())
                                                    {
                                                        $i= $i + 1;
                                                    ?>
                                                    <tr>
                                                        
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $row['username'];?></td>
                                                        <td><?php echo $row['rolename'];?></td>
                                                        <td><?php echo $row['area_name'];?></td>
                                                        <td><?php echo $row['email'];?></td>
                                                        <td><?php echo $row['mobile'];?></td>
                                                        <td><?php echo $row['contact_person'];?></td>
                                                        <td><?php echo $row['shop_name'];?></td>
                                                        <td><?php echo $row['shop_address'];?></td>
                                                        <td>
                                                        <a class="primary"  href="application-users.php?edit=<?php echo $row['id'];?>" data-original-title="" title="">
                                                                <i class="ft-edit font-medium-3"></i>
                                                            </a>
                                                            
                                                        <a class="danger" href="?dele=<?php echo $row['id'];?>" data-original-title="" title="">
                                                                <i class="ft-trash font-medium-3"></i>
                                                            </a>
                                                            
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
                    <?php 
                    if(isset($_GET['dele']))
                    {
                        $con->query("delete from admin where id=".$_GET['dele']."");
                        
                    ?>
                        <script type="text/javascript">
                    $(document).ready(function() {
                        toastr.options.timeOut = 4500; // 1.5s

                        toastr.error('User Deletes successfully.');
                        setTimeout(function()
                        {
                            window.location.href="categorylist.php";
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
    <script>
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [
               {
                extend: 'excelHtml5',
                className: 'btn btn-yahoo ',
                text: 'Export',
                exportOptions: {
                    columns: [ 0, 1, 2,3,4,5,6,7,8 ]
                },
                filename: 'AdminUserList_'+new Date().getTime()

               } 
            ]
        } );
   </script>
</body>


</html>